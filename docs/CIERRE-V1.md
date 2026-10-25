# Cierre de la versión 1

Resumen de lo hecho en el cierre de la v1, tomando como base `santafesl-redesign-v5`. El diseño aprobado se conservó: no se cambiaron colores, composiciones, tipografías ni tarjetas.

## 1. Cambios realizados

| Tema | Qué se hizo |
|---|---|
| Laboratorio | Retirado de lo público: rutas, controlador, vistas, menú, menú móvil, pie, portada y sitemap. Los datos (`resources/content/projects.php`) y sus ilustraciones **se conservan** y las pruebas los siguen validando. `/laboratorio` devuelve 404 |
| Productos | Se agregó el estado **Terminado** y los tres productos lo usan. Las descripciones no cambiaron |
| Contacto | Correo y WhatsApp salen de **una única fuente** (`.env` → `config/site.php` → `app/Support/SiteContact.php`). Enlace oficial `https://wa.me/<número>?text=…`. Se quitó GitHub del contacto. Los datos de ejemplo se marcan como ejemplo y **no se muestran en producción** |
| Logo y favicon | Con las imágenes entregadas por el autor: logo "SFSL" de **dos tonos** (SF negro, SL rojo) en el encabezado (`storage/app/public/brand/logo.png`, fondo transparente) y favicon cuadrado derivado (SF sobre SL en fondo crema): `public/favicon.ico` (antes vacío) y `public/favicon.png`. Los originales quedan en `resources/brand/` |
| Pruebas | Corregido el test *risky*; ajustadas las pruebas al nuevo alcance; agregadas pruebas de Laboratorio retirado, estado Terminado, contacto y favicon |
| `FrontendRulesTest` | El fallo se debe a `resources/views/welcome.blade.php` (vista por defecto de Laravel, con enlaces externos) que existe en tu repositorio y **no está en el paquete v5**. Hay que eliminarla (comando en la sección 5) |
| PHP | `composer.json` ahora pide `^8.4.1` (lo que exige el lock). `composer.lock` **no se tocó** (ver sección 4) |
| `composer setup` | Usa `npm ci` en lugar de `npm install` |
| Estilos | Una única corrección de accesibilidad: los textos largos del pie y de los botones (un correo largo) se parten en pantallas angostas en lugar de provocar scroll horizontal (`overflow-wrap`, `resources/css/components/_site.scss`) |
| Documentación | README principal nuevo, manual en `docs/manual/` (7 guías), y avisos corregidos en documentos anteriores (se quitó `migrate:fresh --seed`; decisiones D3, D6 y D7 actualizadas) |

## 2. Archivos importantes modificados

- `routes/web.php`, `app/Http/Controllers/{HomeController,SitemapController,ContactController}.php`
- `app/Support/SiteContact.php` (nuevo), `config/site.php`, `.env.example`
- `app/Content/{Entry,Catalog}.php`, `resources/content/{products,projects}.php`
- `resources/views/pages/{home,contact}.blade.php`, `resources/views/components/{layouts/app,site/header,site/footer}.blade.php`
- `resources/css/components/_site.scss`
- `public/favicon.ico`, `public/favicon.png`, `storage/app/public/brand/logo.png`, `resources/brand/*`
- `composer.json`
- `tests/Feature/{PublicPagesTest,ContactPageTest,ContentIntegrityTest,SeoTest,FrontendRulesTest,FaviconTest}.php`
- `README.md`, `docs/manual/*`, `docs/README.md`, `docs/CIERRE-V1.md`

**Eliminados** (hay que borrarlos a mano al aplicar el paquete): `app/Http/Controllers/ProjectController.php`, `resources/views/pages/projects/` y `resources/views/welcome.blade.php`.

## 3. Verificaciones

