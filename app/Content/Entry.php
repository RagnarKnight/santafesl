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
    /** Maquetas de interfaz disponibles (ver resources/views/components/product/mockup.blade.php). */
    public const MOCKUPS = ['church', 'pos', 'catalog'];

    public const VIDEO_PROVIDERS = ['local', 'embed'];

    public const ICONS = ['church', 'bag', 'grid', 'server', 'wifi', 'code', 'chat', 'flask', 'monitor', 'register', 'globe', 'search', 'gear', 'network', 'wrench', 'users', 'calendar', 'box', 'heart', 'file', 'shield'];

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
        public ?string $problem = null,
        public ?string $audience = null,
        public ?string $cta_label = null,
        public ?string $cta_anchor = null,
        public bool $features_confirmed = false,
        public ?string $inquiry_subject = null,
        public ?string $inquiry_action = null,
        public ?string $mockup = null,
        /** @var array{provider: string, title: string, poster: string, orientation: string, src: ?string, url: ?string, description: ?string}|null */
        public ?array $video = null,
        public ?string $headline = null,
        public ?string $lead = null,
        /** @var list<array{key: string, image: string, alt: string, width: int, height: int, heading: string, text: string, points: list<string>, layout: string, mobile: array{image: string, width: int, height: int}|null}> */
        public array $screens = [],
        /** @var list<array{name: string, text: string, icon: string}> */
        public array $modules = [],
        public ?string $short_name = null,
        /** @var array{image: string, alt: string, width: int, height: int, mobile: array{image: string, width: int, height: int}|null}|null */
        public ?array $hero_image = null,
        /** @var list<array{type: string, id: string, title: string, lead: ?string, items: list<array{title: ?string, text: string}>, note: ?string}> */
        public array $intro_sections = [],
        /** @var list<array{type: string, id: string, title: string, lead: ?string, items: list<array{title: ?string, text: string}>, note: ?string}> */
        public array $outro_sections = [],
        public bool $video_placeholder = false,
        public ?string $cta_title = null,
        public ?string $cta_text = null,
        public ?string $cta_button = null,
        public ?string $explore_label = null,
        public ?string $explore_anchor = null,
        public ?string $screens_note = null,
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

        $mockup = $data['mockup'] ?? null;

        if ($mockup !== null && ! in_array($mockup, self::MOCKUPS, true)) {
            throw new InvalidArgumentException("[{$type}/{$slug}] Maqueta inválida: \"{$mockup}\".");
        }

        $cta_anchor = $data['cta_anchor'] ?? null;

        if ($cta_anchor !== null && ! preg_match('/^[a-z][a-z0-9-]*$/', $cta_anchor)) {
            throw new InvalidArgumentException("[{$type}/{$slug}] cta_anchor inválido: \"{$cta_anchor}\" (sin #, solo minúsculas, números y guiones).");
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
            problem: $data['problem'] ?? null,
            audience: $data['audience'] ?? null,
            cta_label: $data['cta_label'] ?? null,
            cta_anchor: $cta_anchor,
            features_confirmed: (bool) ($data['features_confirmed'] ?? false),
            inquiry_subject: $data['inquiry_subject'] ?? null,
            inquiry_action: $data['inquiry_action'] ?? null,
            mockup: $mockup,
            video: self::video($type, $slug, $data['video'] ?? null),
            headline: $data['headline'] ?? null,
            lead: $data['lead'] ?? null,
            screens: self::screens($type, $slug, $data['screens'] ?? []),
            modules: self::modules($type, $slug, $data['modules'] ?? []),
            short_name: $data['short_name'] ?? null,
            hero_image: self::heroImage($type, $slug, $data['hero_image'] ?? null),
            intro_sections: self::sections($type, $slug, $data['intro_sections'] ?? []),
            outro_sections: self::sections($type, $slug, $data['outro_sections'] ?? []),
            video_placeholder: (bool) ($data['video_placeholder'] ?? false),
            cta_title: $data['cta_title'] ?? null,
            cta_text: $data['cta_text'] ?? null,
            cta_button: $data['cta_button'] ?? null,
            explore_label: $data['explore_label'] ?? null,
            explore_anchor: $data['explore_anchor'] ?? null,
            screens_note: $data['screens_note'] ?? null,
        );
    }

    /**
     * Capturas reales del producto, cada una con su explicación.
     *
     * Cada captura puede llevar «layout» (stack: texto arriba e imagen abajo, por defecto; split: texto e
     * imagen lado a lado, alternando) y «mobile»: otra captura real que se muestra en pantallas chicas.
     *
     * @return list<array{key: string, image: string, alt: string, width: int, height: int, heading: string, text: string, points: list<string>, layout: string, mobile: array{image: string, width: int, height: int}|null}>
     */
    private static function screens(string $type, string $slug, mixed $screens): array
    {
        $result = [];

        foreach ((array) $screens as $i => $screen) {
            foreach (['key', 'image', 'alt', 'heading', 'text'] as $required) {
                if (! isset($screen[$required]) || ! is_string($screen[$required]) || trim($screen[$required]) === '') {
                    throw new InvalidArgumentException("[{$type}/{$slug}] Captura #{$i}: falta \"{$required}\".");
                }
            }

            if (! isset($screen['width'], $screen['height']) || (int) $screen['width'] < 1 || (int) $screen['height'] < 1) {
                throw new InvalidArgumentException("[{$type}/{$slug}] Captura \"{$screen['key']}\": faltan width y height.");
            }

            $layout = $screen['layout'] ?? 'stack';

            if (! in_array($layout, self::SCREEN_LAYOUTS, true)) {
                throw new InvalidArgumentException("[{$type}/{$slug}] Captura \"{$screen['key']}\": \"layout\" debe ser stack o split.");
            }

            $result[] = [
                'key' => $screen['key'],
                'image' => $screen['image'],
                'alt' => $screen['alt'],
                'width' => (int) $screen['width'],
                'height' => (int) $screen['height'],
                'heading' => $screen['heading'],
                'text' => $screen['text'],
                'points' => array_values($screen['points'] ?? []),
                'layout' => $layout,
                'mobile' => self::mobileShot($type, $slug, "captura \"{$screen['key']}\"", $screen['mobile'] ?? null),
            ];
        }

        return $result;
    }

    /**
     * Otros módulos del producto (tarjetas compactas).
     *
     * @return list<array{name: string, text: string, icon: string}>
     */
    private static function modules(string $type, string $slug, mixed $modules): array
    {
        $result = [];

        foreach ((array) $modules as $module) {
            if (! isset($module['name'], $module['text']) || ! in_array($module['icon'] ?? null, self::ICONS, true)) {
                throw new InvalidArgumentException("[{$type}/{$slug}] Módulo inválido: necesita name, text e icon válido.");
            }

            $result[] = ['name' => $module['name'], 'text' => $module['text'], 'icon' => $module['icon']];
        }

        return $result;
    }

    public const SECTION_TYPES = ['cards', 'steps', 'checks'];

    public const SCREEN_LAYOUTS = ['stack', 'split'];

    /**
     * Versión para pantallas chicas de una captura (otra captura real de la misma pantalla, por ejemplo la
     * del celular). Comparte el texto alternativo de la captura principal, porque ambas muestran lo mismo.
     *
     * @return array{image: string, width: int, height: int}|null
     */
    private static function mobileShot(string $type, string $slug, string $where, mixed $mobile): ?array
    {
        if ($mobile === null) {
            return null;
        }

        if (! isset($mobile['image']) || ! is_string($mobile['image']) || trim($mobile['image']) === '') {
            throw new InvalidArgumentException("[{$type}/{$slug}] {$where}: la versión «mobile» necesita \"image\".");
        }

        if ((int) ($mobile['width'] ?? 0) < 1 || (int) ($mobile['height'] ?? 0) < 1) {
            throw new InvalidArgumentException("[{$type}/{$slug}] {$where}: la versión «mobile» necesita width y height.");
        }

        return ['image' => $mobile['image'], 'width' => (int) $mobile['width'], 'height' => (int) $mobile['height']];
    }

    /**
     * Imagen principal de la ficha (por ejemplo, un collage del producto).
     *
     * Con «mobile» se muestra otra captura real en pantallas chicas (sin deslizar la imagen).
     *
     * @return array{image: string, alt: string, width: int, height: int, mobile: array{image: string, width: int, height: int}|null}|null
     */
    private static function heroImage(string $type, string $slug, mixed $hero): ?array
    {
        if ($hero === null) {
            return null;
        }

        foreach (['image', 'alt'] as $required) {
            if (! isset($hero[$required]) || ! is_string($hero[$required]) || trim($hero[$required]) === '') {
                throw new InvalidArgumentException("[{$type}/{$slug}] hero_image: falta \"{$required}\".");
            }
        }

        if ((int) ($hero['width'] ?? 0) < 1 || (int) ($hero['height'] ?? 0) < 1) {
            throw new InvalidArgumentException("[{$type}/{$slug}] hero_image: faltan width y height.");
        }

        return [
            'image' => $hero['image'],
            'alt' => $hero['alt'],
            'width' => (int) $hero['width'],
            'height' => (int) $hero['height'],
            'mobile' => self::mobileShot($type, $slug, 'hero_image', $hero['mobile'] ?? null),
        ];
    }

    /**
     * Bloques de texto de la ficha: tarjetas (cards), pasos numerados (steps) o lista con tildes (checks).
     * En "checks" cada ítem puede ser un texto simple.
     *
     * @return list<array{type: string, id: string, title: string, lead: ?string, items: list<array{title: ?string, text: string}>, note: ?string}>
     */
    private static function sections(string $type, string $slug, mixed $sections): array
    {
        $result = [];

        foreach ((array) $sections as $section) {
            $kind = $section['type'] ?? null;

            if (! in_array($kind, self::SECTION_TYPES, true)) {
                throw new InvalidArgumentException("[{$type}/{$slug}] Sección: \"type\" debe ser cards, steps o checks.");
            }

            if (! isset($section['id'], $section['title']) || ! preg_match('/^[a-z][a-z0-9-]*$/', (string) $section['id'])) {
                throw new InvalidArgumentException("[{$type}/{$slug}] Sección: necesita \"title\" e \"id\" válido (minúsculas y guiones).");
            }

            $items = [];

            foreach ((array) ($section['items'] ?? []) as $item) {
                $item = is_string($item) ? ['text' => $item] : $item;

                if (! isset($item['text']) || ! is_string($item['text']) || trim($item['text']) === '') {
                    throw new InvalidArgumentException("[{$type}/{$slug}] Sección \"{$section['id']}\": cada ítem necesita \"text\".");
                }

                if ($kind !== 'checks' && ! isset($item['title'])) {
                    throw new InvalidArgumentException("[{$type}/{$slug}] Sección \"{$section['id']}\": cada ítem necesita \"title\".");
                }

                $items[] = ['title' => $item['title'] ?? null, 'text' => $item['text']];
            }

            if ($items === []) {
                throw new InvalidArgumentException("[{$type}/{$slug}] Sección \"{$section['id']}\" sin ítems.");
            }

            $result[] = ['type' => $kind, 'id' => $section['id'], 'title' => $section['title'], 'lead' => $section['lead'] ?? null, 'items' => $items, 'note' => $section['note'] ?? null];
        }

        return $result;
    }

    /** Nombre corto para los textos de la ficha (por ejemplo, «CHMS»). */
    public function brand(): string
    {
        return $this->short_name ?? $this->name;
    }

    /** Captura de una pantalla por su clave, o null. */
    public function screen(string $key): ?array
    {
        foreach ($this->screens as $screen) {
            if ($screen['key'] === $key) {
                return $screen;
            }
        }

        return null;
    }

    /**
     * Valida el video de un producto. Sin video (null) la ficha muestra la alternativa visual.
     *
     * @return array{provider: string, title: string, poster: string, orientation: string, src: ?string, url: ?string, description: ?string}|null
     */
    private static function video(string $type, string $slug, mixed $video): ?array
    {
        if ($video === null) {
            return null;
        }

        if (! is_array($video)) {
            throw new InvalidArgumentException("[{$type}/{$slug}] \"video\" debe ser un arreglo o null.");
        }

        $provider = $video['provider'] ?? null;

        if (! in_array($provider, self::VIDEO_PROVIDERS, true)) {
            throw new InvalidArgumentException("[{$type}/{$slug}] Video: \"provider\" debe ser local o embed.");
        }

        foreach (['title', 'poster'] as $required) {
            if (! isset($video[$required]) || ! is_string($video[$required]) || trim($video[$required]) === '') {
                throw new InvalidArgumentException("[{$type}/{$slug}] Video: falta \"{$required}\".");
            }
        }

        $orientation = $video['orientation'] ?? 'horizontal';

        if (! in_array($orientation, ['horizontal', 'vertical'], true)) {
            throw new InvalidArgumentException("[{$type}/{$slug}] Video: \"orientation\" debe ser horizontal o vertical.");
        }

        $src = $video['src'] ?? null;
        $url = $video['url'] ?? null;

        if ($provider === 'local' && (! is_string($src) || trim($src) === '')) {
            throw new InvalidArgumentException("[{$type}/{$slug}] Video local: falta \"src\".");
        }

        if ($provider === 'embed' && (! is_string($url) || ! str_starts_with($url, 'https://') || filter_var($url, FILTER_VALIDATE_URL) === false)) {
            throw new InvalidArgumentException("[{$type}/{$slug}] Video embed: \"url\" debe ser una dirección https válida.");
        }

        return [
            'provider' => $provider,
            'title' => $video['title'],
            'poster' => $video['poster'],
            'orientation' => $orientation,
            'src' => $provider === 'local' ? $src : null,
            'url' => $provider === 'embed' ? $url : null,
            'description' => isset($video['description']) && is_string($video['description']) ? $video['description'] : null,
        ];
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

    /**
     * Mensaje con el que se abre WhatsApp para consultar por este producto.
     * Se arma con los datos del propio producto (inquiry_subject / inquiry_action).
     */
    public function inquiryMessage(): string
    {
        $subject = $this->inquiry_subject ?? $this->name;
        $action = $this->inquiry_action ?? 'solicitar una demostración';

        return 'Hola, quisiera conocer más sobre '.$subject.' de '.config('site.name').' y '.$action.'.';
    }

    /** Texto de la llamada a la acción de la tarjeta. */
    public function ctaLabel(): string
    {
        return $this->cta_label ?? 'Conocer más';
    }

    public function posterUrl(): ?string
    {
        return $this->video === null ? null : Storage::disk('public')->url($this->video['poster']);
    }

    public function pageTitle(): string
    {
        return $this->headline ?? $this->name;
    }

    public function pageLead(): string
    {
        return $this->lead ?? $this->short_description;
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
