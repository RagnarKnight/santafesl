# Instalación y desarrollo

Esta guía instala el sitio desde un clon limpio del repositorio y lo deja funcionando en tu computadora.

## 1. Requisitos

| Herramienta | Versión | Cómo comprobarla |
|---|---|---|
| PHP | **8.4.1 o superior** | `php -v` |
| Composer | 2.x | `composer --version` |
| Node.js | 22.12 o superior (también sirve 20.19+) | `node -v` |
| npm | el que viene con Node | `npm -v` |

**Por qué PHP 8.4.1:** el archivo `composer.lock` fija versiones de Symfony y PHPUnit que exigen PHP 8.4.1 como mínimo. Con PHP 8.3 `composer install` falla. Si necesitás PHP 8.3 habría que regenerar el lock con otras versiones: es un cambio mayor que hay que decidir aparte.

PHP necesita las extensiones habituales de Laravel (`mbstring`, `openssl`, `xml`/`dom`, `ctype`, `fileinfo`, `tokenizer`, `curl`). Si falta alguna, `composer install` te lo dice con su nombre.

## 2. Instalación desde un clon limpio

Ejecutá estos comandos dentro de la carpeta del proyecto:

```bash
composer install                      # 1. dependencias de PHP (crea la carpeta vendor/)
cp .env.example .env                  # 2. archivo de configuración local
php artisan key:generate              # 3. genera APP_KEY dentro de .env
php artisan storage:link --force      # 4. enlace public/storage -> storage/app/public
npm ci                                # 5. dependencias de JavaScript (usa package-lock.json)
npm run build                         # 6. compila CSS y JS en public/build/
```

Hay un atajo que hace lo mismo: `composer setup`.

Qué hace cada paso:

1. `composer install` descarga lo que indica `composer.lock`. No cambia versiones.
2. `.env` guarda la configuración de **tu** entorno. Nunca se sube al repositorio.
3. `key:generate` escribe una clave aleatoria en `APP_KEY`. Hay que hacerlo una vez por entorno.
4. `storage:link` crea el enlace por el que el navegador ve las imágenes (ver [Imágenes](03-imagenes.md)). El proyecto ya trae ese enlace versionado; `--force` lo recrea si está roto.
5. `npm ci` instala exactamente lo que dice `package-lock.json`. No uses `npm install` para instalar: puede modificar el lock.
6. `npm run build` genera los archivos de `public/build/`. **Sin este paso el sitio se ve sin estilos.**

## 3. Configurar el archivo `.env`

El `.env` que sale de `.env.example` ya sirve para desarrollo. Las variables que importan:

| Variable | Valor en desarrollo | Qué hace |
|---|---|---|
| `APP_ENV` | `local` | Entorno. En producción: `production` |
| `APP_DEBUG` | `true` | Muestra errores detallados. En producción: `false` |
| `APP_URL` | `http://localhost:8000` | URL pública. Se usa en la dirección canónica |
| `APP_KEY` | (la genera `key:generate`) | Clave de Laravel |
| `SITE_CONTACT_EMAIL` | `contacto@example.com` | Correo de contacto (**ejemplo**) |
| `SITE_CONTACT_WHATSAPP` | `5490000000000` | WhatsApp en formato internacional (**ejemplo**) |
| `SITE_CONTACT_WHATSAPP_MESSAGE` | texto de saludo | Mensaje con el que se abre el chat |

El sitio no usa base de datos: las variables `DB_*` no hacen falta. **No ejecutes** `php artisan migrate` ni seeders.

Con `APP_ENV=local` no se aplica la política de seguridad de contenido (CSP), para no estorbar al servidor de desarrollo de Vite. Las pruebas y producción sí la aplican.

## 4. Compilar los estilos y el JavaScript (Vite)

```bash
npm run build      # compila una vez (producción y pruebas)
npm run dev        # modo desarrollo: recompila al guardar (dejalo abierto en otra terminal)
```

Hay que volver a ejecutar `npm run build` cada vez que cambies algo en `resources/css/` o `resources/js/`, o si el sitio aparece sin estilos. Cambiar textos o imágenes **no** requiere compilar.

## 5. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

Abrí <http://localhost:8000>. Para detenerlo: `Ctrl + C`.

## 6. Ejecutar las pruebas

```bash
php artisan test                  # toda la suite
php artisan test --filter=Contact # solo las pruebas de contacto
vendor/bin/pest                   # equivalente
vendor/bin/pint --test            # revisa el estilo del código sin cambiar nada
vendor/bin/pint                   # corrige el estilo
```

Todas deben pasar. Una de ellas (*no deja recursos externos en los assets compilados*) se omite si todavía no ejecutaste `npm run build`; después de compilar se ejecuta sola.

## 7. Aplicar un paquete sobre un repositorio existente

Si recibís los cambios como un archivo `.tar.gz`:

```bash
tar xzf santafesl-v1-final.tar.gz     # sobrescribe y agrega archivos
```

Un `.tar.gz` **no borra** archivos viejos. Después de extraerlo eliminá a mano los que ya no existen:

```bash
rm -f resources/views/welcome.blade.php                 # vista por defecto de Laravel, sin uso
rm -f app/Http/Controllers/ProjectController.php        # Laboratorio retirado
rm -rf resources/views/pages/projects                   # Laboratorio retirado
```

`welcome.blade.php` es la página de bienvenida que trae Laravel. Ninguna ruta la usa y contiene enlaces a sitios externos, por eso la prueba *no referencia CDN ni fuentes remotas en el código fuente* falla mientras el archivo exista.

Si usás Git, `git rm` en lugar de `rm` deja registrada la eliminación.

## 8. Problemas frecuentes

| Síntoma | Causa y solución |
|---|---|
| `composer install` dice que el lock exige PHP 8.4.1 | Tenés una versión de PHP menor. Actualizá PHP |
| El sitio se ve sin estilos | Falta `npm run build` |
| Las imágenes no cargan | Falta el enlace: `php artisan storage:link --force` (ver [Imágenes](03-imagenes.md)) |
| Aparece "No application encryption key has been specified" | Falta `php artisan key:generate` |
| `FrontendRulesTest` falla nombrando `welcome.blade.php` | Eliminá ese archivo (sección 7) |
| Un cambio en `.env` no se nota | Si hay caché de configuración: `php artisan config:clear` |

Para producción seguí [Producción](07-produccion.md).
