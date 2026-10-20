<?php

/*
|--------------------------------------------------------------------------
| Servicios
|--------------------------------------------------------------------------
|
| Categorías y áreas tomadas de docs/02-content.md (texto del autor).
| "features" lista las áreas de trabajo. Sin precios ni promesas de resultado.
|
*/

return [
    [
        'slug' => 'servidores',
        'name' => 'Tu web, lista para funcionar',
        'short_description' => 'Dejamos en marcha el servidor donde vive tu página o tu programa.',
        'icon' => 'gear',
        'features' => ['Debian/Linux', 'Docker', 'Nginx', 'HTTPS', 'Backups', 'Deploy'],
        'sort_order' => 10,
        'published_at' => '2026-10-16',
    ],
    [
        'slug' => 'infraestructura',
        'name' => 'Una red que funcione como debe',
        'short_description' => 'Revisamos tu red, la vigilamos y buscamos la causa cuando algo falla.',
        'icon' => 'network',
        'features' => ['Redes', 'Monitoreo', 'Diagnóstico', 'Herramientas internas', 'Servidores'],
        'sort_order' => 20,
        'published_at' => '2026-10-16',
    ],
    [
        'slug' => 'desarrollo',
        'name' => 'Un programa hecho para vos',
        'short_description' => 'Creamos aplicaciones web y herramientas a medida, y automatizamos tareas repetitivas.',
        'icon' => 'wrench',
        'features' => ['Aplicaciones web', 'Herramientas internas', 'Automatización', 'Integraciones'],
        'sort_order' => 30,
        'published_at' => '2026-10-16',
    ],
];
