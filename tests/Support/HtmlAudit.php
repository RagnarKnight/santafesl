<?php

namespace Tests\Support;

use DOMDocument;
use DOMElement;

/**
 * Auditoría de las restricciones del sitio: sin CSS/JS inline y sin recursos externos.
 *
 * Analiza el DOM (no busca texto), de modo que un enlace <a href="https://github.com/...">
 * o un bloque JSON-LD no se consideran violaciones.
 */
final class HtmlAudit
{
    /** Valores de rel que provocan una descarga del recurso. */
    private const LOADING_RELS = ['stylesheet', 'preload', 'modulepreload', 'prefetch', 'icon', 'apple-touch-icon', 'manifest'];

    /** Tipos de <script> que son datos y no se ejecutan. */
    private const DATA_SCRIPT_TYPES = ['application/ld+json', 'application/json'];

    /** Atributos que cargan un recurso, según la etiqueta. */
    private const RESOURCE_ATTRIBUTES = [
        'script' => ['src'],
        'img' => ['src', 'srcset'],
        'source' => ['src', 'srcset'],
        'iframe' => ['src'],
        'embed' => ['src'],
        'object' => ['data'],
        'audio' => ['src'],
        'video' => ['src', 'poster'],
        'track' => ['src'],
    ];

    /**
     * @return list<string> descripción de cada violación encontrada
     */
    public static function violations(string $html, string $ownHost): array
    {
        $document = new DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $violations = [];

        /** @var DOMElement $element */
        foreach ($document->getElementsByTagName('*') as $element) {
            $tag = strtolower($element->tagName);

            if ($element->hasAttribute('style')) {
                $violations[] = "Atributo style en <{$tag}>";
            }

            foreach ($element->attributes as $attribute) {
                if (preg_match('/^on[a-z]+$/', $attribute->name)) {
                    $violations[] = "Manejador {$attribute->name} en <{$tag}>";
                }

                if (in_array($attribute->name, ['href', 'src', 'action'], true)
                    && preg_match('/^\s*javascript:/i', $attribute->value)) {
                    $violations[] = "URL javascript: en <{$tag}>";
                }
            }

            if ($tag === 'style') {
                $violations[] = 'Elemento <style>';
            }

            if ($tag === 'script' && ! $element->hasAttribute('src')
                && ! in_array(strtolower($element->getAttribute('type')), self::DATA_SCRIPT_TYPES, true)) {
                $violations[] = 'Elemento <script> con código incrustado';
            }

            foreach (self::resourceUrls($element, $tag) as $url) {
                if (self::isExternal($url, $ownHost)) {
                    $violations[] = "Recurso externo en <{$tag}>: {$url}";
                }
            }
        }

        return array_values(array_unique($violations));
    }

    /**
     * Hosts de las URL absolutas http(s) que aparecen en un texto (CSS, JS, vistas, configuración).
     *
     * @param  list<string>  $allowedHosts  hosts que no cuentan: espacios de nombres XML, por ejemplo
     * @return list<string>
     */
    public static function externalHosts(string $content, array $allowedHosts = ['www.w3.org', 'www.sitemaps.org']): array
    {
        preg_match_all('~https?://([a-z0-9.-]+)~i', $content, $matches);

        $hosts = array_map('strtolower', $matches[1]);

        return array_values(array_unique(array_diff($hosts, $allowedHosts)));
    }

    /**
     * @return list<string>
     */
    private static function resourceUrls(DOMElement $element, string $tag): array
    {
        $urls = [];

        if ($tag === 'link') {
            $rels = preg_split('/\s+/', strtolower($element->getAttribute('rel'))) ?: [];

            if (array_intersect($rels, self::LOADING_RELS) !== [] && $element->hasAttribute('href')) {
                $urls[] = $element->getAttribute('href');
            }

            return $urls;
        }

        foreach (self::RESOURCE_ATTRIBUTES[$tag] ?? [] as $attribute) {
            if (! $element->hasAttribute($attribute)) {
                continue;
            }

            $value = $element->getAttribute($attribute);

            if ($attribute === 'srcset') {
                foreach (explode(',', $value) as $candidate) {
                    $urls[] = trim(explode(' ', trim($candidate))[0]);
                }

                continue;
            }

            $urls[] = $value;
        }

        return array_values(array_filter($urls, fn (string $url): bool => $url !== ''));
    }

    private static function isExternal(string $url, string $ownHost): bool
    {
        if (! preg_match('~^(?:https?:)?//~i', $url)) {
            return false;
        }

        $host = parse_url(str_starts_with($url, '//') ? 'https:'.$url : $url, PHP_URL_HOST);

        return strtolower((string) $host) !== strtolower($ownHost);
    }
}
