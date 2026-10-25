<?php

/*
|--------------------------------------------------------------------------
| Datos del sitio
|--------------------------------------------------------------------------
|
| Datos transversales de SantaFeSL. Los canales de contacto dependen del
| entorno y se leen de variables de entorno: no se escriben en el repositorio.
| Un canal sin valor simplemente no se muestra.
|
*/

return [

    'name' => 'SantaFeSL',

    'tagline' => 'Tecnología simple para problemas reales.',

    'intro' => 'Programas, páginas web y tecnología para pequeños negocios y personas.',

    'descriptor' => 'Software, servidores y tecnología para pequeños negocios y personas.',

    // Ilustración de la portada (provisional). Para cambiarla, reemplazar el archivo o esta ruta.
    'hero' => [
        'image' => 'illustrations/hero-technology1.png',
        'alt' => 'Ilustración provisional: un pequeño comercio, una computadora y un teléfono.',
        'width' => 520,
        'height' => 440,
    ],

    // Dominios desde los que se permite incrustar un video externo (se agregan a la CSP como frame-src).
    // Vacío = solo videos locales. Ejemplo: ['www.youtube-nocookie.com']. Ver docs/manual/08-productos-y-videos.md
    'video_hosts' => [],

    // Única fuente del contacto. Se cambia en el archivo .env (ver docs/manual/04-contacto.md).
    'contact' => [
        'email' => env('SITE_CONTACT_EMAIL'),
        // Solo dígitos con código de país, sin "+", espacios ni paréntesis. Ejemplo ficticio: 5490000000000
        'whatsapp' => env('SITE_CONTACT_WHATSAPP'),
        // Mensaje con el que se abre la conversación de WhatsApp (puede quedar vacío).
        'whatsapp_message' => env('SITE_CONTACT_WHATSAPP_MESSAGE', 'Hola, quiero consultar por los servicios de SantaFeSL.'),
    ],

];
