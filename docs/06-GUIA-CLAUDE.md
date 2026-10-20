# SantaFeSL — Guía para trabajar con Claude

> Guía operativa para Claude (y otros agentes) en este repositorio. El resumen que se carga automáticamente está en `CLAUDE.md`; este documento lo amplía.

## 1. Antes de empezar cualquier tarea

1. Leer `CLAUDE.md` y, en `docs/`, `05-ROADMAP.md` (fase actual y decisiones D1–D10) y el documento del área tocada.
2. Inspeccionar el repositorio real (`git status`, `composer.json`, `package.json`, lock files) antes de modificar nada.
3. Confirmar que la tarea pertenece a la **fase vigente**. Si es de otra fase, detenerse y preguntar.
4. Si la tarea depende de una decisión sin aprobar (D-x), preguntar en lugar de asumir.

## 2. Precedencia de la documentación

1. Pedido actual del autor.
2. `docs/01`–`06` (documentos vigentes) y `CLAUDE.md`.
3. `docs/00-brand.md`, `02-content.md`, `03-design.md` y `05-development.md` (identidad, contenido y reglas de trabajo; vigentes salvo donde los anteriores digan otra cosa).
4. `docs/04`, `06-production`, `07`–`12` (**plan previo con base de datos y panel**): referencia para fases posteriores, **no** instrucciones para v1. Cada uno lleva un aviso de estado.

## 3. Restricciones que nunca se rompen

- Laravel + Blade; Bootstrap 5 + Vite; **sin CDN**, **sin frameworks JS**, **sin CSS ni JS inline**.
- **Sin base de datos, autenticación, API ni panel** en v1. No tocar `database/` ni crear migraciones.
- Imágenes en `storage/app/public`, publicadas con `storage:link`; URLs con `Storage::disk('public')`.
- Fuentes alojadas localmente (Inter vía `@fontsource/inter`).
- Interfaz y contenido en **español**.
- Dependencias mínimas: no instalar nada sin justificación y aprobación.
- No inventar información comercial: funciones, clientes, métricas, precios, testimonios, datos de contacto.
- Funcionar igual con o sin Docker.

## 4. Cómo se trabaja

- Cambios pequeños y enfocados; reutilizar lo existente antes de crear algo nuevo.
- Archivos completos y corregidos, no fragmentos ni pseudocódigo, cuando se entrega código.
- Crear archivos con `php artisan make:… --no-interaction` cuando exista el comando; tests con `php artisan make:test --pest NombreTest`.
- Seguir las reglas de Boost del propio `CLAUDE.md` (tipos explícitos, llaves siempre, constructor promotion, `route()` para enlaces).
- Convenciones de la arquitectura: contenido solo a través de `Catalog`; las vistas no leen archivos ni arrays de contenido; la regla de publicación vive en un único lugar.
- Componentes Blade solo cuando haya repetición real (dos usos o más).
- Documentar en `docs/` las decisiones que cambien la arquitectura; no documentar como definitivo lo que no existe.

## 5. Qué hacer cuando falta información

Usar `[POR DEFINIR]` en el contenido y dejarlo sin publicar (`published_at = null`). Nunca rellenar con texto «verosímil». Agregar la pregunta a la lista de pendientes del informe final.

## 6. Verificación

Antes de dar por cerrada una tarea, ejecutar lo que el entorno permita:

```bash
vendor/bin/pint --format agent
php artisan test --compact [--filter=…]
npm run build
php artisan route:list --except-vendor
```

- Ejecutar primero lo más acotado; la suite completa la corre el autor (regla de Boost).
- Si el entorno no puede ejecutar algo (sin PHP 8.4, sin red, sin `vendor/`), **decirlo**. Nunca afirmar que algo pasó si no se ejecutó.
- Los cambios de interfaz se prueban en el navegador (móvil y escritorio) cuando hay acceso; si no, informar que no se verificaron visualmente.

## 7. Formato del informe final

1. Archivos creados o modificados (lista).
2. Decisiones tomadas y por qué.
3. Supuestos o dudas pendientes de aprobación.
4. Comandos ejecutados con su resultado real, y los que corresponde ejecutar al autor.

## 8. Prohibiciones explícitas

- No instalar ni actualizar dependencias sin aprobación.
- No eliminar archivos, tests ni skills sin aprobación (ni `.claude/skills/tailwindcss-development` hasta que la Fase 1 lo apruebe).
- No cambiar `.env` ni `.env.example` fuera del alcance aprobado; **nunca** leer ni mostrar valores de `.env`.
- No sobrescribir documentación existente sin analizarla; no editar el bloque `<laravel-boost-guidelines>` de `CLAUDE.md`/`AGENTS.md` (lo regenera `boost:update`).
- No agregar enlaces a dominios externos para CSS, JS, fuentes o imágenes.
- No crear carpetas base nuevas en la raíz sin aprobación (`app/Content/` y `resources/content/` están dentro de directorios existentes).

## 9. Skills y herramientas del repositorio

- `laravel-best-practices`, `testing-best-practices`, `infer-conventions`: aplican.
- `deploying-to-cloud`: aplica solo si se despliega en Laravel Cloud (no está previsto).
- `tailwindcss-development`: **no aplica** (el proyecto usará Bootstrap); queda pendiente retirarla de `boost.json` en la Fase 1.
- Boost MCP (`.mcp.json`): usar `search-docs` antes de depender de una API de Laravel; `database-query` y `database-schema` no se usan en v1.
