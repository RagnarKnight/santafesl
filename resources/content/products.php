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
|   short_name, cta_title, cta_text, cta_button, explore_label, explore_anchor, screens_note, video_placeholder
|                                Textos y opciones de la ficha con capturas (todos opcionales)
|   hero_image                   Imagen principal bajo el título (collage del producto)
|   intro_sections, outro_sections  Bloques de texto antes y después de las capturas (cards, steps o checks)
|   video                        null mientras no exista un video real. Ver docs/manual/08-productos-y-videos.md
|
| Estados válidos: development, beta, production, completed, paused, archived.
| Los productos publicados figuran como "Terminado" (completed).
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
        'status' => 'completed',
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
        'short_name' => 'CHMS',
        'video_placeholder' => true,
        'screens_note' => 'Los datos que se ven son de ejemplo.',
        'cta_title' => '¿Querés conocer CHMS en funcionamiento?',
        'cta_text' => 'Contanos qué necesita tu iglesia y coordinamos una demostración para que conozcas cómo funciona el sistema.',
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
        'status' => 'completed',
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
        'slug' => 'pediwa',
        'name' => 'Pediwa',
        'short_name' => 'Pediwa',
        'short_description' => 'Un catálogo digital para vender por WhatsApp.',
        'headline' => 'Tu catálogo digital, listo para vender por WhatsApp.',
        'lead' => 'Mostrá tus productos, organizá tu catálogo y recibí pedidos por WhatsApp. Una forma sencilla de digitalizar tu kiosco, almacén o pequeño comercio.',
        'description' => 'Es un catálogo digital para kioscos, almacenes y pequeños comercios. Tus clientes ven los productos, arman su pedido y lo envían por WhatsApp.',
        'status' => 'completed',
        'icon' => 'bag',
        'image_path' => 'illustrations/product-pediwa.png',
        'image_alt' => 'Cinco celulares con catálogos de ejemplo hechos con Pediwa: comida, indumentaria, kiosco, verdulería y tecnología.',
        'seo_title' => 'Pediwa: catálogo digital para vender por WhatsApp',
        'seo_description' => 'Pediwa es un catálogo digital para kioscos, almacenes y pequeños comercios: mostrás tus productos y tus clientes arman el pedido y lo envían por WhatsApp.',
        'cta_label' => 'Ver cómo funciona',
        'cta_anchor' => 'como-funciona',
        'problem' => 'Mostrar los productos con fotos sueltas y tomar cada pedido mensaje por mensaje lleva tiempo.',
        'audience' => 'Kioscos, almacenes y pequeños comercios argentinos.',
        'features' => [
            'Catálogo de productos con categorías y búsqueda',
            'Ofertas y productos destacados',
            'Carrito del cliente y pedido por WhatsApp',
            'Panel para administrar productos, categorías y banners',
        ],
        'features_confirmed' => true,
        'inquiry_subject' => 'Pediwa',
        'inquiry_action' => 'consultar cómo podría usarlo en mi negocio',
        'cta_button' => 'Consultar por WhatsApp',
        'cta_title' => 'Empezá a mostrar tu negocio de otra manera.',
        'cta_text' => 'Conocé Pediwa y descubrí cómo presentar tus productos en un catálogo digital sencillo para tus clientes.',
        'explore_label' => 'Conocer cómo funciona',
        'explore_anchor' => 'como-funciona',
        'mockup' => null,
        'video' => null,
        'hero_image' => [
            'image' => 'products/pediwa/pediwa-catalogos.webp',
            'alt' => 'Cinco celulares con catálogos de ejemplo hechos con Pediwa: una comida rápida (Sabor Express), una tienda de ropa (Boutique Elegance), un kiosco (Kiosco El Rincón), una verdulería (Verdulería La Huerta) y una tienda de tecnología (TecnoStore).',
            'width' => 2000,
            'height' => 810,
        ],
        'intro_sections' => [
            [
                'type' => 'cards',
                'id' => 'rubros',
                'title' => 'Un catálogo para tu tipo de negocio',
                'lead' => 'Los celulares de arriba son catálogos de ejemplo de distintos rubros. Cada comercio arma el suyo con sus propios productos y categorías.',
                'items' => [
                    ['title' => 'Kioscos y almacenes', 'text' => 'Categorías como Almacén, Bebidas, Lácteos y Limpieza, con productos en oferta.'],
                    ['title' => 'Indumentaria', 'text' => 'Categorías como Remeras, Pantalones, Camperas y Accesorios.'],
                    ['title' => 'Comida', 'text' => 'Categorías como Pizzas, Milanesas, Sandwiches y Pastas.'],
                    ['title' => 'Frutas y verduras', 'text' => 'Categorías como Frutas y Verduras, y una sección de Ofertas.'],
                    ['title' => 'Tecnología', 'text' => 'Categorías como Computación, Celulares, Electrodomésticos y Accesorios.'],
                ],
            ],
        ],
        'screens' => [
            [
                'key' => 'panel',
                'image' => 'products/pediwa/pediwa-panel.webp',
                'alt' => 'Captura real del panel de control de Pediwa: indicadores de productos, disponibles, sin stock, ofertas, destacados y pausados, visitas y clics en WhatsApp del día, y un gráfico de actividad de los últimos 7 días.',
                'width' => 1349,
                'height' => 580,
                'heading' => 'Un panel para ver cómo va tu catálogo',
                'text' => 'El panel de control muestra los indicadores del catálogo y da acceso a las secciones de administración.',
                'points' => [
                    'Indicadores de productos: total, disponibles, sin stock, en oferta, destacados y pausados.',
                    'Visitas y clics en WhatsApp del día, con un gráfico de la actividad de los últimos 7 días.',
                    'Menú lateral para entrar a Productos, Categorías, Banners, Configuración y Usuarios, y un enlace para ver el catálogo.',
                ],
            ],
            [
                'key' => 'productos',
                'image' => 'products/pediwa/pediwa-productos.webp',
                'alt' => 'Captura real de la administración de productos de Pediwa: una tabla con la foto, el nombre, la categoría y el precio de cada producto, una oferta con su descuento, y botones para stock, destacado, pausa, edición y borrado.',
                'width' => 1349,
                'height' => 578,
                'heading' => 'Tus productos y precios, siempre al día',
                'text' => 'Una tabla reúne todos los productos con su foto, su categoría y su precio.',
                'points' => [
                    'Las ofertas muestran el precio de oferta y el porcentaje de descuento, y se pueden desactivar.',
                    'Con un botón se controla si el producto tiene stock, si es destacado y si está pausado.',
                    'Cada producto se puede editar o eliminar.',
                ],
            ],
            [
                'key' => 'banners',
                'image' => 'products/pediwa/pediwa-banners.webp',
                'alt' => 'Captura real de la administración de banners de Pediwa: una lista de cuatro banners con su imagen, título y estado, y un formulario para crear uno nuevo con título opcional e imagen.',
                'width' => 1348,
                'height' => 582,
                'heading' => 'Administrá los banners de tu catálogo',
                'text' => 'Desde esta pantalla se cargan, se pausan y se eliminan los banners.',
                'points' => [
                    'La lista muestra la imagen, el título y el estado de cada banner.',
                    'Para crear uno se carga una imagen (JPG, PNG o WebP, de hasta 4 MB) y, si se quiere, un título.',
                    'Se recomienda una imagen horizontal, por ejemplo de 1200 × 600.',
                ],
            ],
            [
                'key' => 'categorias',
                'image' => 'products/pediwa/pediwa-categorias.webp',
                'alt' => 'Captura real de la administración de categorías de Pediwa: una lista con el ícono, el nombre, la cantidad de productos y el estado de cada categoría, y un formulario para crear una nueva con ícono emoji y nombre.',
                'width' => 1338,
                'height' => 578,
                'heading' => 'Categorías para que tus clientes encuentren todo',
                'text' => 'Organizá tus productos en categorías para que sea más fácil recorrer el catálogo.',
                'points' => [
                    'Cada categoría tiene un ícono (un emoji) y un nombre.',
                    'La lista indica cuántos productos tiene cada una y si está activa.',
                    'Se crean desde un formulario, con íconos sugeridos, y se pueden editar o eliminar.',
                ],
            ],
        ],
        'outro_sections' => [
            [
                'type' => 'steps',
                'id' => 'como-funciona',
                'title' => 'Cómo funciona',
                'lead' => 'Tus clientes piden en tres pasos.',
                'items' => [
                    ['title' => 'El cliente explora el catálogo', 'text' => 'Ve los productos y navega por las categorías.'],
                    ['title' => 'Arma su carrito', 'text' => 'Selecciona los productos y las cantidades que quiere pedir.'],
                    ['title' => 'Envía el pedido por WhatsApp', 'text' => 'Pediwa prepara el mensaje con los productos y los importes para que el cliente lo envíe al comercio.'],
                ],
                'note' => 'Pediwa no es una tienda online con pagos integrados: el carrito se guarda en el navegador del cliente y el pedido se comunica por WhatsApp. El comerciante continúa la venta manualmente.',
            ],
            [
                'type' => 'checks',
                'id' => 'beneficios',
                'title' => 'Lo que te ofrece Pediwa',
                'items' => [
                    'Mostrá tus productos desde un catálogo digital.',
                    'Organizá los productos por categorías.',
                    'Destacá ofertas y productos seleccionados.',
                    'Permití que tus clientes armen su pedido desde el celular.',
                    'Recibí los pedidos mediante WhatsApp.',
                    'Administrá el catálogo desde el panel correspondiente.',
                ],
            ],
        ],
        'featured' => true,
        'sort_order' => 30,
        'published_at' => '2026-10-25',
    ],
];