| Verificación | Resultado | Dónde se ejecutó |
|---|---|---|
| Pruebas (`vendor/bin/pest`) | **110 pruebas, 4406 aserciones, 0 fallos, 0 omitidas, ninguna risky** | PHP 8.4 compilado a WebAssembly (no es un PHP nativo) |
| `vendor/bin/pint --test` | 52 archivos, sin observaciones | PHP 8.4 WebAssembly |
| `npm ci` | Correcto, `package-lock.json` sin cambios | Node 22 |
| `npm run build` | Correcto, sin avisos | Node 22 |
| `npm audit` | 0 vulnerabilidades | Node 22 |
| `composer validate --no-check-publish` | `composer.json` válido; avisa que el lock no está sincronizado (esperado, sección 4) | PHP 8.3.6 |
| Rutas y sitemap | 8 URLs públicas en 200, Laboratorio y URLs inexistentes en 404, 500 sin filtrar datos, sin cookies, CSP presente en todas | PHP 8.4 WebAssembly en modo producción |
| Enlaces internos, imágenes, contacto | 0 enlaces rotos o vacíos, imágenes existentes, enlaces `mailto:` y `wa.me` correctos, ejemplos ocultos en producción | Páginas renderizadas |
| Navegador (Chromium): 5 anchos × 10 páginas | 0 desbordamientos horizontales, 0 imágenes rotas, 0 peticiones externas, 0 violaciones de CSP | Chromium con Playwright |
| Accesibilidad automática (axe-core) | 0 violaciones a 320 y 1440 px | Chromium |
| Pruebas anti-CDN e inline | Pasan; el auditor detecta 10 de 10 casos malos y no da falsos positivos (comprobado en la auditoría previa) | PHP 8.4 WebAssembly |

**Ejecutado antes en esta misma sesión sobre v5 y no repetido sobre el paquete final:** teclado y foco visible en 390 y 1440 px, menú móvil con Enter, instalación de dependencias frente al lock (132 de 132 paquetes coinciden).

**Pendiente de verificar en PHP real:** `composer install` y `composer update --lock` con PHP 8.4.1+ y acceso a Packagist; ejecución con PHP-FPM.

**Pendiente de verificar en el servidor de producción:** HTTPS y redirecciones, cabeceras reales (`curl -sI`), permisos de `storage/` y `bootstrap/cache/`, enlace `public/storage`, comportamiento detrás de un proxy inverso, caché y compresión de `public/build/`. Lista completa en [`manual/07-produccion.md`](manual/07-produccion.md), sección 9.

## 4. Incompatibilidad de PHP y `composer.lock`

`composer.lock` incluye paquetes (Symfony 8, PHPUnit 13, Pest 5) que exigen PHP 8.4.1 como mínimo, mientras `composer.json` decía `^8.3`: con PHP 8.3 la instalación fallaba (comprobado). Se alineó `composer.json` a `^8.4.1`.

No se regeneró `composer.lock`: hacerlo requiere PHP 8.4 y acceso a Packagist, y el entorno de preparación no tenía acceso a Packagist (la conexión fue rechazada). Una instalación real **no se simuló**. Por eso, hasta que lo hagas, `composer validate` avisa que el lock no está al día; `composer install` igualmente instala desde el lock. Pasos exactos en [`manual/06-actualizar.md`](manual/06-actualizar.md), sección 7:

```bash
composer update --lock
composer validate
git diff composer.lock   # solo deben cambiar "content-hash" y "platform"
```

## 5. Instalar y probar (pasos exactos)

Sobre tu repositorio actual:

```bash
tar xzf santafesl-v1-final.tar.gz
rm -f resources/views/welcome.blade.php
rm -f app/Http/Controllers/ProjectController.php
rm -rf resources/views/pages/projects
composer install
cp -n .env.example .env          # si todavía no tenés .env
php artisan key:generate         # solo si APP_KEY está vacío
php artisan storage:link --force
npm ci
npm run build
php artisan test
vendor/bin/pint --test
php artisan serve
```

Si tu `.env` ya existe, agregale las variables nuevas de contacto (`SITE_CONTACT_WHATSAPP_MESSAGE`) y quitá `SITE_CONTACT_GITHUB`, que ya no se usa.

