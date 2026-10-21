# Cambiar el nombre, el logo, el favicon y la imagen para compartir

**Estado actual de la marca (v1):**

| Elemento | Estado |
|---|---|
| Nombre | "SantaFeSL" (texto en `config/site.php`, pie de página y metadatos) |
| Logo | **"SFSL" en dos tonos** (SF negro, SL rojo), entregado por el autor. Se muestra en el encabezado. Archivo: `storage/app/public/brand/logo.png` (640 px de ancho, fondo transparente) |
| Favicon | Versión cuadrada del mismo logo (SF arriba, SL abajo, sobre fondo crema): `public/favicon.ico` (16, 32 y 48 px) y `public/favicon.png` (192 px). También se usa como icono al guardar el sitio en la pantalla de inicio del teléfono |
| Imágenes originales del logo | `resources/brand/` (2000 × 2000 px: la versión de dos tonos y la versión toda roja). No se publican; sirven para regenerar el logo y el favicon |
| Imagen Open Graph (la que aparece al compartir el enlace) | **No existe todavía** |
| Ilustraciones | Provisionales (ver [Imágenes](03-imagenes.md)) |

## 1. Cambiar el nombre visible

| Dónde | Cómo cambiarlo |
|---|---|
| Título de las pestañas, pie de página, metadatos | `'name' => 'SantaFeSL'` en `config/site.php` |
| Variable de Laravel `APP_NAME` | `.env` (`APP_NAME=SantaFeSL`) |
| Texto alternativo del logo del menú | usa `config('site.name')`: se cambia con el valor anterior |
| Frase corta (tagline) y descripción general | `config/site.php` (`tagline`, `descriptor`) |
| Textos que nombran a SantaFeSL | `pages/about.blade.php` y los archivos de contenido |

El logo es una imagen con las letras "SFSL": si cambia el nombre del negocio, hay que cambiar también la imagen (sección 2).

Después de cambiar el nombre, buscá el nombre viejo en todo el proyecto para no dejar restos:

```bash
grep -rn "NombreViejo" resources config public app
```

Y, en producción, regenerá la caché: `php artisan config:cache`.

## 2. Cambiar el logo

El logo se muestra en `resources/views/components/site/header.blade.php`:

```html
<img class="brand-logo" src="{{ Storage::disk('public')->url('brand/logo.png') }}" alt="{{ config('site.name') }}" width="91" height="32">
```

**Reemplazarlo por otro archivo:**

1. Preparalo con **fondo transparente** (PNG, WebP o SVG), con el doble de ancho del tamaño en pantalla para que se vea nítido en pantallas de alta densidad. Hoy se muestra de 32 px de alto (`2rem`), así que ~640 px de ancho está bien.
2. Copialo sobre `storage/app/public/brand/logo.png` **con el mismo nombre** (si es otro formato, copialo con su nombre y cambiá `brand/logo.png` en la línea de arriba).
3. Si cambia la proporción, actualizá `width` y `height` del `<img>` con el tamaño final (alto 32 → ancho = 32 × ancho/alto del logo). **No uses `style="..."`**: el sitio no permite estilos en línea. Para ajustar el tamaño usá la regla `.brand-logo` de `resources/css/components/_site.scss` y ejecutá `npm run build`.
4. El texto alternativo (`alt`) es el nombre del sitio. Revisá el menú en celular y en escritorio y ejecutá `php artisan test`.

Los originales (`resources/brand/`) son de 2000 × 2000 px con fondo blanco. Para regenerar el logo transparente hay que quitar el fondo y recortar los márgenes con un editor de imágenes.

## 3. Cambiar el favicon

El favicon es el iconito de la pestaña del navegador. Hay dos archivos:

| Archivo | Uso |
|---|---|
| `public/favicon.ico` | Navegadores en general (contiene 16, 32 y 48 px) |
| `public/favicon.png` | 192 px: pantallas de alta densidad y icono al agregar el sitio a la pantalla de inicio |

Para cambiarlo:

1. Preparalos con tu imagen: un PNG **cuadrado** de 192 px o más y un `.ico` (se genera desde el PNG con cualquier conversor de favicon). Al ser tan pequeño, conviene un diseño simple y con pocas letras: por eso el favicon actual apila "SF" sobre "SL".
2. Copialos sobre `public/favicon.ico` y `public/favicon.png` **con los mismos nombres**. No hay que tocar ninguna vista: el encabezado de cada página (`resources/views/components/layouts/app.blade.php`) ya los enlaza.
3. Los navegadores guardan el favicon en caché: probalo con `Ctrl + F5` o en una ventana privada.
4. Ejecutá `php artisan test --filter=Favicon` (comprueba que existan, que no estén vacíos y que sean válidos).

## 4. Agregar la imagen Open Graph (para compartir el enlace)

Es la imagen que aparece al compartir el sitio en WhatsApp, redes sociales, etc. Todavía no existe y el sitio hoy no la incluye. Cuando la tengas:

1. Imagen **1200 × 630 px**, PNG o JPG, menos de 300 KB. Copiala a `public/og.png`.
2. En `resources/views/components/layouts/app.blade.php`, dentro del bloque `@else` de los metadatos, junto a las demás líneas `og:`, agregá:

   ```html
   <meta property="og:image" content="{{ rtrim(config('app.url'), '/') }}/og.png">
   <meta property="og:image:alt" content="Texto que describe la imagen">
   ```

   y cambiá `<meta name="twitter:card" content="summary">` por `<meta name="twitter:card" content="summary_large_image">`.
3. Verificá con las herramientas de vista previa de la red social o de WhatsApp (muchas guardan la imagen vieja en caché durante un tiempo).

`APP_URL` debe ser la dirección pública con `https`, porque la imagen necesita una dirección absoluta.

## 5. Metadatos que dependen de la marca

| Metadato | Dónde |
|---|---|
| Nombre, tagline y descripción general | `config/site.php` |
| Dirección canónica | `APP_URL` en `.env` |
| Dominio dentro de `robots.txt` | `public/robots.txt` (línea `Sitemap:`) |
| Idioma y región para redes sociales | `og:locale` (`es_AR`) en el layout |
| Descripciones de cada página | primera línea de cada vista y `seo_*` de los productos |
| Texto alternativo de la ilustración de portada | `hero.alt` en `config/site.php` |
