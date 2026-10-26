# Fichas de producto: botones, funciones, maquetas, video y WhatsApp

Cada producto de `resources/content/products.php` genera su ficha en `/productos/{slug}`. Todo lo que se ve en la ficha sale de ese archivo; el encabezado del archivo documenta cada campo.

## 1. Qué tiene cada ficha

1. Presentación: nombre, descripción breve, estado, **qué problema resuelve** (`problem`), **para quién es** (`audience`) y un botón para solicitar una demostración.
2. **Demostración** (`#demostracion`): el video si existe; si no, una maqueta de interfaz (`mockup`) con el aviso "No es una captura de pantalla real".
3. **Funciones** (`#funciones`): 4 a 6 puntos (`features`).
4. Tarjeta final (`#consultar`) con el mismo botón y enlaces a los otros programas y a los servicios.

## 2. Texto del botón de cada tarjeta

`cta_label` es el texto del enlace en las tarjetas (portada y `/productos`). `cta_anchor` (sin `#`) hace que lleve a una sección de la ficha: `funciones` o `demostracion`. Sin `cta_anchor` lleva al principio de la ficha.

## 3. Funciones: confirmadas u orientativas

Las funciones que hoy figuran son **de referencia**: no se pudieron verificar en el código del programa. Mientras `features_confirmed` sea `false`, la ficha las titula "Funciones de referencia" y avisa que se confirman en la demostración. Cuando las verifiques una por una, reescribí la lista con las funciones reales y poné `'features_confirmed' => true` (el título pasa a "Qué incluye").

## 4. Mensaje de WhatsApp

Se arma solo: `Hola, quisiera conocer más sobre {inquiry_subject} de SantaFeSL y {inquiry_action}.` Por defecto la acción es "solicitar una demostración". El número sale de `SITE_CONTACT_WHATSAPP` (ver [Contacto](04-contacto.md)): no está escrito en ninguna vista.

Si no hay WhatsApp válido, el botón pasa a ser un correo con el asunto "Consulta por …"; si tampoco hay correo, lleva a `/contacto`. Nunca queda un enlace roto. Los datos de ejemplo no se muestran en producción.

## 5. Maquetas

`mockup` (`church`, `pos`, `catalog`) dibuja una interfaz de ejemplo con HTML y CSS propios (`components/product/mockup.blade.php`, `resources/css/components/_product.scss`). Son ilustraciones conceptuales, sin texto ni datos: **no las presentes como capturas reales**. Para agregar una, sumá un bloque en ese componente, el nombre en `Entry::MOCKUPS` y los estilos.

## 6. Agregar un video

Sin video (`'video' => null`) la ficha muestra la maqueta y un aviso: no hay reproductor vacío.

**Video propio.** Copiá el video (MP4 o WebM, lo más liviano posible) y una portada a `storage/app/public/videos/` y completá:

```php
'video' => [
    'provider' => 'local',
    'src' => 'videos/pos-demo.mp4',
    'poster' => 'videos/pos-demo.jpg',
    'orientation' => 'horizontal',   // o 'vertical'
    'title' => 'Recorrido por el sistema de caja',
    'description' => 'Texto breve que acompaña al video (opcional).',
],
```

El navegador no descarga el video hasta que se reproduce (`preload="none"`). Si el servidor lo permite, comprimilo antes de subirlo.

**Proveedor externo** (por ejemplo YouTube sin cookies). Hay que permitir el dominio, porque la CSP bloquea todo lo ajeno:

1. En `config/site.php`: `'video_hosts' => ['www.youtube-nocookie.com'],`
2. En el producto: `'provider' => 'embed', 'url' => 'https://www.youtube-nocookie.com/embed/ID', 'poster' => 'videos/portada.jpg', 'title' => '…'`.

El video externo no se carga hasta que la persona toca el botón de reproducir. Recordá regenerar la caché de configuración en producción (`php artisan config:cache`). Con `video_hosts` vacío la CSP queda exactamente como antes.

Las pruebas (`php artisan test --filter=ProductPages`) comprueban que los archivos existan y que el dominio externo esté permitido.

## 7. Fichas con capturas reales (CHMS)

Si un producto tiene `screens` en `products.php`, su ficha usa el formato de capturas: título y bajada propios (`headline`, `lead`), una sección por captura (la primera lleva el ancla `#funcionalidades`), tarjetas de otros módulos (`modules`), el espacio del video y el cierre con WhatsApp.

- Las capturas están en `storage/app/public/products/chms/` (`chms-dashboard.webp`, `chms-consolidacion.webp`, `chms-eventos.webp`, `chms-tesoreria.webp`). Son las imágenes originales, recortadas solo en los bordes y convertidas a WebP.
- Para reemplazar una captura, copiá el archivo nuevo con el mismo nombre y actualizá `width` y `height` en `products.php` (la prueba `ProductPagesTest` comprueba que coincidan con el archivo).
- Cada captura necesita un texto alternativo (`alt`) que describa lo que se ve.
- **Video de CHMS:** completá `'video' => [...]` en ese producto como en la sección 6. Al existir, la sección "Una demostración en video, próximamente" (con la captura del panel) pasa a mostrar el reproductor, con el título "Mirá CHMS en movimiento". No hay que tocar ninguna vista.
- Los textos de las capturas y de `modules` se verificaron contra las capturas reales y la especificación funcional de CHMS. Excepción: el «fondo común» y las «entregas» de los eventos figuran en la captura pero no en la especificación; confirmá que sigan vigentes.

## 8. Pediwa y los bloques de texto

Pediwa usa el mismo formato de capturas que CHMS, más estos campos opcionales de `products.php`:

- `hero_image`: imagen principal bajo el título (el collage de cinco celulares). Se muestra completa y con sus proporciones; en el celular se desliza dentro de su marco para que los catálogos se lean.
- `intro_sections` y `outro_sections`: bloques antes y después de las capturas. Cada uno tiene `type` (`cards`: tarjetas con título; `steps`: pasos numerados; `checks`: lista con tildes), `id`, `title`, `lead`, `items` y `note` (opcionales).
- `cta_title`, `cta_text`, `cta_button`, `explore_label`, `explore_anchor`, `short_name` y `screens_note`: textos de los botones, del cierre y de los pies de imagen.
- Imágenes en `storage/app/public/products/pediwa/` (`pediwa-catalogos.webp`, `pediwa-panel.webp`, `pediwa-productos.webp`, `pediwa-banners.webp`, `pediwa-categorias.webp` y la versión chica `pediwa-catalogos-tarjeta.webp` para la tarjeta). Las capturas del panel son las originales, solo convertidas a WebP; el collage se redujo de 3767 a 2000 px de ancho.

Pediwa es el antiguo «Catálogo web»: ocupa su lugar en la lista y la dirección vieja `/productos/catalogo-web` redirige a `/productos/pediwa` (redirección permanente en `routes/web.php`).