## 6. Decisiones que todavía necesito de vos

1. **Datos reales de contacto:** el correo y el número de WhatsApp definitivos (hoy son ejemplos). Hasta cargarlos en el `.env` del servidor, en producción la página de contacto dice que los canales todavía no están publicados.
2. **D2:** ¿«Catálogo web» corresponde a otro proyecto tuyo (por ejemplo Mercadito WA)? El sitio no lo nombra.
3. **PHP en el servidor:** confirmar que puede usar PHP 8.4.1 o superior. Si no, hay que decidir entre actualizar el servidor o regenerar el lock con versiones anteriores de Symfony, PHPUnit y Pest compatibles con PHP 8.3 (cambio mayor que habría que probar entero).
4. **Proxy inverso:** si el HTTPS termina en un proxy delante de PHP, hay que aplicar la configuración de confianza descrita en `manual/07-produccion.md`, sección 7 (no está incluida).
5. **Textos alternativos** de las ilustraciones: dicen "provisional"; reescribirlos cuando existan las definitivas.
6. **Imagen Open Graph** (la que aparece al compartir el enlace): no existe. Si querés, la preparo con el logo; el manual explica cómo incorporarla (`manual/05-marca.md`, sección 4). Confirmá también que el logo de dos tonos y el favicon apilado son los definitivos.
7. **Herramientas de desarrollo** (`.mcp.json`, `.claude/`, `.agents/`, `boost.json`, `CLAUDE.md`, `AGENTS.md`): siguen en el paquete porque forman parte de tu repositorio. Indicá si querés quitarlas del paquete de despliegue.

## 7. Limitaciones conocidas

- Las direcciones del sitemap usan la dirección con la que llega la petición (no `APP_URL`), mientras que la dirección canónica usa `APP_URL`. Con una configuración correcta del servidor coinciden.
- `/up` (comprobación de salud de Laravel) devuelve la página por defecto de Laravel.
- Los estilos de la sección Laboratorio siguen en el CSS (sin uso) para no tocar el diseño aprobado.
- Los objetivos táctiles de enlaces del menú y el pie miden 20–22 px de alto (la recomendación WCAG 2.2 es 24 px o separación suficiente); no se modificó para respetar el diseño.
- No se probó con lector de pantalla real, dispositivos físicos, Safari ni Firefox, ni se ejecutó Lighthouse.

## 8. Mejora de productos, servicios y conversión (fase posterior)

- **Tarjetas:** botones específicos (Ver cómo funciona / Explorar funciones / Ver una demostración), que llevan a la ficha o a su sección. Se ajustó el recorte de las ilustraciones en móvil para que se vea más la interfaz.
- **Fichas:** problema, público, demostración, funciones y botón de WhatsApp con mensaje por producto. Las funciones son **de referencia** (`features_confirmed = false`): hay que verificarlas.
- **Demostración:** maquetas HTML/CSS marcadas como no reales y componente de video (local o externo bajo demanda) sin reproductor vacío. Para externos se agregó `video_hosts` en `config/site.php` (vacío por defecto: la CSP no cambia).
- **Servicios y Sobre mí:** textos centrados en el beneficio, enlace a los programas y sección de software libre y cultura maker (sin datos biográficos nuevos), con una frase en el pie.
- Guía: [`manual/08-productos-y-videos.md`](manual/08-productos-y-videos.md).
- Pendiente de tu parte: confirmar las funciones reales, cargar el número real y, cuando existan, los videos.

## 9. Página comercial de CHMS

Ficha con las cuatro capturas reales (panel, consolidación, eventos y tesorería), ocho módulos en tarjetas, espacio para el video (por ahora, la captura del panel con aviso) y cierre con WhatsApp. Los textos se verificaron contra las capturas y la especificación funcional. Pendiente de confirmar: el «fondo común» y las «entregas» de eventos (solo figuran en la captura) y qué datos de las capturas pueden mostrarse. Detalle en [`manual/08-productos-y-videos.md`](manual/08-productos-y-videos.md), sección 7.
