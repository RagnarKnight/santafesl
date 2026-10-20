# SantaFeSL — Roadmap

> **Estado:** propuesta. Reemplaza a `12-implementation-plan.md` (que suponía base de datos y panel desde la primera versión). Cada fase termina con el proyecto funcionando y verificado.

## 0. Estado

| Fase | Estado |
|---|---|
| 0 Arquitectura | Hecha |
| 1 Base de frontend y entorno | **Hecha** (ver §6) |
| 2 Contenido y páginas públicas | **Hecha** con el contenido mínimo confirmado |
| 3 SEO, accesibilidad y seguridad | Parcial: título, descripción, canonical, Open Graph, sitemap, robots, cabeceras y CSP implementados; falta imagen Open Graph, favicon, auditoría manual de accesibilidad y Lighthouse |
| 4 Despliegue con y sin Docker | Pendiente |
| 5–6 BD y panel | Posteriores |

Decisiones resueltas por el autor: D1 (aprobada, con una sola clase `Entry`), D3 (en el **cierre de la v1** el autor decidió **no publicar Laboratorio**; Sobre mí sí se publica), D4, D5 (Bootstrap, Sass, `@fontsource/inter`; sin Font Awesome), D6 (los tres productos figuran como **Terminado**), D7 (`php` ^8.4.1 en `composer.json`; **queda pendiente** sincronizar `composer.lock` con `composer update --lock` en un entorno con PHP 8.4 y Packagist, ver `manual/06-actualizar.md` §7), D8 (imágenes versionadas en Git, sin volumen que las oculte), D9 (`#C62828`). Siguen abiertas: **D2** (¿el catálogo web es Mercadito WA?; el sitio no lo nombra) y **D10** (aplicada la versión sin sesión y con CSP; queda confirmar).

## 1. Reglas del roadmap

- Una fase por vez; no se empieza la siguiente sin cerrar la anterior.
- Las dependencias y los cambios de configuración listados en cada fase **requieren aprobación explícita**.
- Cada cierre informa: archivos cambiados, comandos **realmente ejecutados** y su resultado, pendientes.

## 2. Decisiones que requieren aprobación

| ID | Decisión | Propuesta | Alternativa | Bloquea |
|---|---|---|---|---|
| **D1** | Contenido en `resources/content/*.php` + clase `Catalog` (arquitectura §5) | Aprobar | Datos en Blade (descartado) | Fase 2 |
| **D2** | ¿El «catálogo web» es Mercadito WA? Los docs previos lo describían como «punto de venta simple», lo que se solapa con el POS | Confirmar nombres comerciales y descripción de los 3 productos | — | Contenido (Fase 2) |
| **D3** | ¿Entran en v1 `/sobre-mi` y `/laboratorio`? Están en los docs previos, no en el pedido actual | Solo Inicio, Productos, Servicios y Contacto | Sumar páginas | Navegación (Fase 1) |
| **D4** | Contacto sin formulario | Enlaces `mailto:`, WhatsApp y GitHub | Formulario (exige correo saliente, antispam, política de datos) | Contenido |
| **D5** | Dependencias: agregar `bootstrap`, `sass`, `@fontsource/inter`; quitar `tailwindcss`, `@tailwindcss/vite` y `bunny()`; **iconos sin librería** (SVG inline). El brief de marca nombra Font Awesome | Aprobar | Mantener Font Awesome (más peso, otra dependencia); no usar `sass` (personalizar con `--bs-*`) | Fase 1 |
| **D6** | Estados de producto: `development`, `beta`, `production`, `paused`, `archived` | Confirmar y luego crear un enum | Otros valores | Fase 2 |
| **D7** | `composer.json`: `php` de `^8.3` a `^8.4` (el lock ya lo exige); retirar `migrate` del script `setup` y el `touch` de SQLite | Aprobar | Dejar como está | Fase 1 |
| **D8** | Imágenes: ¿se versionan en Git? `storage/app/public` no existe y su `.gitignore` típico ignora el contenido; con Docker un volumen las oculta | Versionar `storage/app/public/{products,services}` y hornearlas en la imagen mientras no haya subidas | Subirlas aparte por despliegue | Fase 2 y 4 |
| **D9** | Rojo accesible: `#E53935` (4.23:1) no cumple AA para texto/botones | Token `#C62828` para texto y botones; `#E53935` solo decorativo | Mantener y limitar a texto grande | Fase 1 |
| **D10** | Sin sesión ni cookies en v1 (`web` sin `StartSession`/CSRF) y middleware `SecurityHeaders` con CSP estricta | Aprobar | Mantener grupo `web` estándar | Fase 1 y 3 |

