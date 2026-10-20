# SantaFeSL — Arquitectura

> **Estado:** aprobada e **implementada** (Fases 1 y 2 del roadmap). Donde el diseño original difería del código, manda la sección 0.

## 0. Cambios respecto a la propuesta aprobada

| Propuesta | Implementado | Motivo |
|---|---|---|
| Clases `Product` y `Service` | Una sola clase `App\Content\Entry` (`type`: products, services o projects) | Tres tipos con la misma forma; evita duplicación real |
| Datos del sitio en `resources/content/site.php` | `config/site.php` (contacto por variables de entorno) | Depende del entorno; el catálogo sigue en `resources/content/` |
| `layouts/app.blade.php` y `<x-seo>` | `components/layouts/app.blade.php` con el SEO integrado | Una sola pieza; sin componente de un único uso |
| `<x-icon>` | No existe | No hay iconos; SVG propios solo si hacen falta |
| Sin `/laboratorio` ni `/sobre-mi` hasta aprobar | Incluidas (decisión del autor) | Alcance de v1 aprobado |
| `SecurityHeaders` en el grupo `web` | Middleware **global** | Los 404 de URLs sin ruta no pasan por el grupo `web` |
| Contenido de productos | Solo nombre y tipo de sistema confirmados | Sin información comercial inventada |
| `storage/framework/*` | Se agregaron los `.gitignore` faltantes | Un clon limpio daba error 500 (no existía el directorio de vistas compiladas) |

## 1. Estado actual del repositorio (inspeccionado)

Hechos comprobados leyendo el árbol entregado (no se ejecutó PHP, Composer ni Node contra el proyecto, ver §1.4).

### 1.1 Versiones

| Componente | Declarado | Bloqueado (lock) |
|---|---|---|
| PHP | `composer.json`: `^8.3` | Pest 5.3.1 y `symfony/process` 8.1.7 exigen **PHP ≥ 8.4**; `CLAUDE.md` (Boost) indica PHP 8.4 |
| Laravel | `^13.17` | **13.35.0** |
| Pest / plugin Laravel | `^5.3` / `^5.0` | 5.3.1 / 5.0.1 |
| Pint | `^1.27` | 1.32.1 |
| Boost | `^2.2` | 2.10.3 |
| Vite | `^8.0.0` | 8.3.4 (Node `^20.19 \|\| >=22.12`) |
| laravel-vite-plugin | `^3.1` | 3.2.0 |
| Tailwind / `@tailwindcss/vite` | `^4.0.0` | 4.3.3 |
| Bootstrap, Sass, Inter | **no instalados** | — |

**Inconsistencia detectada:** `composer.json` declara `php ^8.3`, pero el lock solo se puede instalar con PHP 8.4+. Propuesta: declarar `^8.4` (decisión D7).

### 1.2 Configuración que ya existe y entra en conflicto con las restricciones

| Archivo | Situación | Conflicto |
|---|---|---|
| `package.json`, `vite.config.js`, `resources/css/app.css` | Tailwind 4 + `bunny()` de `laravel-vite-plugin/fonts` | Debe ser Bootstrap 5; **Bunny Fonts es un CDN** (viola «sin CDN») |
| `resources/views/welcome.blade.php` | Página de bienvenida con `<style>` incrustado y directiva `@fonts` | CSS inline y fuentes remotas |
| `.env.example` / `.env` | `DB_CONNECTION=sqlite`, `SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=database`, `APP_LOCALE=en` | Sesión, caché y colas **dependen de la base de datos** |
| `database/database.sqlite` + 3 migraciones por defecto (`users`, `cache`, `jobs`) | Existe y tiene tablas | No se usa en v1; el archivo está ignorado por `database/.gitignore` |
| `composer.json` scripts | `setup` ejecuta `migrate --force`; `post-create-project-cmd` crea el SQLite | Falla o crea una BD innecesaria en un proyecto sin base de datos |
| `boost.json` | Skills incluye `tailwindcss-development` | Dejará de aplicar al quitar Tailwind |
| `storage/app/public/` | **No existe** en el árbol | `storage:link` apuntaría a un directorio inexistente |
| `.gitignore` | Ignora `/public/build`, `/public/storage`, `.env` | Correcto |
| `bootstrap/app.php` | Health check `/up` activo; grupo `web` completo (sesión, CSRF, cookies) | Cada visitante recibiría cookie y archivo de sesión sin necesitarlos |
| `phpunit.xml` | `DB_CONNECTION=sqlite`/`:memory:`, `CACHE_STORE=array`, `SESSION_DRIVER=array` | Compatible con tests sin base de datos real |
| `tests/Pest.php` | Feature tests con `TestCase`; `RefreshDatabase` comentado | Correcto para v1 |

