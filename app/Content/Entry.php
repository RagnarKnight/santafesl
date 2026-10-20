<?php

namespace App\Content;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

/**
 * Un elemento del catálogo (producto, servicio o proyecto).
 *
 * Los nombres de las propiedades coinciden con las columnas previstas para una
 * futura tabla, de modo que las vistas no cambien cuando el contenido pase a Eloquent.
 */
final readonly class Entry
{
    public const STATUSES = [
        'products' => [
            'development' => 'En desarrollo',
            'beta' => 'Beta',
            'production' => 'Disponible',
            'completed' => 'Terminado',
            'paused' => 'Pausado',
            'archived' => 'Archivado',
        ],
        'services' => [],
        'projects' => [
            'idea' => 'Idea',
            'in_development' => 'En desarrollo',
            'experimental' => 'Experimental',
            'active' => 'Activo',
            'completed' => 'Completado',
            'archived' => 'Archivado',
        ],
    ];

    /**
     * Iconos propios disponibles (ver resources/views/components/icon.blade.php).
     */
    public const ICONS = ['church', 'bag', 'grid', 'server', 'wifi', 'code', 'chat', 'flask', 'monitor', 'register', 'globe', 'search', 'gear', 'network', 'wrench'];

    /**
     * @param  list<string>  $features
     * @param  list<string>  $technologies
     */
    public function __construct(
        public string $type,
        public string $slug,
        public string $name,
        public string $short_description,
        public ?string $description,
        public ?string $status,
        public array $features,
        public array $technologies,
        public ?string $image_path,
        public ?string $image_alt,
        public bool $featured,
        public int $sort_order,
        public ?Carbon $published_at,
        public ?string $seo_title,
        public ?string $seo_description,
        public ?string $icon = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(string $type, array $data): self
    {
        if (! array_key_exists($type, self::STATUSES)) {
            throw new InvalidArgumentException("Tipo de contenido desconocido: {$type}.");
        }

        foreach (['slug', 'name', 'short_description'] as $required) {
            if (! isset($data[$required]) || ! is_string($data[$required]) || trim($data[$required]) === '') {
                throw new InvalidArgumentException("[{$type}] Falta el campo obligatorio \"{$required}\".");
            }
        }

        $slug = $data['slug'];

        if (! preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug)) {
            throw new InvalidArgumentException("[{$type}] Slug inválido: \"{$slug}\" (solo minúsculas, números y guiones).");
        }

        $status = $data['status'] ?? null;

        if ($status !== null && ! array_key_exists($status, self::STATUSES[$type])) {
            throw new InvalidArgumentException("[{$type}/{$slug}] Estado inválido: \"{$status}\".");
        }

        $icon = $data['icon'] ?? null;

        if ($icon !== null && ! in_array($icon, self::ICONS, true)) {
            throw new InvalidArgumentException("[{$type}/{$slug}] Icono inválido: \"{$icon}\".");
        }

        $imagePath = $data['image_path'] ?? null;
        $imageAlt = $data['image_alt'] ?? null;

        if ($imagePath !== null && $imageAlt === null) {
            throw new InvalidArgumentException("[{$type}/{$slug}] Toda imagen necesita image_alt (usar '' si es decorativa).");
        }

        return new self(
            type: $type,
            slug: $slug,
            name: $data['name'],
            short_description: $data['short_description'],
            description: $data['description'] ?? null,
            status: $status,
            features: array_values($data['features'] ?? []),
            technologies: array_values($data['technologies'] ?? []),
            image_path: $imagePath,
            image_alt: $imageAlt,
            featured: (bool) ($data['featured'] ?? false),
            sort_order: (int) ($data['sort_order'] ?? 0),
            published_at: isset($data['published_at']) ? Carbon::parse($data['published_at']) : null,
            seo_title: $data['seo_title'] ?? null,
            seo_description: $data['seo_description'] ?? null,
            icon: $icon,
        );
    }

    /**
     * Regla única de publicación: con fecha y no futura.
     */
    public function isPublished(?Carbon $now = null): bool
    {
        return $this->published_at !== null && $this->published_at->lte($now ?? Carbon::now());
    }

    public function statusLabel(): ?string
    {
        return $this->status === null ? null : self::STATUSES[$this->type][$this->status];
    }

    public function imageUrl(): ?string
    {
        return $this->image_path === null ? null : Storage::disk('public')->url($this->image_path);
    }

    /**
     * Párrafos de la descripción completa (separados por línea en blanco).
     *
     * @return list<string>
     */
    public function paragraphs(): array
    {
        if ($this->description === null) {
            return [];
        }

        $parts = preg_split('/\R{2,}/', trim($this->description)) ?: [];

        return array_values(array_filter(array_map('trim', $parts), fn (string $p): bool => $p !== ''));
    }

    public function metaTitle(): string
    {
        return $this->seo_title ?? $this->name;
    }

    public function metaDescription(): string
    {
        return $this->seo_description ?? $this->short_description;
    }
}
