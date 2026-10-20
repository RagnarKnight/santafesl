# Cambiar las imágenes

Las imágenes actuales son **ilustraciones provisionales** (archivos SVG). Se pueden reemplazar sin tocar las vistas: alcanza con cambiar el archivo, o la ruta y el texto alternativo en el archivo de contenido.

## 1. Dónde se guardan

| Imagen | Carpeta | Dónde se indica |
|---|---|---|
| Productos y proyectos | `storage/app/public/illustrations/` | campo `image_path` en `resources/content/products.php` |
| Portada (ilustración grande) | `storage/app/public/illustrations/` | `hero` en `config/site.php` |

Archivos actuales: `hero-technology.svg`, `product-church.svg`, `product-pos.svg`, `product-catalog.svg` y, sin uso público, `project-sincnetwork.svg` y `project-netwatch.svg`.

Los **servicios no llevan imagen**: usan iconos.

## 2. Formatos y nombres

- Formatos: SVG, PNG, JPG/JPEG, WebP o AVIF (cualquiera que lea un navegador). Para ilustraciones y logos conviene SVG; para fotos, WebP o JPG.
- Tamaño recomendado de las tarjetas: **proporción 4:3** (por ejemplo 800 × 600 px). La portada usa 520 × 440.
- Peso: procurá menos de 200 KB por imagen.
- Nombres: minúsculas, sin espacios ni tildes, con guiones: `producto-turnos.webp`.
- Los SVG **no** pueden contener scripts, estilos, enlaces ni referencias externas (la política de seguridad los bloquearía y una prueba lo verifica).

## 3. Reemplazar una imagen

**Opción A — mismo nombre (lo más simple).** Copiá la imagen nueva sobre el archivo viejo, con el mismo nombre y el mismo formato. No hay que cambiar nada más. Recargá con `Ctrl + F5` para saltear la caché del navegador.

**Opción B — otro nombre o formato.**

1. Copiá el archivo nuevo a `storage/app/public/illustrations/` (por ejemplo `product-pos.webp`).
2. En `resources/content/products.php` cambiá `image_path` y `image_alt` del producto:

   ```php
   'image_path' => 'illustrations/product-pos.webp',
   'image_alt' => 'Foto de una caja registradora con un cliente pagando.',
   ```

   La ruta es **relativa a `storage/app/public/`**: empieza en `illustrations/` y no lleva `/storage/`.
3. Opcional: borrá el archivo viejo si ya nadie lo usa.

**Portada:** cambiá en `config/site.php`:

```php
'hero' => [
    'image' => 'illustrations/hero-technology.svg',
    'alt' => 'Texto que describe la imagen.',
    'width' => 520,
    'height' => 440,
],
```

`width` y `height` son el tamaño real de la imagen (evitan que la página "salte" al cargar).

## 4. Texto alternativo (`image_alt`)

Es la descripción que leen los lectores de pantalla y que se ve si la imagen no carga. Describí lo que muestra la imagen, en una frase. **Las ilustraciones actuales dicen "Ilustración provisional: …" en ese texto: cuando las reemplaces por las definitivas, sacá la palabra "provisional".** Si una imagen es puramente decorativa, escribí `''` (vacío); el campo no puede faltar.

## 5. Evitar rutas rotas

- Después de cambiar imágenes ejecutá `php artisan test`. La prueba *referencia solo imágenes que existen en el disco público* falla y te dice cuál falta.
- Mayúsculas y minúsculas importan en el servidor: `Pos.svg` y `pos.svg` son archivos distintos.
- Si una imagen se ve en tu computadora y no en el servidor, revisá que el archivo se haya subido y que exista el enlace `public/storage` (sección 6).

## 6. Cómo funciona `public/storage`

Laravel guarda las imágenes en `storage/app/public/`, una carpeta que el navegador no puede leer. El enlace simbólico `public/storage` apunta a esa carpeta y la hace visible en la dirección `/storage/...`. Por eso la imagen `illustrations/product-pos.svg` se sirve como `/storage/illustrations/product-pos.svg` (el sitio genera rutas relativas, no depende de `APP_URL`).

El proyecto **ya trae** ese enlace versionado. Ejecutá:

```bash
php artisan storage:link --force
```

cuando:

- clonás el proyecto en una computadora o servidor nuevo y las imágenes no cargan;
- subiste el sitio como archivo comprimido o por FTP y el enlace no se conservó (esos métodos suelen perder los enlaces simbólicos);
- `ls -l public/storage` no muestra una flecha `->` hacia `../storage/app/public`.

El servidor web debe poder seguir ese enlace simbólico (por ejemplo, en Nginx no hay que impedirlo y en Apache hace falta `FollowSymLinks`; esa configuración la hacés vos en el servidor).
