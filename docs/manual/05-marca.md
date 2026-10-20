# Cambiar el nombre, el logo, el favicon y la imagen para compartir

**Estado actual de la marca (v1):**

| Elemento | Estado |
|---|---|
| Nombre | "SantaFeSL", escrito como texto (identificación tipográfica) |
| Logo definitivo | **No existe todavía.** No se usa ningún logo |
| Favicon | **Provisional**: un cuadrado rojo con una "S" blanca (`public/favicon.svg` y `public/favicon.ico`) |
| Imagen Open Graph (la que aparece al compartir el enlace) | **No existe todavía** |
| Ilustraciones | Provisionales (ver [Imágenes](03-imagenes.md)) |

## 1. Cambiar el nombre visible

El nombre aparece en varios lugares, todos con un único origen salvo el logotipo del menú:

| Dónde | Cómo cambiarlo |
|---|---|
| Título de las pestañas, pie de página, metadatos | `'name' => 'SantaFeSL'` en `config/site.php` |
| Variable de Laravel `APP_NAME` | `.env` (`APP_NAME=SantaFeSL`) |
| Logotipo de texto del menú | `resources/views/components/site/header.blade.php`, en la línea `navbar-brand` (`SantaFe<span class="brand-wordmark__sl">SL</span>`) |
| Frase corta (tagline) y descripción general | `config/site.php` (`tagline`, `descriptor`) |
| Textos que nombran a SantaFeSL | `pages/about.blade.php` y los archivos de contenido |

Después de cambiar el nombre, buscá el nombre viejo en todo el proyecto para no dejar restos:

```bash
grep -rn "NombreViejo" resources config public app
```

Y, en producción, regenerá la caché: `php artisan config:cache`.

## 2. Incorporar un logo definitivo

1. Guardá el archivo (mejor SVG; también sirve PNG o WebP) en `storage/app/public/brand/logo.svg`. (La carpeta `brand` no existe: crearla.)
2. En `resources/views/components/site/header.blade.php` reemplazá el contenido de la etiqueta `navbar-brand` por la imagen:

   ```html
   <a class="navbar-brand" href="{{ route('home') }}">
       <img src="{{ Storage::disk('public')->url('brand/logo.svg') }}" alt="SantaFeSL, inicio" width="160" height="40">
   </a>
   ```

   `width` y `height` son el tamaño real que querés mostrar. **No uses `style="..."`**: el sitio no permite estilos en línea. Si necesitás ajustar el tamaño o el alineado, hacelo en `resources/css/components/_site.scss` y ejecutá `npm run build`.
3. Si el logo ya incluye el nombre, dejá en `alt` el nombre del sitio. Si es solo un símbolo, dejá el texto "SantaFeSL" junto a él.
4. Revisá el menú en celular y en escritorio, y ejecutá `php artisan test`.

Hasta que exista el logo definitivo, **no se debe afirmar que existe**: el nombre en texto es la identificación del sitio.

## 3. Reemplazar el favicon

El favicon es el iconito de la pestaña del navegador. Hoy hay dos archivos:

| Archivo | Uso |
|---|---|
| `public/favicon.svg` | Navegadores modernos (se ve nítido en cualquier tamaño) |
| `public/favicon.ico` | Navegadores antiguos y atajos (contiene 16, 32 y 48 px) |

Para cambiarlo:

1. Preparalos con tu logo: un SVG cuadrado y un `.ico` (podés generarlo desde el SVG con cualquier conversor de favicon).
2. Copialos sobre `public/favicon.svg` y `public/favicon.ico` **con los mismos nombres**. No hay que tocar ninguna vista: el encabezado de cada página (`resources/views/components/layouts/app.blade.php`) ya los enlaza.
3. Los navegadores guardan el favicon en caché: probalo con `Ctrl + F5` o en una ventana privada.
4. Ejecutá `php artisan test --filter=Favicon` (comprueba que existan, que no estén vacíos y que sean válidos).

El SVG no puede contener scripts ni referencias externas.

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