### 1.3 Convenciones ya presentes (se conservan)

- Laravel 13 estándar: `bootstrap/app.php` con `withRouting`, `routes/web.php`, PSR-4 `App\`.
- Pest como framework de pruebas, Pint como formateador, `.editorconfig` (4 espacios, LF).
- `.npmrc`: `ignore-scripts=true` y `audit=true` (se respeta; ver §10).
- Boost + skills en `.claude/skills` y `.agents/skills`, MCP en `.mcp.json`.
- Reglas de Boost en `CLAUDE.md`/`AGENTS.md` (idénticos): no crear carpetas base ni cambiar dependencias sin aprobación; usar `make:` de Artisan; tests Pest.
- Idioma de la interfaz: español.

### 1.4 Lo que no se pudo verificar

El entorno de análisis tiene PHP 8.3.6, no tiene `vendor/` ni `node_modules/` y no puede alcanzar Packagist. Por eso **no se ejecutaron** `composer install`, `php artisan route:list`, `php artisan test`, `npm run build` ni Pint. La primera tarea del roadmap (Fase 1) es correr esa línea base en la máquina del autor.

## 2. Principios

1. Laravel convencional: MVC, Blade, rutas con nombre, controladores pequeños.
2. **Una sola costura** entre contenido y vistas (`Catalog`, §5).
3. Ninguna abstracción sin un problema real que resolver.
4. Sin base de datos, autenticación, API ni panel en v1.
5. Sin CDN, sin CSS inline, sin frameworks JS.
6. Cada dependencia nueva se justifica por escrito (`04-ESTANDARES-TECNICOS.md` §2).

## 3. Visión general

```text
Navegador
   │  HTTPS
   ▼
Servidor web (Nginx/Apache, con o sin Docker)  →  public/ (build, storage, robots.txt)
   │
   ▼