Datos que solo el autor puede dar (no se inventan): nombre comercial y descripción real de cada producto, funciones confirmadas, estado real, capturas, servicios que ofrece, canales de contacto, logo y favicon, dominio de producción.

## 3. Fases

### Fase 0 — Análisis y arquitectura *(esta entrega)*

Documentación `docs/01`–`06`, `CLAUDE.md` e índice `docs/README.md`. **Sin cambios de código ni dependencias.**

### Fase 1 — Base de frontend y entorno *(requiere D3, D5, D7, D9, D10)*

1. En la máquina del autor, correr la **línea base** y registrar el resultado: `composer install`, `php artisan test --compact`, `npm ci`, `npm run build`.
2. Reemplazar Tailwind por Bootstrap + Sass + Inter local; actualizar `vite.config.js`, `package.json`, `resources/css`, `resources/js`.
3. Crear `layouts/app.blade.php`, `<x-site.header>`, `<x-site.footer>`, `<x-seo>`, `<x-icon>`; reemplazar `welcome.blade.php`.
4. `.env.example` sin base de datos (arquitectura §1.2 y estándares §5); `APP_LOCALE=es`.
5. `bootstrap/app.php`: grupo `web` sin sesión/CSRF (D10) y registro de `SecurityHeaders`.
6. Ajustar `composer.json` (D7) y `boost.json` (quitar `tailwindcss-development`, luego `php artisan boost:update`).
7. Crear `storage/app/public/` y probar `php artisan storage:link`.
8. Tests: `PublicPagesTest` (inicio), `FrontendRulesTest`, `LayoutTest`.

**Salida:** `npm run build` y `php artisan test` en verde; el inicio se ve con Bootstrap y Inter sin pedidos a dominios externos (verificado en la pestaña Red del navegador).

### Fase 2 — Contenido y páginas públicas *(requiere D1, D2, D4, D6, D8)*

1. `App\Content\{Catalog, Product, Service}` y `resources/content/{site,products,services}.php`.
2. Controladores y rutas de `02-ARQUITECTURA.md` §6; vistas de Inicio, Productos, Producto, Servicios, Contacto; 404/500.
3. Componentes de tarjeta, estado y CTA.
4. Contenido **real** aportado por el autor; lo que falta queda como borrador (`published_at = null`).
5. Tests: `PublicPagesTest` completo, `ContentIntegrityTest`.

**Salida:** todas las rutas responden; borradores → 404; estados vacíos correctos; tests y build en verde.

### Fase 3 — SEO, accesibilidad y seguridad

1. `<x-seo>` completo, `sitemap.xml`, `robots.txt`, imagen Open Graph, favicon.
2. Cabeceras y CSP; verificación de ausencia de cookies.
3. Revisión de accesibilidad: checklist de `03-DISENO-UI-UX.md` §10, teclado, lector de pantalla, zoom 200 %, 320 px.
4. Rendimiento: peso de fuentes e imágenes, Lighthouse como referencia.
5. `composer audit` y `npm audit`.
6. Tests: `SeoTest`, `SecurityTest`.

**Salida:** checklist completada y registrada con resultados reales.

### Fase 4 — Despliegue con y sin Docker

1. Guía de despliegue sin Docker verificada en un servidor de prueba.
2. `Dockerfile` multietapa, `compose.yaml` sin base de datos, `.dockerignore`, `HEALTHCHECK` (estándares §10.2).
3. Procedimientos de actualización, rollback y backup de `storage/app/public`.

**Salida:** el mismo código despliega con ambos métodos; checklist de producción (estándares §10.3) completa.

### Fase 5 *(posterior, solo si surge la necesidad)* — Base de datos y Eloquent

