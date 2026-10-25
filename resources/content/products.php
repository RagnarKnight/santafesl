<?php

/*
|--------------------------------------------------------------------------
| Productos
|--------------------------------------------------------------------------
|
| Solo contiene lo que el autor confirmó: nombre genérico y qué tipo de
| sistema es. No se publican precios ni capturas reales hasta que existan.
|
| Campos de cada ficha:
|   slug, name, short_description, description, status, icon, image_path + image_alt
|   seo_title, seo_description   Título y descripción para buscadores (únicos por producto)
|   cta_label, cta_anchor        Texto del enlace de la tarjeta y sección de destino (sin #)
|   problem, audience            "Qué problema resuelve" y "Para quién es"
|   features                     4 a 6 funciones. Con features_confirmed = false se muestran como
|                                "funciones de referencia" y la ficha avisa que se confirman en la demostración.
|                                Poner true solo cuando el autor las haya verificado una por una.
|   inquiry_subject, inquiry_action   Arman el mensaje de WhatsApp: "Hola, quisiera conocer más sobre
|                                {inquiry_subject} de SantaFeSL y {inquiry_action}."
|   mockup                       Maqueta HTML/CSS conceptual (church, pos, catalog). NO es una captura real.
|   headline, lead               Título (h1) y bajada propios de la ficha (opcionales)
|   screens, modules             Capturas reales (con su texto) y tarjetas de otros módulos. Con screens la ficha
|                                usa el formato de «showcase». Ver docs/manual/08-productos-y-videos.md
|   video                        null mientras no exista un video real. Ver docs/manual/08-productos-y-videos.md
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
        'headline' => 'CHMS: la gestión de tu iglesia, más organizada',
        'lead' => 'Organizá la información de los miembros, acompañá su proceso de consolidación, gestioná eventos y mantené un seguimiento claro de la tesorería desde un mismo sistema.',
        'description' => "Es un sistema de gestión pensado para iglesias.\n\nTambién se lo conoce como CHMS, que son las siglas en inglés de «sistema de gestión para iglesias».",
        'status' => 'production',
        'icon' => 'church',
        'image_path' => 'illustrations/product-church.png',
        'image_alt' => 'Ilustración provisional: un salón comunitario junto a una lista de tareas y tres personas reunidas.',
        'seo_title' => 'CHMS: sistema de gestión para iglesias',
        'seo_description' => 'CHMS es el sistema de gestión para iglesias de SantaFeSL: miembros, consolidación, eventos y tesorería en un mismo lugar. Mirá cómo se ve y pedí una demostración.',
        'cta_label' => 'Ver cómo funciona',
        'cta_anchor' => 'funcionalidades',
        'problem' => 'Cuando la información y las tareas administrativas están repartidas entre papeles, planillas y mensajes, cuesta encontrar lo que hace falta y mantener el orden.',
        'audience' => 'Iglesias y comunidades que quieren ordenar su administración.',
        'features' => [
            'Panel con indicadores de personas, tesorería y seguimiento de asistencia',
            'Consolidación de personas en cinco etapas',
            'Eventos con inscripciones, capacidad, cobros y fondo común',
            'Tesorería con calendario de ingresos y egresos',
        ],
        // Verificado contra las capturas reales y la especificación funcional de CHMS (Eventos: «fondo común» y «entregas» figuran solo en la captura).
        'features_confirmed' => true,
        'inquiry_subject' => 'el sistema CHMS para iglesias',
        'mockup' => null,
        'video' => null,
        // Capturas reales de CHMS (storage/app/public/products/chms/). Ver docs/manual/08-productos-y-videos.md.
        'screens' => [
            [
                'key' => 'dashboard',
                'image' => 'products/chms/chms-dashboard.webp',
                'alt' => 'Captura real del panel principal de CHMS: un aviso de atención con los miembros que no registraron asistencia, los indicadores de personas, nuevas visitas, miembros activos y balance de tesorería, y el gráfico del proceso de consolidación.',
                'width' => 1336,
                'height' => 582,
                'heading' => 'Todo el panorama de tu iglesia, en una sola pantalla',
                'text' => 'El panel principal reúne lo más importante para empezar el día.',
                'points' => [
                    'Semáforo de atención: lista a los miembros que no registraron asistencia en los últimos 14 días, con un enlace a WhatsApp junto a cada nombre.',
                    'Indicadores de total de personas, nuevas visitas y miembros activos.',
                    'Gráfico y resumen del proceso de consolidación por etapa.',
                    'Balance de tesorería a la vista.',
                    'Los cumpleaños del Mes.',
                    'Peticiones pendientes en el muro de oración.',
                ],
            ],
            [
                'key' => 'consolidacion',
                'image' => 'products/chms/chms-consolidacion.webp',
                'alt' => 'Captura real del módulo de Consolidación de CHMS: un tablero con cinco columnas (Visita, Decisión, Discipulado, Bautismo y Miembro activo) y una ficha por persona con su teléfono y quién la acompaña.',
                'width' => 1345,
                'height' => 578,
                'heading' => 'Acompañá a cada persona en su camino',
                'text' => 'Un tablero con cinco etapas muestra en qué punto está cada persona: Visita, Decisión, Discipulado, Bautismo y Miembro activo. Así ninguna queda sin seguimiento.',
                'points' => [
                    'Cada etapa muestra cuántas personas tiene, y arriba figura el total.',
                    'Cada ficha indica el nombre, el teléfono y quién acompaña a la persona.',
                    'Con los botones de flecha se pasa a una persona a la etapa siguiente o se la devuelve a la anterior, según el rol de cada usuario.',
                    'Las visitas muestran hace cuántos días se registraron, y una nueva se carga con «Nueva Visita».',
                ],
            ],
            [
                'key' => 'eventos',
                'image' => 'products/chms/chms-eventos.webp',
                'alt' => 'Captura real de un evento en CHMS: cantidad de inscriptos, monto a recaudar, monto recaudado con una barra de avance, fondo común, lugares disponibles, responsables y la lista de inscriptos con lo pagado y lo pendiente de cada uno.',
                'width' => 1343,
                'height' => 574,
                'heading' => 'Eventos con inscripciones y cobros claros',
                'text' => 'Cada evento tiene su propia pantalla con la fecha, el costo por persona y el estado de las inscripciones.',
                'points' => [
                    'Cantidad de inscriptos y lugares disponibles sobre la capacidad total.',
                    'Cuánto hay que recaudar, cuánto se recaudó y cuánto falta, con una barra de avance.',
                    'Fondo común del evento.',
                    'Responsables del evento, con su rol.',
                    'Lista de inscriptos con lo pagado y lo pendiente de cada persona, y el registro de cada entrega.',
                ],
            ],
            [
                'key' => 'tesoreria',
                'image' => 'products/chms/chms-tesoreria.webp',
                'alt' => 'Captura real del módulo de Tesorería de CHMS: un calendario con los días de ingresos y egresos marcados, los totales de ingresos, egresos y balance del día, y la lista de movimientos.',
                'width' => 1345,
                'height' => 576,
                'heading' => 'Tesorería con seguimiento claro',
                'text' => 'Un calendario financiero permite ver de un vistazo en qué días hubo movimientos.',
                'points' => [
                    'Los días del calendario se marcan según tuvieron ingresos, egresos o ambos.',
                    'Ingresos, egresos y balance del día seleccionado, con vistas por día, mes e histórico.',
                    'Lista de movimientos con tipo, descripción, categoría, quién los registró y monto.',
                    'Alta de nuevos movimientos desde «Nuevo Movimiento».',
                    'Acceso reservado a administradores y tesoreros.',
                ],
            ],
        ],
        'modules' => [
            ['name' => 'Gestión de miembros', 'text' => 'Ficha de cada persona, con búsqueda, filtro por etapa y diario de seguimiento (notas, llamadas, visitas y oración).', 'icon' => 'users'],
            ['name' => 'Ministerios', 'text' => 'Ministerios agrupados por categoría, con sus integrantes y su líder.', 'icon' => 'network'],
            ['name' => 'Liturgia y asistencia', 'text' => 'Servicios con tema, predicador y presidente, y registro de asistencia de los miembros.', 'icon' => 'calendar'],
            ['name' => 'Inventario', 'text' => 'Bienes agrupados por categoría, con su estado: bueno, regular, en reparación o de baja.', 'icon' => 'box'],
            ['name' => 'Muro de oración', 'text' => 'Peticiones de oración, con las ya atendidas en una sección aparte.', 'icon' => 'heart'],
            ['name' => 'Documentos', 'text' => 'Archivos PDF, imágenes y Word agrupados por categoría.', 'icon' => 'file'],
            ['name' => 'Usuarios, roles y permisos', 'text' => 'Cuentas de administrador, líder, tesorero y diácono, cada una con su propio acceso.', 'icon' => 'shield'],
            ['name' => 'Configuración de la iglesia', 'text' => 'Datos y logo de la iglesia, y categorías propias para cada módulo.', 'icon' => 'gear'],
        ],
        'featured' => true,
        'sort_order' => 10,
        'published_at' => '2026-10-16',
    ],
    [
        'slug' => 'pos',
        'name' => 'Sistema de caja',
        'short_description' => 'Un programa para cobrar y registrar las ventas de un negocio.',
        'description' => "Es un sistema de punto de venta: el programa que se usa en la caja de un negocio.\n\nTambién se lo conoce como POS, por las siglas en inglés de «punto de venta».",
        'status' => 'production',
        'icon' => 'register',
        'image_path' => 'illustrations/product-pos.png',
        'image_alt' => 'Ilustración provisional: un pequeño comercio con una pantalla de ventas.',
        'seo_title' => 'Sistema de caja (POS) para tu negocio',
        'seo_description' => 'Conocé el sistema de caja de SantaFeSL: un programa para registrar las ventas y consultar productos y precios en tu negocio. Pedí una demostración.',
        'cta_label' => 'Explorar funciones',
        'cta_anchor' => 'funciones',
        'problem' => 'Llevar las ventas a mano o en varias planillas lleva tiempo, y es fácil que algo se pierda o no coincida al final del día.',
        'audience' => 'Pequeños negocios que necesitan cobrar y registrar sus ventas.',
        'features' => [
            'Registro de ventas',
            'Consulta de productos',
            'Gestión de precios',
            'Consulta de movimientos',
        ],
        'features_confirmed' => false,
        'inquiry_subject' => 'el sistema de caja',
        'mockup' => 'pos',
        'video' => null,
        'featured' => true,
        'sort_order' => 20,
        'published_at' => '2026-10-16',
    ],
    [
        'slug' => 'catalogo-web',
        'name' => 'Catálogo web',
        'short_description' => 'Una página para mostrar los productos de un negocio.',
        'description' => 'Es un catálogo de productos para la web.',
        'status' => 'production',
        'icon' => 'globe',
        'image_path' => 'illustrations/product-catalog.png',
        'image_alt' => 'Ilustración provisional: una página web y un teléfono mostrando productos de una tienda.',
        'seo_title' => 'Catálogo web de productos para tu negocio',
        'seo_description' => 'Conocé el catálogo web de SantaFeSL: una página para mostrar los productos de tu negocio, con categorías, imágenes y precios, desde el celular. Pedí una demostración.',
        'cta_label' => 'Ver una demostración',
        'cta_anchor' => 'demostracion',
        'problem' => 'Mostrar los productos solo con mensajes o fotos sueltas es poco práctico para quien quiere elegir y para quien tiene que responder una y otra vez.',
        'audience' => 'Negocios que quieren que sus clientes vean sus productos desde el teléfono o la computadora.',
        'features' => [
            'Presentación de los productos del negocio',
            'Organización por categorías',
            'Imágenes y precios a la vista',
            'Acceso cómodo desde el teléfono',
        ],
        'features_confirmed' => false,
        'inquiry_subject' => 'el catálogo web',
        'inquiry_action' => 'consultar cómo podría implementarlo para mi negocio',
        'mockup' => 'catalog',
        'video' => null,
        'featured' => true,
        'sort_order' => 30,
        'published_at' => '2026-10-16',
    ],
];
