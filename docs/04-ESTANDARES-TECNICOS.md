# SantaFeSL — Estándares técnicos

> **Estado:** propuesta para aprobación. Complementa a `05-development.md` (reglas de trabajo, vigente) y reemplaza en lo técnico a `09-technical-decisions.md` (supone base de datos).

## 1. Stack y versiones

| Área | Decisión | Versión real detectada |
|---|---|---|
| Lenguaje | PHP | Requerido por el lock: **≥ 8.4** (D7: declarar `^8.4`) |
| Framework | Laravel | 13.35.0 (`^13.17`) |
| Vistas | Blade | incluido |
| CSS | Bootstrap 5.3 + Sass | **a instalar** (D5) |
| Build | Vite | 8.3.4 + `laravel-vite-plugin` 3.2.0 |
| Node | requerido por Vite | `^20.19 \|\| >=22.12` |
| Tipografía | Inter vía `@fontsource/inter` | **a instalar** |
| Pruebas | Pest | 5.3.1 (requiere PHP ≥ 8.4) |
| Formato | Pint | 1.32.1 |
| Base de datos | **ninguna** | — |

Las versiones exactas se leen de `composer.lock` y `package-lock.json`; este documento no las duplica más de lo necesario.

## 2. Dependencias

### 2.1 Regla

Una dependencia nueva requiere: (1) por qué Laravel, Bootstrap o el navegador no lo resuelven; (2) mantenimiento y licencia; (3) tamaño; (4) seguridad (`npm audit` y `composer audit`); (5) aprobación del autor.

### 2.2 Cambios propuestos (requieren aprobación, D5)

| Acción | Paquete | Tipo | Justificación |
|---|---|---|---|
| Agregar | `bootstrap` ^5.3 | dependencies | Framework visual exigido. `@popperjs/core` es *peer dependency*; con solo `Collapse` no se usa, pero npm lo instala |
| Agregar | `sass` | devDependencies | Personalizar Bootstrap con sus variables y compilar solo los módulos usados; evita sobrescribir con CSS |
| Agregar | `@fontsource/inter` | dependencies | Fuente alojada localmente, empaquetada por Vite; sin CDN |
| Quitar | `tailwindcss`, `@tailwindcss/vite` | devDependencies | Sustituidos por Bootstrap |
| Quitar | `bunny()` en `vite.config.js` | — | Bunny Fonts es un CDN |
| Mantener | `vite`, `laravel-vite-plugin`, `concurrently` | devDependencies | Ya existen |
| **No agregar** | Font Awesome, jQuery, Alpine, Livewire, axios, paquetes de SEO/sitemap/CMS | — | Sin necesidad |

Alternativa sin `sass`: personalizar con variables CSS de Bootstrap (`--bs-*`). Funciona para colores globales, pero los botones y otros componentes resuelven sus colores en tiempo de compilación; la paleta de marca quedaría parcheada con selectores. Se recomienda `sass`.

Composer: **no se agregan paquetes**. Se propone retirar `scripts.setup` → `migrate --force` y `post-create-project-cmd` → SQLite de `composer.json` porque no aplican sin base de datos.

## 3. Frontend

- Un entry point CSS y uno JS (ver `03-DISENO-UI-UX.md` §9).
- Vite genera `public/build` con hashes; `@vite([...])` en el layout.
- Fuentes: `@font-face` con archivos `.woff2` que Vite copia a `public/build/assets`. Solo `latin` y pesos 400/600/700.
- **Prohibido:** `<link>`/`<script>` a dominios externos, `@import url(http…)`, `style=""`, `<style>`, JS inline, handlers `on*`.
- Iconos: SVG en Blade.

## 4. Backend

- Controladores finos; sin lógica de contenido.
- Tipos de retorno y parámetros explícitos, `final` en clases de valor, constructor promotion (reglas de Boost).
- Archivos creados con `php artisan make:…` cuando exista el comando (`make:controller`, `make:class`, `make:test --pest`).
- Rutas con nombre; enlaces con `route()`; sin closures en rutas salvo vistas triviales.
- Sin Form Requests, Policies ni Jobs en v1 (no hay formularios, usuarios ni trabajo asíncrono).
- Configuración solo por `.env`/`config/`; nunca `env()` fuera de `config/`.

## 5. Entorno sin base de datos

Valores propuestos para `.env.example` y producción (cambio pendiente de aprobación):

