<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cabeceras de seguridad para un sitio público sin CSS ni JS inline.
 *
 * La CSP estricta no se aplica en el entorno local para no bloquear el
 * servidor de desarrollo de Vite (otro origen y websockets).
 */
class SecurityHeaders
{
    public const CONTENT_SECURITY_POLICY = "default-src 'self'; script-src 'self'; style-src 'self'; "
        ."img-src 'self' data:; font-src 'self'; connect-src 'self'; object-src 'none'; "
        ."base-uri 'self'; form-action 'self'; frame-ancestors 'none'";

    /**
     * La política estricta. Solo si config/site.php lista dominios en 'video_hosts' se agrega
     * frame-src para esos dominios (videos de un proveedor externo); sin ellos no cambia nada.
     */
    public static function policy(): string
    {
        $hosts = array_values(array_filter(
            (array) config('site.video_hosts', []),
            fn ($host): bool => is_string($host) && preg_match('/^[a-z0-9]([a-z0-9.-]*[a-z0-9])?$/i', $host) === 1,
        ));

        if ($hosts === []) {
            return self::CONTENT_SECURITY_POLICY;
        }

        return self::CONTENT_SECURITY_POLICY.'; frame-src '.implode(' ', array_map(fn (string $h): string => 'https://'.$h, $hosts));
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        if (! app()->environment('local')) {
            $response->headers->set('Content-Security-Policy', self::policy());
        }

        return $response;
    }
}
