# Cambiar el contenido: productos, servicios y textos

El contenido no está en una base de datos: son archivos de texto que se editan con cualquier editor. Después de guardar, recargá la página; **no hace falta compilar** nada.

## 1. Dónde está cada cosa

| Contenido | Archivo |
|---|---|
| Productos (listado y fichas) | `resources/content/products.php` |
| Servicios | `resources/content/services.php` |
| Proyectos del Laboratorio (**no publicados**) | `resources/content/projects.php` |
| Textos de la portada | `resources/views/pages/home.blade.php` |
| Textos de "Sobre mí" | `resources/views/pages/about.blade.php` |
| Textos de Contacto | `resources/views/pages/contact.blade.php` |
| Bloque "¿Tenés algo en mente?" (se repite en varias páginas) | `resources/views/components/cta-contact.blade.php` |
| Menú superior | `resources/views/components/site/header.blade.php` |
| Pie de página | `resources/views/components/site/footer.blade.php` |
| Frase corta y descripción general del sitio | `config/site.php` (`tagline`, `descriptor`) |
| Nombre, logo, favicon | ver [Marca](05-marca.md) |

## 2. Agregar un producto

Un producto es un bloque `[ ... ]` dentro de la lista de `resources/content/products.php`. Con eso solo el producto aparece en:

- la **ficha individual**, en `/productos/<slug>` (la genera el sitio sola);
- el **listado** `/productos`;
- el **sitemap** `/sitemap.xml` (se actualiza solo, no hay que tocarlo);
- la **portada**, si tiene `'featured' => true`.

### Paso a paso

1. Abrí `resources/content/products.php`.
2. Copiá un bloque existente completo (desde `[` hasta `],`) y pegalo al final de la lista, antes del `];` final.
3. Cambiá los valores (tabla de campos más abajo).
4. Si tiene imagen, copiá el archivo a `storage/app/public/illustrations/` (ver [Imágenes](03-imagenes.md)).
5. Guardá y probá (sección 5).

### Ejemplo copiable

Este ejemplo es solo para aprender el formato: **no está en el sitio** y no es un producto real. Cambiá todo por tus datos.

```php
    [
        'slug' => 'ejemplo-turnos',                      // dirección: /productos/ejemplo-turnos
        'name' => 'Sistema de turnos (EJEMPLO)',
        'short_description' => 'Un programa para dar turnos y avisar a los clientes.',
        'description' => "Primer párrafo de la ficha.\n\nSegundo párrafo de la ficha.",
        'status' => 'completed',                         // se muestra como "Terminado"
        'icon' => 'grid',                                // ver la lista de iconos más abajo
        'image_path' => 'illustrations/product-turnos.svg',
        'image_alt' => 'Ilustración de un calendario con turnos asignados.',
        'seo_title' => 'Sistema de turnos',
        'seo_description' => 'Programa para administrar turnos de un negocio.',
        'featured' => false,                             // true = aparece también en la portada
        'sort_order' => 40,                              // orden: menor primero
        'published_at' => '2026-11-01',                  // desde cuándo se publica
    ],
```

Reglas del formato PHP: cada línea termina en coma; los textos van entre comillas; si el texto lleva una comilla simple (`'`) usá comillas dobles (`"`) para todo el texto; para separar párrafos escribí `\n\n` **dentro de comillas dobles**.

### Campos

| Campo | Obligatorio | Qué hace |
|---|---|---|
| `slug` | Sí | Parte de la dirección. Solo minúsculas, números y guiones. No puede repetirse |
| `name` | Sí | Nombre visible |
| `short_description` | Sí | Frase corta de la tarjeta y subtítulo de la ficha |
| `description` | No | Texto de la ficha. Párrafos separados por `\n\n` (comillas dobles) |
| `status` | No | Estado (ver abajo). Si falta, no se muestra etiqueta |
| `features` | No | Lista `['uno', 'dos']`. Si existe, la ficha muestra la sección "Qué incluye" |
| `icon` | No | Icono decorativo de la tarjeta (ver abajo) |
| `image_path` | No | Ruta de la imagen, relativa a `storage/app/public/` |
| `image_alt` | **Sí, si hay `image_path`** | Texto alternativo para lectores de pantalla |
| `seo_title`, `seo_description` | No | Título y descripción para buscadores. Si faltan se usan `name` y `short_description` |
| `featured` | No | `true` = aparece en la portada |
| `sort_order` | No | Número de orden |
| `published_at` | **Sí para publicar** | Fecha `'AAAA-MM-DD'`. Sin fecha o con fecha futura el producto **no se muestra** (queda como borrador) |

