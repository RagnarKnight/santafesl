# Actualizar el proyecto

Cómo hacer un cambio, comprobarlo y preparar un paquete para publicar.

## 1. Flujo de trabajo

1. **Hacé el cambio** (un texto, un producto, una imagen, un estilo).
2. **Recompilá si corresponde** (siguiente sección).
3. **Mirá el resultado** en <http://localhost:8000> (`php artisan serve`).
4. **Ejecutá las pruebas**: `php artisan test` y `vendor/bin/pint --test`.
5. **Guardá el cambio** en Git (si lo usás): `git add -A && git commit -m "Describí el cambio"`.
6. **Preparás el paquete** y lo publicás (secciones 3 y 4, y [Producción](07-produccion.md)).

## 2. ¿Hay que recompilar los assets?

| Cambiaste… | ¿`npm run build`? |
|---|---|
| Textos, productos, servicios (`resources/content/`, vistas `.blade.php`) | No |
| Imágenes (`storage/app/public/`) | No |
| `.env` o `config/` | No, pero en producción regenerá la caché de configuración (`php artisan config:cache`) |
| Estilos (`resources/css/`) o JavaScript (`resources/js/`) | **Sí** |
| Dependencias (`package.json`) | Sí (`npm ci` primero) |

```bash
npm run build
```

La carpeta `public/build/` está en `.gitignore`: **no se guarda en Git**. Se genera en cada instalación o antes de armar el paquete.

## 3. Ejecutar las pruebas

```bash
php artisan test              # todas
vendor/bin/pint --test        # estilo (si falla, vendor/bin/pint lo corrige)
```

Si una prueba falla, leé el mensaje: indica el archivo y el motivo. Las pruebas protegen reglas del proyecto: no CSS/JS en línea, no CDN ni recursos externos, cabeceras de seguridad, imágenes existentes, contenido válido y contacto correcto. **No las desactives ni las modifiques para que pasen**: corregí la causa.

## 4. Preparar un paquete para desplegar

El paquete **no debe incluir** `.env`, `vendor/`, `node_modules/`, `storage/logs/*`, cachés ni archivos temporales.

Con Git (recomendado), desde la raíz del proyecto:

```bash
git archive --format=tar.gz --prefix=santafesl/ -o santafesl.tar.gz HEAD
```

`git archive` solo incluye lo versionado, así que deja afuera `.env`, `vendor/`, `node_modules/` y `public/build/`.

Sin Git:

```bash
tar czf santafesl.tar.gz \
  --exclude=.env --exclude=vendor --exclude=node_modules \
  --exclude=public/build --exclude='storage/logs/*.log' \
  --exclude='storage/framework/cache/data/*' --exclude='storage/framework/views/*.php' \
  --exclude=bootstrap/cache/*.php --exclude=.git .
```

Si no usás Git, la compilación (`npm run build`) y la instalación (`composer install --no-dev`) se hacen en el servidor o en una máquina de compilación; ver [Producción](07-produccion.md).

## 5. Aplicar un paquete que te entregan

```bash
tar xzf santafesl-v1-final.tar.gz
```

Esto sobrescribe y agrega archivos, pero **no elimina** los que ya no existen en el paquete. Cada entrega indica los archivos a borrar a mano (en la v1: `resources/views/welcome.blade.php`, `app/Http/Controllers/ProjectController.php` y `resources/views/pages/projects/`; ver [Instalación](01-instalacion.md), sección 7). Después ejecutá `composer install`, `npm ci`, `npm run build` y `php artisan test`.

## 6. Actualizar dependencias

Hacelo solo cuando haga falta y con un desarrollador.

- PHP: `composer update` cambia el `composer.lock`. Probá todo antes de publicar.
- JavaScript: `npm update` cambia `package-lock.json`.
- No uses `npm install` ni `composer update` en un servidor de producción: instalá siempre desde los archivos lock (`composer install`, `npm ci`).
- Después de actualizar: `php artisan test`, `vendor/bin/pint --test`, `npm run build` y `npm audit`.

## 7. Requisito de PHP y `composer.lock`

`composer.json` pide **PHP ^8.4.1**, porque `composer.lock` incluye paquetes (Symfony 8, PHPUnit 13, Pest 5) que lo exigen. En la entrega v1 el requisito de `composer.json` se actualizó pero `composer.lock` **todavía conserva la marca de la versión anterior** (`^8.3`), porque regenerarlo exige PHP 8.4 y acceso a Packagist, que no estaban disponibles al prepararla. Consecuencias y qué hacer, una sola vez, en una máquina con PHP 8.4.1+ y acceso a Internet:

```bash
composer update --lock
composer validate
git diff composer.lock      # solo debe cambiar "content-hash" y la línea "platform" → "php": "^8.4.1"
```

`composer update --lock` solo sincroniza la marca del lock con `composer.json`; no actualiza paquetes. Si el `git diff` muestra cambios de versiones de paquetes, no los publiques sin revisarlos. Mientras tanto, `composer install` funciona (muestra un aviso de que el lock no está al día) y `composer validate` informa ese mismo aviso.
