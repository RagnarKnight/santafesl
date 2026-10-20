# Documentación de SantaFeSL

## Manual de mantenimiento (empezar acá)

Guías en español para instalar, cambiar el contenido y publicar el sitio: **[`manual/README.md`](manual/README.md)**.

## Estado de la versión 1 (cierre)

Resumen completo, verificaciones y decisiones pendientes: [`CIERRE-V1.md`](CIERRE-V1.md).

- Diseño visual **aprobado y conservado**.
- Páginas públicas: Inicio, Programas (3 fichas), Servicios, Sobre mí y Contacto.
- **Laboratorio no se publica**: sin rutas, vistas ni enlaces; sus datos se conservan en `resources/content/projects.php`.
- Los tres productos figuran como **Terminado**.
- Contacto: correo y WhatsApp configurados en `.env` (única fuente). Los valores de `.env.example` son **ejemplos**.
- Marca: sin logo definitivo; favicon provisional; sin imagen Open Graph.
- Requisito de PHP: **^8.4.1** (ver `manual/06-actualizar.md`, sección 7, sobre `composer.lock`).

## Documentos vigentes (fase de arquitectura)

| Documento | Contenido |
|---|---|
| [`01-VISION.md`](01-VISION.md) | Propósito, alcance de v1, productos, objetivos |
| [`02-ARQUITECTURA.md`](02-ARQUITECTURA.md) | Estado real del repositorio, MVC sin base de datos, `Catalog`, rutas, componentes, evolución a Eloquent y panel |
| [`03-DISENO-UI-UX.md`](03-DISENO-UI-UX.md) | Sistema visual, contraste verificado, organización de CSS/JS, accesibilidad |
| [`04-ESTANDARES-TECNICOS.md`](04-ESTANDARES-TECNICOS.md) | Versiones, dependencias, pruebas, seguridad, SEO, despliegue con y sin Docker |
| [`05-ROADMAP.md`](05-ROADMAP.md) | Decisiones pendientes D1–D10, fases y riesgos |
| [`06-GUIA-CLAUDE.md`](06-GUIA-CLAUDE.md) | Cómo trabajan Claude y otros agentes en este repositorio |

## Documentos previos conservados

Anteriores a esta fase. Se conservan sin borrar; algunos suponen base de datos y panel desde el inicio y llevan un aviso de estado.

| Documento | Estado |
|---|---|
| [`00-brand.md`](00-brand.md) | **Vigente** (identidad). Pendiente D5 (Font Awesome) y D9 (rojo) |
| [`02-content.md`](02-content.md) | **Vigente** como guía editorial; sus modelos de datos son para la fase de BD |
| [`03-design.md`](03-design.md) | Vigente salvo lo que contradiga `03-DISENO-UI-UX.md` |
| [`04-architecture.md`](04-architecture.md) | Superado por `02-ARQUITECTURA.md` |
| [`05-development.md`](05-development.md) | **Vigente** (reglas de trabajo) |
| [`06-production.md`](06-production.md) | Parcialmente superado por `04-ESTANDARES-TECNICOS.md` §10 |
| [`07-functional-architecture.md`](07-functional-architecture.md), [`08-admin-panel.md`](08-admin-panel.md), [`10-database-design.md`](10-database-design.md), [`11-routes-and-screens.md`](11-routes-and-screens.md) | **Fases 5–6** (BD y panel); referencia, no v1 |
| [`09-technical-decisions.md`](09-technical-decisions.md) | Superado por `04-ESTANDARES-TECNICOS.md` |
| [`12-implementation-plan.md`](12-implementation-plan.md) | Superado por `05-ROADMAP.md` |

Precedencia en caso de conflicto: pedido actual del autor → `01`–`06` y `CLAUDE.md` → resto.

## Registro de cambios de esta fase

- `01-vision.md` se **renombró** a `01-VISION.md` (mismo documento, reescrito; evita dos archivos que solo difieren en mayúsculas) y se actualizó. Texto anterior preservado en la sección 14 como tabla de cambios.
- Se crearon `02`–`06` con los nombres solicitados.
- Se agregó este índice y un aviso de estado al inicio de los documentos previos en conflicto.
- `CLAUDE.md`: se agregó una sección del proyecto **antes** del bloque `<laravel-boost-guidelines>`, que no se modificó. `AGENTS.md` no se tocó (sigue idéntico al bloque Boost).