Sigue `02-ARQUITECTURA.md` §7, pasos 1–5. Requiere decidir el motor (para el stack habitual, MariaDB/MySQL), crear migraciones y modelos, un seeder que importe `resources/content/`, y cambiar la fuente de `Catalog` sin tocar vistas. `ContentIntegrityTest` se reutiliza como prueba de contrato.

### Fase 6 *(posterior)* — Panel administrativo

Sigue §7, paso 6: autenticación oficial de Laravel sin registro público, `/admin` con sesión propia, CRUD de productos y servicios, Form Requests, Policies, subida segura de imágenes (tipo MIME real, tamaño, sin SVG, nombres generados) al disco `public`, publicación/despublicación. Los documentos `07`, `08`, `10` y `11` son el punto de partida de esta fase.

## 4. Lista de verificación por entrega

- [ ] Alcance de la fase completo y nada de otra fase.
- [ ] Dependencias nuevas aprobadas y justificadas.
- [ ] `vendor/bin/pint --format agent` (si hubo PHP).
- [ ] `php artisan test --compact` y `npm run build` ejecutados; resultado real informado.
- [ ] `php artisan route:list --except-vendor` revisado.
- [ ] Sin CDN, sin CSS/JS inline (`FrontendRulesTest`).
- [ ] Accesibilidad y responsive revisados si hubo cambios de interfaz.
- [ ] Documentación actualizada; pendientes y decisiones abiertas enumerados.

## 5. Riesgos

| Riesgo | Mitigación |
|---|---|
| Publicar funciones o datos no confirmados | Contenido `[POR DEFINIR]` no publicable; revisión del autor antes de poner `published_at` |
| PHP 8.3 local frente al lock que exige 8.4 | D7 y comprobar `php -v` en la línea base |
| Imágenes perdidas al desplegar (Docker o Git) | D8 y test que comprueba su existencia |
| Contraste insuficiente del rojo de marca | D9 |
| Los docs previos 07–12 llevan a implementar BD/panel por error | Banner de estado en cada uno y precedencia fijada en `CLAUDE.md` |
| `boost:update` (post-update de Composer) reescribe `CLAUDE.md` | Las reglas del proyecto viven fuera del bloque `<laravel-boost-guidelines>` |

## 6. Registro de la implementación (Fases 1 y 2)

**Creados:** `app/Content/{Catalog,Entry}.php`; `app/Http/Controllers/{Home,Product,Project,Service,About,Contact,Sitemap}Controller.php`; `app/Http/Middleware/SecurityHeaders.php`; `config/site.php`; `resources/content/{products,services,projects}.php`; `resources/css/{app.scss,abstracts/_variables.scss,abstracts/_theme.scss,base/_fonts.scss,components/_site.scss}`; vistas en `resources/views/{components,pages,errors}` y `sitemap.blade.php`; `storage/app/public/.gitkeep` y los `.gitignore` de `storage/`; pruebas en `tests/Feature`, `tests/Unit` y `tests/Support/HtmlAudit.php`.

**Modificados:** `package.json` y `package-lock.json` (Tailwind fuera; `bootstrap`, `sass`, `@fontsource/inter` dentro); `vite.config.js`; `resources/js/app.js`; `routes/web.php`; `bootstrap/app.php`; `config/app.php` (locale `es`, nombre `SantaFeSL`); `.env.example`; `composer.json` (solo `scripts`: se quitó `migrate` y el SQLite); `boost.json` (sin la skill de Tailwind); `public/robots.txt`; `tests/Pest.php` (`withoutVite()`); `CLAUDE.md`; esta documentación.

**Eliminados (justificado por «eliminar Tailwind»):** `resources/css/app.css`, `resources/views/welcome.blade.php` (CSS inline y fuentes remotas) y `.claude/skills/tailwindcss-development`, `.agents/skills/tailwindcss-development`.

**No modificados:** `composer.lock`, `.env`, `database/`, `AGENTS.md`.

**`php` en `composer.json` (D7):** declara `^8.3`, pero `composer.lock` fija paquetes que exigen PHP ≥ 8.4.1 (Symfony 8.1, PHPUnit 13, Pest 5.3). Con PHP 8.3 `composer install` falla. El cambio correcto es `"php": "^8.4"`, pero cambia el hash del lock y hay que regenerarlo con `composer update --lock` donde haya acceso a Packagist; por eso no se tocó.
