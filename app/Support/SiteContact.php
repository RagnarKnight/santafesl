<?php

namespace App\Support;

/**
 * Canales de contacto del sitio: correo y WhatsApp.
 *
 * Única fuente: config/site.php, que lee SITE_CONTACT_EMAIL y SITE_CONTACT_WHATSAPP
 * del archivo .env. Las vistas solo usan esta clase, nunca escriben el dato.
 *
 * Los valores de ejemplo (los del .env.example) se reconocen y nunca se muestran
 * como contacto real: en producción se ocultan; en otros entornos se muestran
 * con la marca "ejemplo".
 */
final class SiteContact
{
    /** Número de ejemplo documentado: no pertenece a nadie. */
    public const EXAMPLE_WHATSAPP = '5490000000000';

    /** Dominios reservados para ejemplos (RFC 2606). */
    private const EXAMPLE_DOMAINS = ['example.com', 'example.org', 'example.net'];

    public function __construct(
        private readonly ?string $email,
        private readonly ?string $whatsapp,
        private readonly ?string $whatsappMessage,
        private readonly bool $production,
    ) {}

    public static function fromConfig(): self
    {
        $email = config('site.contact.email');
        $whatsapp = config('site.contact.whatsapp');
        $message = config('site.contact.whatsapp_message');

        return new self(
            is_string($email) ? trim($email) : null,
            is_string($whatsapp) || is_int($whatsapp) ? (string) $whatsapp : null,
            is_string($message) ? trim($message) : null,
            app()->isProduction(),
        );
    }

    /** Correo válido y visible, o null. */
    public function email(): ?string
    {
        $email = $this->validEmail();

        return $email !== null && ! ($this->production && $this->emailIsExample()) ? $email : null;
    }

    public function emailIsExample(): bool
    {
        $email = $this->validEmail();

        return $email !== null && in_array(strtolower(substr(strrchr($email, '@'), 1)), self::EXAMPLE_DOMAINS, true);
    }

    /** Enlace directo oficial de WhatsApp (https://wa.me/<número>), o null. */
    public function whatsappUrl(): ?string
    {
        $digits = $this->digits();

        if ($digits === null || ($this->production && $this->whatsappIsExample())) {
            return null;
        }

        $url = 'https://wa.me/'.$digits;

        return filled($this->whatsappMessage) ? $url.'?text='.rawurlencode($this->whatsappMessage) : $url;
    }

    /** Es de ejemplo el número documentado o cualquiera que termine en ocho ceros (formato ficticio). */
    public function whatsappIsExample(): bool
    {
        $digits = $this->digits();

        return $digits !== null && ($digits === self::EXAMPLE_WHATSAPP || preg_match('/0{8}$/', $digits) === 1);
    }

    public function hasAny(): bool
    {
        return $this->email() !== null || $this->whatsappUrl() !== null;
    }

    private function validEmail(): ?string
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false ? $this->email : null;
    }

    /** Número en formato internacional: solo dígitos, entre 8 y 15 (norma E.164). */
    private function digits(): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $this->whatsapp);

        return $digits !== '' && strlen($digits) >= 8 && strlen($digits) <= 15 ? $digits : null;
    }
}
