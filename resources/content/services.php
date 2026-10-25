<?php

/*
|--------------------------------------------------------------------------
| Servicios
|--------------------------------------------------------------------------
|
| Categorías y áreas tomadas de docs/02-content.md (texto del autor).
| "features" lista las áreas de trabajo; "description" explica el beneficio para quien consulta. Sin precios ni promesas de resultado.
|
*/

return [
    [
        'slug' => 'servidores',
        'name' => 'Tu web, lista para funcionar',
        'short_description' => 'Ponemos en marcha tu página o tu programa en internet y dejamos la parte técnica configurada para que funcione.',
        'description' => 'Si ya tenés una página o un programa y no sabés cómo dejarlo funcionando en internet, nos ocupamos de la puesta en marcha y la configuración técnica: el servidor, la conexión segura (HTTPS), las copias de seguridad y la publicación de los cambios.',
        'icon' => 'gear',
        'features' => ['Debian/Linux', 'Docker', 'Nginx', 'HTTPS', 'Backups', 'Deploy'],
        'sort_order' => 10,
        'published_at' => '2026-10-16',
    ],
    [
        'slug' => 'infraestructura',
        'name' => 'Una red que funcione como debe',
        'short_description' => 'Revisamos tu red, buscamos la causa de los problemas de conexión y los resolvemos.',
        'description' => 'Si la conexión falla, se corta o algo no se comunica como debería, hacemos el diagnóstico, la configuración y la resolución del problema. También podemos dejar un monitoreo para enterarte a tiempo cuando algo vuelve a fallar.',
        'icon' => 'network',
        'features' => ['Redes', 'Monitoreo', 'Diagnóstico', 'Herramientas internas', 'Servidores'],
        'sort_order' => 20,
        'published_at' => '2026-10-16',
    ],
    [
        'slug' => 'desarrollo',
        'name' => 'Un programa hecho para vos',
        'short_description' => 'Creamos aplicaciones y herramientas a medida para resolver tu necesidad y automatizar las tareas repetitivas.',
        'description' => 'Si hacés siempre la misma tarea a mano, o necesitás un programa que no existe tal como lo precisás, lo desarrollamos a medida: aplicaciones web, herramientas internas, automatizaciones e integraciones entre los sistemas que ya usás.',
        'icon' => 'wrench',
        'features' => ['Aplicaciones web', 'Herramientas internas', 'Automatización', 'Integraciones'],
        'sort_order' => 30,
        'published_at' => '2026-10-16',
    ],
];
