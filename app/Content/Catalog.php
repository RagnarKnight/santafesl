<?php

namespace App\Content;

use InvalidArgumentException;

/**
 * Única puerta de lectura del contenido (productos, servicios y proyectos).
 *
 * Hoy lee archivos PHP de resources/content. Cuando el contenido pase a la base
 * de datos, solo cambia esta clase: controladores y vistas siguen igual.
 */
final class Catalog
{
    public const PRODUCTS = 'products';

    public const SERVICES = 'services';

    public const PROJECTS = 'projects';

    private readonly string $path;

    /** @var array<string, list<Entry>> */
    private array $loaded = [];

    public function __construct(?string $path = null)
    {
        $this->path = $path ?? resource_path('content');
    }

    /** @return list<Entry> */
    public function products(): array
    {
        return $this->all(self::PRODUCTS);
    }

    /** @return list<Entry> */
    public function featuredProducts(): array
    {
        return $this->featured(self::PRODUCTS);
    }

    public function product(string $slug): ?Entry
    {
        return $this->find(self::PRODUCTS, $slug);
    }

    /** @return list<Entry> */
    public function services(): array
    {
        return $this->all(self::SERVICES);
    }

    /** @return list<Entry> */
    public function projects(): array
    {
        return $this->all(self::PROJECTS);
    }

    public function project(string $slug): ?Entry
    {
        return $this->find(self::PROJECTS, $slug);
    }

    /**
     * Elementos publicados (o todos, incluidos borradores) ordenados por sort_order y nombre.
     *
     * @return list<Entry>
     */
    public function all(string $type, bool $publishedOnly = true): array
    {
        $entries = $this->load($type);

        if ($publishedOnly) {
            $entries = array_values(array_filter($entries, fn (Entry $e): bool => $e->isPublished()));
        }

        usort($entries, fn (Entry $a, Entry $b): int => [$a->sort_order, $a->name] <=> [$b->sort_order, $b->name]);

        return $entries;
    }

    /** @return list<Entry> */
    private function featured(string $type): array
    {
        return array_values(array_filter($this->all($type), fn (Entry $e): bool => $e->featured));
    }

    private function find(string $type, string $slug): ?Entry
    {
        foreach ($this->all($type) as $entry) {
            if ($entry->slug === $slug) {
                return $entry;
            }
        }

        return null;
    }

    /** @return list<Entry> */
    private function load(string $type): array
    {
        if (isset($this->loaded[$type])) {
            return $this->loaded[$type];
        }

        $file = "{$this->path}/{$type}.php";

        if (! is_file($file)) {
            throw new InvalidArgumentException("No existe el archivo de contenido: {$file}.");
        }

        $rows = require $file;

        if (! is_array($rows)) {
            throw new InvalidArgumentException("{$file} debe devolver un arreglo.");
        }

        $entries = [];
        $slugs = [];

        foreach ($rows as $row) {
            $entry = Entry::fromArray($type, $row);

            if (isset($slugs[$entry->slug])) {
                throw new InvalidArgumentException("[{$type}] Slug duplicado: \"{$entry->slug}\".");
            }

            $slugs[$entry->slug] = true;
            $entries[] = $entry;
        }

        return $this->loaded[$type] = $entries;
    }
}