Laravel 13 (sin base de datos)
   ├── routes/web.php            rutas públicas GET
   ├── Http/Controllers          coordinan; no contienen texto de contenido
   ├── Content/Catalog           ÚNICA fuente de lectura de productos y servicios
   │       └── resources/content/*.php   (datos de v1)
   ├── resources/views           Blade: layouts, componentes, páginas
   └── storage/app/public        imágenes (publicadas con storage:link)
```

## 4. MVC en v1

| Capa | Qué hay | Qué no hay |
|---|---|---|
| **Model** | Objetos de valor `App\Content\Product` y `Service` (clases `final readonly`, sin Eloquent) | Eloquent, migraciones, factories |
| **View** | Blade con componentes anónimos | Lógica de contenido, CSS inline, JS inline |
| **Controller** | `HomeController`, `ProductController`, `ServiceController`, `ContactController`, `SitemapController` | Form Requests (no hay formularios), Policies |
| **Contenido** | `resources/content/*.php` + `Catalog` | Servicios, repositorios, DTO adicionales |

## 5. Cómo se organizan productos y servicios sin base de datos

### 5.1 Decisión

El contenido vive en **archivos PHP que devuelven arrays** dentro de `resources/content/`. Una clase pequeña, `App\Content\Catalog`, los lee y entrega objetos de valor a los controladores.

Alternativas descartadas:

| Alternativa | Motivo del descarte |
|---|---|
| Datos dentro de las vistas Blade | Acopla contenido y presentación; justo lo que se quiere evitar |
| `config/*.php` | `config:cache` mezcla contenido con configuración técnica; el contenido no depende del entorno |
| JSON | Sin comentarios, sin constantes, sin enums; PHP valida la sintaxis y permite autocompletar |
| YAML / Markdown con front matter | Exige dependencia (parser) que hoy no se necesita |
| Base de datos SQLite | Prohibida hasta que exista una necesidad real |
| Eloquent con `Sushi` u otro paquete de arrays | Dependencia innecesaria |

`resources/content/` es una subcarpeta de `resources/`, un directorio base que ya existe; no se crea ningún directorio base nuevo (regla de Boost).

### 5.2 Forma de los datos

Los **nombres de los atributos coinciden con las columnas previstas** en `docs/10-database-design.md` para que la futura migración no obligue a renombrar nada en las vistas:

```php
// resources/content/products.php  (ejemplo de forma, NO contenido real)
return [
    [
        'slug'              => '[POR-DEFINIR]',
        'name'              => '[POR DEFINIR]',
        'short_description' => '[POR DEFINIR]',
        'description'       => '[POR DEFINIR]',
        'status'            => 'development',   // development|beta|production|paused|archived (D6)
        'image_path'        => null,            // relativo al disco "public", p. ej. products/<slug>/hero.webp
        'image_alt'         => null,
        'features'          => [],              // lista simple de textos confirmados
        'featured'          => false,
        'sort_order'        => 0,
        'published_at'      => null,            // null = borrador; fecha pasada = publicado
        'seo_title'         => null,
        'seo_description'   => null,
    ],
];
```

`services.php` usa la misma idea con `category` en lugar de `status` e `image_path`.

`resources/content/site.php` guarda datos transversales: nombre, descriptor, URL base, canales de contacto (WhatsApp, correo, GitHub). **Los valores reales aún no existen**; los datos sensibles de contacto se leen de variables de entorno (`SITE_CONTACT_EMAIL`, `SITE_CONTACT_WHATSAPP`) en lugar de escribirse en el repositorio.

### 5.3 `Catalog` (la única costura)

```php
namespace App\Content;

final class Catalog
{
    /** @return list<Product> publicados, ordenados por sort_order y nombre */
    public function products(): array {}

    /** @return list<Product> publicados y destacados */
    public function featuredProducts(): array {}

    public function product(string $slug): ?Product {}   // null si no existe o no está publicado

    /** @return list<Service> */
    public function services(): array {}
}
```

Reglas:

- Es la **única** clase que conoce de dónde salen los datos.
- Aplica la regla de publicación en un solo lugar: `published_at !== null && published_at <= now()`.
- Se inyecta por el contenedor (sin interfaz, sin registro manual: Laravel la resuelve solo).
- Valida el formato al cargar (falla rápido con excepción clara si falta `slug` o `name`). La integridad también se prueba con un test (ver `04-ESTANDARES-TECNICOS.md` §6).
- Cachea el resultado en memoria durante la petición; no necesita caché persistente.

### 5.4 Contrato con las vistas

Las vistas reciben objetos con **propiedades documentadas** (`$product->name`, `$product->short_description`, …) y nunca acceden a arrays ni a archivos. Ese contrato es lo que permite el cambio descrito en §7.

### 5.5 Imágenes

- Ubicación: `storage/app/public/products/{slug}/…` y `storage/app/public/services/{slug}/…` (disco `public`, ya definido en `config/filesystems.php`).
- Publicación: `php artisan storage:link` (mecanismo estándar; `public/storage` está en `.gitignore`).
- URL en vistas: `Storage::disk('public')->url($path)`, nunca rutas escritas a mano.
- Formato: WebP/AVIF/PNG/JPEG. SVG solo si es propio y revisado.
- Texto alternativo en el contenido (`image_alt`); decorativas con `alt=""`.
- **Problemas a resolver (D8):** (a) `storage/app/public/` no existe en el repositorio y su `.gitignore` típico ignora todo su contenido; para versionar imágenes de producto hay que decidir qué se versiona; (b) con Docker, un volumen montado sobre `storage/app/public` **oculta** las imágenes incluidas en la imagen del contenedor.

## 6. Rutas públicas propuestas

Todas `GET`. URLs en español, nombres de ruta en inglés (convención Laravel y coherencia con `docs/11`).

| URL | Nombre | Controlador | Notas |
|---|---|---|---|
| `/` | `home` | `HomeController` (invocable) | Hero, productos destacados, servicios, CTA |
| `/productos` | `products.index` | `ProductController@index` | Estado vacío si no hay publicados |
| `/productos/{slug}` | `products.show` | `ProductController@show` | 404 si no existe o no está publicado |
| `/servicios` | `services.index` | `ServiceController@index` | Página única; sin detalle por servicio en v1 |
| `/contacto` | `contact` | `ContactController` (invocable) | Enlaces `mailto:`/WhatsApp/GitHub; sin formulario |
| `/sitemap.xml` | `sitemap` | `SitemapController` (invocable) | Vista XML generada desde `Catalog` |
| `/robots.txt` | — | archivo estático en `public/` | Con línea `Sitemap:` |
| `/up` | — | Laravel | Ya configurado |

Convenciones: `where('slug', '[a-z0-9-]+')` en la ruta de detalle; enlaces siempre con `route()`; redirección 301 si en el futuro cambia un slug.

**Cierre de la v1:** `/sobre-mi` está publicada; `/laboratorio` y `/laboratorio/{slug}` **se retiraron** (decisión del autor): no hay rutas, vistas, controlador ni enlaces. Los datos de `resources/content/projects.php` se conservan.

### 6.1 Sin sesión ni cookies en v1

Propuesta: quitar del grupo `web` los middlewares de sesión, errores de sesión y CSRF mediante `$middleware->web(remove: [...])` en `bootstrap/app.php`. Resultado: sin cookies, sin archivos de sesión por visitante, respuestas cacheables y sin aviso de cookies. Cuando llegue el panel (§7) se define un grupo con sesión solo para `/admin`. **Hay que verificarlo con tests al implementarlo**; no se ha ejecutado.

## 7. Evolución a Eloquent y panel administrativo

Objetivo: que cada paso toque el mínimo de archivos y **ninguna vista**.

| Paso | Cambio | Vistas | Controladores |
|---|---|---|---|
| 0. v1 | `Catalog` lee `resources/content/*.php` | — | Usan `Catalog` |
| 1. Decidir motor | Elegir MariaDB/MySQL (u otro) y registrar la decisión | — | — |
| 2. Persistencia | Migraciones `products` y `services` con las columnas del §5.2; modelos `App\Models\Product`/`Service` con `casts` (status → enum, `published_at` → datetime) | **Sin cambios** | — |
| 3. Importar | Seeder que carga `resources/content/*.php` en la BD (el contenido de v1 no se pierde) | — | — |
| 4. Cambiar la fuente | `Catalog` pasa a consultar los modelos (`scopePublished()`); o se elimina y los controladores usan los modelos directamente con `{product:slug}` | **Sin cambios** | Cambio mínimo |
| 5. Sesión y base | Cambiar `SESSION_DRIVER`/`CACHE_STORE` solo si se justifica; migrar la BD | — | — |
| 6. Panel | Prefijo `/admin`, autenticación oficial de Laravel, `Form Requests`, `Policies`, subida de imágenes al **mismo** disco `public` y misma convención de rutas | Vistas propias del panel | Controladores `Admin\…` |
| 7. Retirar | Borrar `resources/content/products.php` y `services.php` cuando el seeder ya no sea necesario | — | — |

Qué garantiza que el contenido no quede acoplado a las vistas:

1. Las vistas solo usan atributos; no saben si vienen de un array o de Eloquent.
2. Los nombres de atributos ya son los de las columnas futuras.
3. La regla de publicación existe en un solo lugar (`Catalog` hoy, un *scope* mañana).
4. Hay un test de contrato (`ContentIntegrityTest`) que se reutiliza contra los modelos.
5. Las imágenes ya están en el disco `public` con una convención de rutas estable.

No se crean interfaces (`CatalogInterface`) ni repositorios: con una sola implementación son ruido. Si algún día hubiera dos, se extrae entonces.

## 8. Estructura de directorios propuesta

Solo se agrega lo marcado `+`. No se crean carpetas base nuevas.

```text
app/
├── Content/                 + Catalog, Product, Service (objetos de valor)
├── Http/Controllers/        + Home, Product, Service, Contact, Sitemap
├── Http/Middleware/         + SecurityHeaders (ver 04-ESTANDARES §7)
└── Providers/               (sin cambios)
resources/
├── content/                 + site.php, products.php, services.php
├── css/                       app.scss y parciales (reemplaza app.css de Tailwind)
├── js/                        app.js (solo Collapse de Bootstrap)
└── views/
    ├── layouts/app.blade.php  + layout único
    ├── components/            + componentes anónimos (ver §9)
    ├── pages/                 + home, contact, products/{index,show}, services/index
    ├── errors/                + 404.blade.php, 500.blade.php en español
    └── sitemap.blade.php      + XML
public/
├── robots.txt               (actualizar)
└── favicon*, og-default.*   + (cuando existan los recursos)
storage/app/public/          + products/, services/  (imágenes)
tests/Feature/               + PublicPagesTest, ContentIntegrityTest, SeoTest, SecurityTest
docs/                        documentación
```

## 9. Componentes Blade

Anónimos (`resources/views/components/*.blade.php`), sin clases PHP salvo necesidad:

| Componente | Uso |
|---|---|
| `<x-layouts.app>` | Layout: `<head>` con SEO, skip-link, header, `<main id="contenido">`, footer |
| `<x-site.header>` / `<x-site.footer>` | Navegación y pie |
| `<x-page-header>` | `<h1>` + descripción de cada página |
| `<x-section>` | Sección con título (`<h2>`) y espaciado coherente |
| `<x-product-card>` / `<x-service-card>` | Tarjetas de listado |
| `<x-status-badge>` | Estado del producto (texto + color, nunca solo color) |
| `<x-cta-contact>` | Llamado a contacto reutilizable |
| `<x-icon>` | SVG inline desde un conjunto reducido (D5) |
| `<x-seo>` | `<title>`, description, canonical, Open Graph, `robots` |

Regla: se crea un componente cuando el fragmento se repite al menos dos veces o tiene lógica de presentación propia.

## 10. CSS y JavaScript

Detalle en `03-DISENO-UI-UX.md` §9 y `04-ESTANDARES-TECNICOS.md` §3. Resumen:

- Un único entry point CSS (`resources/css/app.scss`) y uno JS (`resources/js/app.js`).
- Bootstrap 5 compilado con Sass, importando solo los módulos que se usan.
- JS: únicamente `bootstrap/js/dist/collapse` para el menú móvil.
- Sin CSS ni JS inline; sin librerías de iconos; fuente Inter propia.

## 11. Pruebas, accesibilidad, SEO y despliegue

Se detallan en `04-ESTANDARES-TECNICOS.md` (§6 pruebas, §7 seguridad, §8 SEO, §9 accesibilidad, §10 despliegue).

## 12. Qué no se hace (y por qué)

| Descartado | Motivo |
|---|---|
| Repositorios, interfaces, DTO genéricos, capa de servicios | Una sola fuente de datos y un solo consumidor |
| Paquete de CMS / headless / markdown | Dependencia sin necesidad actual |
| API JSON | Fuera de alcance |
| Livewire/Alpine/Vue | Prohibido por restricción |
| `config:cache` para el contenido | El contenido no es configuración |
| Caché persistente | Páginas pequeñas y estáticas; se resuelve mejor con caché HTTP en el servidor web |

## 13. Decisiones pendientes

Ver `05-ROADMAP.md` §2 (D1–D10).
