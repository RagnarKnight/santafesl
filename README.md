# SantaFeSL

Sitio web público de **SantaFeSL**: programas, servicios y contacto. Hecho con Laravel, Blade, Bootstrap 5, Sass y Vite. Es un sitio de solo lectura: **no tiene base de datos, login, panel, formularios ni cookies**. El contenido está en archivos PHP que se editan a mano.

> **Estado de la versión 1:** el diseño está aprobado y se conserva. La sección *Laboratorio* **no se publica** (sus datos quedan guardados). Los tres productos figuran como *Terminado*. El correo y el WhatsApp del `.env.example` son **ejemplos**: hay que reemplazarlos antes de publicar. El logo es "SFSL" en dos tonos y el favicon se derivó de él; todavía no existe imagen para compartir (Open Graph).

## Requisitos

| Herramienta | Versión | Para qué |
|---|---|---|
| PHP | **8.4.1 o superior** | Ejecutar el sitio y las pruebas |
| Composer | 2.x | Instalar las dependencias de PHP |
| Node.js | 22.12 o superior (o 20.19+) | Compilar CSS y JS con Vite |
| npm | el que trae Node | Instalar las dependencias de JavaScript |

## Instalar y probar (clon limpio)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link --force
npm ci
npm run build
php artisan test
php artisan serve        # http://localhost:8000
```

Para trabajar con recarga automática de estilos, en otra terminal: `npm run dev`.

Detalle paso a paso: [`docs/manual/01-instalacion.md`](docs/manual/01-instalacion.md).

## Qué archivo cambiar para cada cosa

| Quiero cambiar… | Archivo | Guía |
|---|---|---|
| Un producto (nombre, descripción, estado, imagen) o agregar otro | `resources/content/products.php` | [Contenido](docs/manual/02-contenido.md) |
| Los servicios | `resources/content/services.php` | [Contenido](docs/manual/02-contenido.md) |
| Textos de la portada, "Sobre mí" y contacto | `resources/views/pages/*.blade.php` | [Contenido](docs/manual/02-contenido.md) |
| Títulos y descripciones para buscadores (SEO) | `products.php` y cada vista | [Contenido](docs/manual/02-contenido.md) |
| Las imágenes | `storage/app/public/illustrations/` | [Imágenes](docs/manual/03-imagenes.md) |
| El correo y el WhatsApp | `.env` (leído por `config/site.php`) | [Contacto](docs/manual/04-contacto.md) |
| Nombre visible, logo, favicon, imagen para compartir | `config/site.php`, `public/`, layout | [Marca](docs/manual/05-marca.md) |
| Publicar cambios | — | [Actualizar](docs/manual/06-actualizar.md) |
| Poner el sitio en producción | `.env` del servidor | [Producción](docs/manual/07-produccion.md) |

Índice del manual: [`docs/manual/README.md`](docs/manual/README.md).

## Pruebas y calidad

```bash
php artisan test            # o: vendor/bin/pest
vendor/bin/pint --test      # estilo de código
npm run build               # compila los assets
```

Las pruebas comprueban, entre otras cosas, que no haya CSS ni JavaScript en línea, que no se use ningún CDN ni recurso externo, que las cabeceras de seguridad estén presentes, que todas las imágenes existan y que los enlaces de contacto sean correctos.

## Reglas del proyecto

- Sin CDN, sin estilos ni scripts en línea, sin recursos externos: la política de seguridad (CSP) solo permite lo que sale del propio sitio.
- Sin base de datos, sin formularios que guarden datos, sin panel ni login (por ahora).
- Interfaz y contenido en español.
- No inventar datos comerciales: precios, funciones, clientes ni testimonios.

## Documentación técnica y de diseño

El resto de la carpeta [`docs/`](docs/README.md) contiene la visión, la arquitectura, el diseño y las decisiones del proyecto. Algunos documentos son anteriores al alcance de la v1 y llevan un aviso de estado al comienzo.

## Licencia

El proyecto usa Laravel, publicado bajo licencia [MIT](https://opensource.org/licenses/MIT).
