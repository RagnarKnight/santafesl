# Producción

Qué preparar para publicar el sitio y cómo comprobar que quedó bien. **La configuración del servidor web (Nginx, Apache, HTTPS, firewall) es tuya**: acá se explica solo qué necesita la aplicación de ese servidor.

> **Importante:** los pasos de esta guía describen cómo debe hacerse, pero **no se ejecutaron en un servidor real** al preparar la v1. Los comandos de caché de Laravel se probaron en un entorno de pruebas; la instalación con `composer install --no-dev` y la publicación real quedan por verificar en tu servidor (ver sección 9).

## 1. Qué necesita el servidor

- PHP **8.4.1 o superior** con PHP-FPM (o el servidor que uses) y las extensiones habituales de Laravel.
- Composer 2.x (o instalar las dependencias en otra máquina y subirlas).
- Node.js 22.12+ **solo para compilar** los assets; si los compilás en otra máquina, el servidor no necesita Node.
- Un servidor web que:
  - use la carpeta **`public/`** como raíz del sitio (nunca la raíz del proyecto);
  - envíe todas las rutas que no sean archivos a `public/index.php`;
  - pueda **seguir el enlace simbólico** `public/storage`;
  - sirva el sitio por **HTTPS** y redirija HTTP a HTTPS.

## 2. Variables de entorno obligatorias

Creá el `.env` en el servidor (nunca lo subas al repositorio ni lo incluyas en un paquete) y **no uses el `.env.example` sin cambiarlo**: trae valores de desarrollo.

```env
APP_NAME=SantaFeSL
APP_ENV=production
APP_DEBUG=false
APP_URL=https://santafesl.com
APP_KEY=                       # lo genera el comando de la sección 3
APP_LOCALE=es
APP_FALLBACK_LOCALE=es

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=warning

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

SITE_CONTACT_EMAIL=tu-correo-real@tudominio.com
SITE_CONTACT_WHATSAPP=<tu número en formato internacional, solo dígitos>
SITE_CONTACT_WHATSAPP_MESSAGE="Hola, quiero consultar por los servicios de SantaFeSL."
```

| Variable | Por qué importa |
|---|---|
| `APP_ENV=production` | Con `local` **no se aplica la política de seguridad (CSP)**. Es el error más peligroso de olvidar |
| `APP_DEBUG=false` | Con `true`, un error muestra rutas, código y datos internos |
| `APP_URL` | Dirección pública con `https://`, sin barra final. Se usa en la dirección canónica y en la imagen para compartir |
| `APP_KEY` | Clave de Laravel. Una por entorno; no la compartas |
| `SITE_CONTACT_*` | Contacto real. En producción los datos de ejemplo **no** se muestran (ver [Contacto](04-contacto.md)) |

El sitio no usa base de datos: no configures `DB_*` ni ejecutes `migrate` ni seeders.

## 3. Instalar y preparar la aplicación

Desde la carpeta del proyecto en el servidor (o en tu máquina de compilación):

```bash
composer install --no-dev --optimize-autoloader   # solo dependencias de producción (sin Pest, Pint ni Boost)
php artisan key:generate --force                    # crea APP_KEY en .env (una sola vez)
php artisan storage:link --force                    # enlace public/storage
npm ci                                              # dependencias de JavaScript
npm run build                                       # genera public/build/ (los estilos y el JS)
```

Si compilás en otra máquina, subí la carpeta `public/build/` al servidor (no está en Git).

## 4. Permisos y almacenamiento

Laravel escribe en dos carpetas: `storage/` y `bootstrap/cache/`. El usuario con el que corre PHP-FPM (por ejemplo `www-data`) debe poder escribir en ellas; el resto del código puede ser de solo lectura.

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R ug+rwX storage bootstrap/cache
```

Ajustá el usuario al de tu servidor. Las carpetas `storage/framework/cache/data`, `storage/framework/views`, `storage/framework/sessions` y `storage/logs` ya vienen en el proyecto (con un `.gitignore` interno); si faltan, crealas. `.env` debe ser legible por PHP y **no** accesible desde la web (por eso la raíz del sitio es `public/`).

## 5. Cachés de Laravel

Después de instalar, de cambiar `.env` y de cada actualización:

```bash
php artisan config:cache     # configuración (lee el .env UNA vez: después los cambios del .env no se notan)
php artisan route:cache      # rutas
php artisan view:cache       # compila las vistas Blade
php artisan event:cache      # eventos
```

Atajo equivalente: `php artisan optimize`. Para deshacerlo: `php artisan optimize:clear`.

Regla práctica: **si cambiás el `.env`, volvé a ejecutar `php artisan config:cache`**.

## 6. HTTPS

- El certificado y la redirección de HTTP a HTTPS se configuran en el servidor web.
- Poné `APP_URL=https://...`.
- La aplicación ya envía cabeceras de seguridad (`X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy` y una CSP estricta). **No envía `Strict-Transport-Security` (HSTS)**: si lo querés, se agrega en el servidor web.
- No hay cookies ni sesiones, así que no hay nada más que asegurar en ese sentido.