```dotenv
APP_NAME=SantaFeSL
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_AR
APP_URL=http://localhost:8000

DB_CONNECTION=null        # ver nota
SESSION_DRIVER=file       # solo si se mantiene el grupo web con sesión
CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public    # o local; las imágenes usan el disco "public" explícitamente
```

Nota sobre `DB_CONNECTION`: dejarlo como `sqlite` sin usar la base es inofensivo si nada la consulta; ponerlo en `null` detecta usos accidentales. Debe comprobarse al implementar que ningún comando del arranque (`artisan about`, `package:discover`, tests) lo requiera. **No ejecutado.**

Producción: `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY` generada, `LOG_LEVEL=warning` o superior.

## 6. Estrategia de pruebas (Pest)

Sin `RefreshDatabase`. Feature tests por defecto (regla de Boost).

| Prueba | Verifica |
|---|---|
| `PublicPagesTest` | Cada ruta pública responde 200, usa el layout y tiene un único `<h1>` |
| `PublicPagesTest` | `/productos/slug-inexistente` → 404 y un borrador (`published_at` nulo o futuro) → 404 |
| `ContentIntegrityTest` | Para cada elemento de `resources/content/`: `slug` único y con formato válido, campos obligatorios, `status` válido, imagen existente en el disco `public`, `alt` presente. **Es el contrato que se reutilizará contra Eloquent** |
| `SeoTest` | Cada página tiene `<title>` único, `meta description`, `canonical` absoluto y Open Graph; `/sitemap.xml` es XML válido y lista solo contenido publicado |
| `SecurityTest` | Cabeceras de seguridad presentes (§7); respuesta sin `Set-Cookie` (si se aprueba §6.1 de arquitectura) |
| `FrontendRulesTest` | El HTML renderizado **no** contiene `style=`, `<style`, `onclick=`, ni referencias a hosts externos de CSS/JS/fuentes. Hace cumplir las restricciones |
| `LayoutTest` | Skip-link, `lang="es"`, landmarks y `aria-current` en la página activa |

Comandos (Boost): ejecutar lo más acotado posible, `php artisan test --compact --filter=…`; la suite completa la corre el autor. Antes de cerrar una tarea:

```bash
vendor/bin/pint --format agent      # si hubo cambios PHP
php artisan test --compact
npm run build
php artisan route:list --except-vendor
```

CI (cuando exista): `composer audit`, `npm audit`, los cuatro comandos anteriores. Los escáneres de accesibilidad automáticos (axe/Lighthouse) cubren ~30–40 % de los problemas: complementan, no reemplazan, la revisión manual de `03-DISENO-UI-UX.md` §10.

## 7. Seguridad

Superficie mínima: solo `GET`, sin formularios, sin login, sin base de datos, sin subida de archivos.

1. HTTPS obligatorio en producción, redirección 301 desde HTTP, HSTS en el servidor web.
2. `APP_DEBUG=false` y `APP_ENV=production`; páginas 404/500 propias sin trazas.
3. Cabeceras mediante un middleware `SecurityHeaders` (funciona con o sin Docker, independiente del servidor web):
   `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`, `Permissions-Policy` restrictivo, `X-Frame-Options: DENY` (o `frame-ancestors 'none'`) y `Content-Security-Policy` estricta (`default-src 'self'`; `img-src 'self' data:`; sin `unsafe-inline`). Es viable **porque no hay CSS ni JS inline**. En entorno `local` la CSP debe relajarse para el servidor de Vite.
4. Blade con `{{ }}` (escapado); `{!! !!}` prohibido salvo contenido propio revisado.
5. Enlaces externos con `rel="noopener noreferrer"`.
6. `.env` fuera del repositorio; `.env.example` sin secretos; `storage` y `bootstrap/cache` con permisos mínimos.
7. Datos de contacto en variables de entorno; sin correos o teléfonos expuestos en el repositorio si el autor no lo desea.
8. `composer audit` y `npm audit` (`.npmrc` ya tiene `audit=true`) en cada actualización; sin actualizar versiones mayores a ciegas.
9. Sin cookies en v1 (arquitectura §6.1): no hay consentimiento que gestionar.
10. Cuando existan formularios o login (fase posterior): CSRF, `throttle`, validación en servidor, política de contraseñas, sesiones seguras.

## 8. SEO