**Estados disponibles** (`status`): `development` = En desarrollo, `beta` = Beta, `production` = Disponible, `completed` = **Terminado**, `paused` = Pausado, `archived` = Archivado.

**Iconos disponibles** (`icon`): `church`, `bag`, `grid`, `server`, `wifi`, `code`, `chat`, `flask`, `monitor`, `register`, `globe`, `search`, `gear`, `network`, `wrench`.

No inventes funciones, precios ni testimonios: la ficha solo debe decir lo que es cierto.

### Ocultar un producto sin borrarlo

Poné `'published_at' => null,` (o una fecha futura). El producto desaparece del listado, la portada y el sitemap, y su ficha da error 404.

## 3. Cambiar el nombre, la descripción o el estado de un producto

Editá el bloque del producto en `products.php` y cambiá el campo. Ejemplos:

```php
'name' => 'Sistema para iglesias',
'description' => "Es un sistema de gestión pensado para iglesias.\n\nSegundo párrafo.",
'status' => 'completed',
```

Los tres productos actuales (`chms-iglesias`, `pos`, `pediwa`) tienen `'status' => 'completed'`, que se muestra como **Terminado**.

## 4. Servicios

`resources/content/services.php` funciona igual que los productos, con estos campos: `slug`, `name`, `short_description`, `icon`, `features` (lista que se muestra como "detalle técnico"), `sort_order`, `published_at`. Los servicios **no llevan imagen**: se ilustran con un icono.

## 5. Verificar que un cambio funciona

1. Con el servidor en marcha (`php artisan serve`) abrí `/productos` y la ficha nueva (`/productos/<slug>`).
2. Revisá `/sitemap.xml`: debe aparecer la dirección de la ficha.
3. Ejecutá `php artisan test`. Si te equivocaste en el formato, las pruebas indican el producto y el campo (por ejemplo, falta `image_alt` o la imagen no existe).

Mensajes típicos: `Slug inválido` (usaste mayúsculas o espacios), `Slug duplicado`, `Estado inválido`, `Icono inválido`, `Toda imagen necesita image_alt`.

Si agregás o quitás productos, actualizá también la prueba que cuenta los productos publicados (`tests/Feature/PublicPagesTest.php`, *muestra los tres productos publicados con el estado Terminado*) y el total del sitemap.

## 6. Textos de la portada, "Sobre mí" y contacto

Estos textos están escritos directamente en las vistas (`.blade.php`). Buscá la frase que querés cambiar y reemplazala, sin tocar las etiquetas `<...>` ni las llaves `{{ ... }}`.

Ejemplo, en `resources/views/pages/home.blade.php`:

```html
<p class="lead mb-4">Programas, páginas web y soluciones para tu negocio, sin complicaciones.</p>
```

Cambiá solo el texto entre `>` y `</p>`.

Los textos de **contacto** (títulos y avisos) están en `pages/contact.blade.php`. Los **datos** de contacto (correo y número) no se escriben ahí: ver [Contacto](04-contacto.md).

## 7. Títulos y descripciones para buscadores (SEO)

- **Productos:** `seo_title` y `seo_description` en `products.php`.
- **Otras páginas:** la primera línea de cada vista, por ejemplo en `pages/about.blade.php`:

  ```html
  <x-layouts.app title="Sobre mí" description="Quién está detrás de SantaFeSL y cómo trabaja.">
  ```

  `title` es el título de la pestaña (el sitio le agrega ` · SantaFeSL`) y `description` es el resumen que muestran los buscadores.
- **Portada:** el título completo sale de `config/site.php` (`name` y `tagline`) y la descripción de `descriptor`.
- **Sitemap:** se genera solo desde las páginas y los productos publicados. **robots.txt** está en `public/robots.txt` (contiene la dirección del sitemap con el dominio: actualizala si cambia).

## 8. Laboratorio

La sección *Laboratorio* **no está publicada** en la v1: no tiene rutas, páginas, menú ni enlaces. Los datos de sus dos proyectos siguen en `resources/content/projects.php` (con sus ilustraciones) y las pruebas siguen validándolos, pero ninguna página los muestra.

Para publicarla en el futuro hay que volver a crear la ruta, el controlador, las vistas y los enlaces; el paquete anterior (`santafesl-redesign-v5`) contiene ese código completo (`ProjectController`, `resources/views/pages/projects/`, rutas `projects.*`, bloque de la portada, enlaces del menú y del pie, y entradas del sitemap). Es un cambio que conviene hacer con ayuda de un desarrollador y revisando las pruebas.