## 7. Proxy inverso (Nginx, Docker, balanceador)

Si delante de PHP hay un proxy que termina el HTTPS (por ejemplo Nginx delante de un contenedor), la aplicación recibe las peticiones por HTTP y puede generar direcciones `http://` para los estilos y las imágenes del sitio. El navegador las bloquea (contenido mixto y CSP).

El proxy debe enviar `X-Forwarded-Proto: https` (y `X-Forwarded-For`, `X-Forwarded-Host`), y la aplicación debe confiar en él. En `bootstrap/app.php`, dentro de `->withMiddleware(function (Middleware $middleware): void { ... })`, agregá:

```php
$middleware->trustProxies(at: '*');   // o la IP/red del proxy, por ejemplo '172.18.0.0/16'
```

Usá `'*'` solo si el contenedor de PHP únicamente es accesible a través de tu proxy. **Esto no está incluido ni verificado en la v1**: aplicalo solo si, al probar, las direcciones salen con `http://`. Si PHP recibe HTTPS directamente, no hace falta.

La dirección canónica se arma con `APP_URL`; en cambio las direcciones del sitemap, los estilos y las imágenes usan la dirección con la que llega la petición, por eso importa que el proxy envíe bien los encabezados `X-Forwarded-*`.

## 8. Verificaciones después de publicar

Reemplazá `santafesl.com` por tu dominio.

```bash
curl -sI https://santafesl.com/            # 200 + cabeceras (Content-Security-Policy, X-Frame-Options...)
curl -s  https://santafesl.com/robots.txt
curl -s  https://santafesl.com/sitemap.xml # 8 direcciones https
curl -sI https://santafesl.com/no-existe   # 404
curl -s  https://santafesl.com/up          # respuesta de salud de Laravel (200)
```

Y en el navegador:

- [ ] Todas las páginas cargan con estilos: Inicio, Programas y las 3 fichas, Servicios, Sobre mí, Contacto.
- [ ] Las ilustraciones se ven (si no, revisá `php artisan storage:link --force` y los permisos).
- [ ] Pestaña **Red** de las herramientas del navegador: **ninguna** petición a otro dominio (ni fuentes, ni CDN).
- [ ] Pestaña **Consola**: sin errores de "Content Security Policy".
- [ ] `/contacto`: los botones de correo y WhatsApp llevan a **tus** datos y no aparece "ejemplo".
- [ ] El favicon se ve en la pestaña.
- [ ] No aparece "Laboratorio" en ningún lugar y `/laboratorio` da 404.
- [ ] Una dirección inexistente muestra la página 404 en español.
- [ ] El código fuente de la página no contiene `APP_KEY`, rutas del servidor ni mensajes de error.
- [ ] Los enlaces del sitemap abren sin errores.

## 9. Qué falta por verificar en tu servidor

Estos puntos no pudieron comprobarse al preparar la v1 y hay que probarlos con tu instalación real:

1. `composer install --no-dev` con PHP 8.4.1+ (la instalación completa no se pudo ejecutar sin acceso a Packagist).
2. Dominio, HTTPS y redirección de HTTP a HTTPS.
3. Comportamiento detrás de un proxy inverso (sección 7).
4. Permisos de escritura de `storage/` y `bootstrap/cache/`.
5. Que el servidor siga el enlace `public/storage`.
6. Encabezados reales recibidos (`curl -sI`).
7. Rendimiento y compresión (gzip/brotli) y caché de los archivos de `public/build/`, que son tareas del servidor web.

## 10. Actualizaciones en producción

Resumen (detalle en [Actualizar](06-actualizar.md)):

```bash
# subir el código nuevo (sin pisar el .env del servidor)
composer install --no-dev --optimize-autoloader
npm ci && npm run build        # o subir public/build/ ya compilado
php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan event:cache
```

Probá primero en un entorno de pruebas y repetí las verificaciones de la sección 8.