- Un `<x-seo>` único alimenta `<title>`, `meta description`, `canonical`, Open Graph (`og:title/description/url/type/image/locale`) y `twitter:card`.
- `<title>`: `Página · SantaFeSL`; descripciones únicas de ≤ ~155 caracteres redactadas para personas.
- URL canónica absoluta construida con `APP_URL` (debe ser `https://santafesl.com` en producción).
- `sitemap.xml` generado desde `Catalog` (sin paquete); `robots.txt` con `Sitemap:`.
- HTML semántico, un `<h1>` por página, imágenes con `alt`.
- Páginas de error y borradores con `noindex`.
- Opcional posterior: datos estructurados `Organization`/`SoftwareApplication` en JSON-LD (solo con datos reales confirmados).
- Rendimiento como factor SEO: ver §9.

## 9. Rendimiento y accesibilidad técnica

- Assets con hash y caché larga; HTML con caché corta/ETag en el servidor web.
- Fuentes: 3 archivos `woff2` como máximo; `preload` solo del peso de cuerpo.
- Imágenes con dimensiones, `loading="lazy"`, formatos modernos; sin carruseles.
- Objetivos de referencia (a medir, no garantizados): LCP < 2.5 s, CLS < 0.1, INP < 200 ms en móvil.
- Accesibilidad: ver checklist en `03-DISENO-UI-UX.md` §10.

## 10. Despliegue

Principio: **la aplicación es la misma con o sin Docker**; todo lo específico va en variables de entorno y archivos de despliegue aparte. Ninguna ruta del código asume Docker.

### 10.1 Sin Docker (servidor Linux)

Requisitos: PHP ≥ 8.4 con extensiones estándar de Laravel, Nginx o Apache con *document root* en `public/`, Node solo para compilar (puede compilarse en el equipo del autor o en CI y subir `public/build`).

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build            # o subir public/build ya compilado
cp .env.example .env && php artisan key:generate   # solo la primera vez; editar .env
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Permisos de escritura: `storage/` y `bootstrap/cache/`. Rollback: conservar la versión anterior en un directorio (`releases/` + enlace simbólico) o desplegar desde una etiqueta de Git.

### 10.2 Con Docker (a crear en la Fase 4, no existe aún)

- `Dockerfile` multietapa: etapa Node (`npm ci && npm run build`) → etapa Composer (`--no-dev`) → imagen final PHP-FPM con Nginx (o dos servicios).
- `compose.yaml` con **un** servicio de aplicación; **sin servicio de base de datos**.
- Volúmenes: `storage/logs` y `storage/framework` (cachés/vistas compiladas); para imágenes ver la advertencia siguiente.
- **Advertencia (D8):** un volumen sobre `storage/app/public` oculta las imágenes horneadas en la imagen. Opciones: (a) hornear las imágenes de contenido en la imagen y no montar volumen en esa ruta mientras no haya subidas; (b) montar volumen y cargar las imágenes en él; (c) versionar las imágenes en otra ruta y copiarlas al arrancar. Se recomienda (a) en v1.
- `HEALTHCHECK` contra `/up`.
- Secretos por variables de entorno o *secrets*, nunca dentro de la imagen.
- `.dockerignore`: `.env`, `node_modules`, `vendor`, `.git`, `tests`, `docs`.

### 10.3 Lista de verificación de producción

```text
[ ] HTTPS y redirección desde HTTP
[ ] APP_ENV=production, APP_DEBUG=false, APP_KEY presente
[ ] APP_URL=https://santafesl.com (canonical y sitemap correctos)
[ ] public/build presente y servido con caché larga
[ ] storage:link creado y las imágenes se ven
[ ] config/route/view cache generados
[ ] Cabeceras de seguridad y CSP verificadas
[ ] /up responde 200
[ ] Páginas 404/500 propias
[ ] robots.txt y sitemap.xml correctos
[ ] Backup del código y de storage/app/public; restauración probada
[ ] Procedimiento de actualización y rollback documentado
```

## 11. Git, calidad y honestidad técnica

- Commits pequeños y descriptivos; sin mezclar temas.
- Pint antes de cerrar tareas con PHP; `.editorconfig` respetado.
- **Nunca** afirmar que un test, build, comando o despliegue se ejecutó si no se ejecutó. Si el entorno no lo permite, se dice.

## 12. Definición de terminado

Funciona; cumple las restricciones (se comprueba con `FrontendRulesTest`); tiene pruebas; es responsive y accesible según la checklist; respeta SEO; está documentado; los comandos de §6 se ejecutaron y sus resultados reales se informaron.
