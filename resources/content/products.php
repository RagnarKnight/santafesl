<?php

/*
|--------------------------------------------------------------------------
| Productos
|--------------------------------------------------------------------------
|
| Solo contiene lo que el autor confirmó: nombre genérico y qué tipo de
| sistema es. No se publican funciones, precios ni capturas hasta que
| existan datos reales. Para completar una ficha, agregar los campos
| (description, features, status, image_path + image_alt) y volver a probar.
|
| Estados válidos: development, beta, production, completed, paused, archived.
| Los tres productos publicados figuran como "Terminado" (completed).
| published_at: null = borrador; fecha (Y-m-d) pasada o actual = publicado.
|
*/

return [
    [
        'slug' => 'chms-iglesias',
        'name' => 'Sistema para iglesias',
        'short_description' => 'Un programa para ayudar a una iglesia a organizarse.',
        'description' => "Es un sistema de gestión pensado para iglesias.\n\nTambién se lo conoce como CHMS, que son las siglas en inglés de «sistema de gestión para iglesias».",
        'status' => 'completed',
        'icon' => 'church',
        'image_path' => 'illustrations/product-church.png',
        'image_alt' => 'Ilustración provisional: un salón comunitario junto a una lista de tareas y tres personas reunidas.',
        'seo_title' => 'Sistema para iglesias (CHMS)',
        'featured' => true,
        'sort_order' => 10,
        'published_at' => '2026-10-16',
    ],
    [
        'slug' => 'pos',
        'name' => 'Sistema de caja',
        'short_description' => 'Un programa para cobrar y registrar las ventas de un negocio.',
        'description' => "Es un sistema de punto de venta: el programa que se usa en la caja de un negocio.\n\nTambién se lo conoce como POS, por las siglas en inglés de «punto de venta».",
        'status' => 'completed',
        'icon' => 'register',
        'image_path' => 'illustrations/product-pos.png',
        'image_alt' => 'Ilustración provisional: un pequeño comercio con una pantalla de ventas.',
        'seo_title' => 'Sistema de caja (POS)',
        'featured' => true,
        'sort_order' => 20,
        'published_at' => '2026-10-16',
    ],
    [
        'slug' => 'catalogo-web',
        'name' => 'Catálogo web',
        'short_description' => 'Una página para mostrar los productos de un negocio.',
        'description' => 'Es un catálogo de productos para la web.',
        'status' => 'completed',
        'icon' => 'globe',
        'image_path' => 'illustrations/product-catalog.png',
        'image_alt' => 'Ilustración provisional: una página web y un teléfono mostrando productos de una tienda.',
        'seo_title' => 'Catálogo web de productos',
        'featured' => true,
        'sort_order' => 30,
        'published_at' => '2026-10-16',
    ],
];
