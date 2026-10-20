<?php

/*
|--------------------------------------------------------------------------
| Proyectos del Laboratorio
|--------------------------------------------------------------------------
|
| NO PUBLICADO en la v1: la sección Laboratorio se retiró del sitio público
| (sin rutas, vistas ni enlaces). Estos datos se conservan para el futuro y
| siguen validándose en las pruebas, pero no se muestran en ninguna página.
|
| Descripciones de una línea tomadas de docs/02-content.md (texto del autor).
| Sin estado, tecnologías ni enlaces hasta que el autor los confirme.
|
| Estados válidos: idea, in_development, experimental, active, completed, archived.
|
*/

return [
    [
        'slug' => 'sincnetwork',
        'name' => 'SincNetwork',
        'short_description' => 'Un programa para administrar y vigilar una red de computadoras.',
        'icon' => 'monitor',
        'image_path' => 'illustrations/project-sincnetwork.svg',
        'image_alt' => 'Ilustración provisional: varios dispositivos conectados a un punto central de red.',
        'featured' => true,
        'sort_order' => 10,
        'published_at' => '2026-10-16',
    ],
    [
        'slug' => 'netwatch',
        'name' => 'Netwatch',
        'short_description' => 'Herramientas para encontrar por qué falla una conexión.',
        'icon' => 'search',
        'image_path' => 'illustrations/project-netwatch.svg',
        'image_alt' => 'Ilustración provisional: un monitor que muestra una señal estable y una marca de que todo funciona.',
        'featured' => true,
        'sort_order' => 20,
        'published_at' => '2026-10-16',
    ],
];
