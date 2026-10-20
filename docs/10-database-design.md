# Diseño de base de datos

> **Aviso de estado:** referencia para la fase 5. **No aplica a la v1.** Los nombres de atributos de este esquema se reutilizan en `resources/content/*.php` para facilitar la migración (ver `02-ARQUITECTURA.md` §5.2 y §7).

## 1. Objetivo

Proponer un esquema relacional inicial para los contenidos de SantaFeSL. Este diseño se debe contrastar con el motor de base de datos y la versión de Laravel elegidos antes de crear las migraciones definitivas.

## 2. Tablas iniciales

### `users`

La tabla estándar de usuarios de Laravel, ajustada solo si la autenticación elegida lo requiere. La primera versión tendrá un administrador, sin sistema de roles configurable.

### `products`

| Campo | Tipo conceptual | Reglas |
|---|---|---|
| `id` | entero/ID | Clave primaria |
| `name` | string | Obligatorio |
| `slug` | string | Obligatorio; índice único |
| `short_description` | string/text | Obligatorio |
| `description` | text | Obligatorio |
| `status` | string/enum lógico | Valor validado contra estados permitidos |
| `image_path` | string nullable | Ruta gestionada por Storage |
| `external_url` | string nullable | URL validada |
| `featured` | boolean | Por defecto falso |
| `sort_order` | integer | Por defecto cero |
| `seo_title` | string nullable | Opcional |
| `seo_description` | string nullable | Opcional |
| `published_at` | timestamp nullable | Nulo significa borrador |
| `created_at` / `updated_at` | timestamps | Convención Laravel |

### `services`

| Campo | Tipo conceptual | Reglas |
|---|---|---|
| `id` | entero/ID | Clave primaria |
| `name` | string | Obligatorio |
| `slug` | string | Obligatorio; índice único |
| `short_description` | string/text | Obligatorio |
| `description` | text | Obligatorio |
| `category` | string nullable | Texto controlado por validación |
| `featured` | boolean | Por defecto falso |
| `sort_order` | integer | Por defecto cero |
| `seo_title` | string nullable | Opcional |
| `seo_description` | string nullable | Opcional |
| `published_at` | timestamp nullable | Nulo significa borrador |
| `created_at` / `updated_at` | timestamps | Convención Laravel |

### `projects`

| Campo | Tipo conceptual | Reglas |
|---|---|---|
| `id` | entero/ID | Clave primaria |
| `name` | string | Obligatorio |
| `slug` | string | Obligatorio; índice único |
| `short_description` | string/text | Obligatorio |
| `description` | text | Obligatorio |
| `status` | string/enum lógico | Valor validado contra estados permitidos |
| `technologies` | JSON o texto estructurado | Lista simple; elegir según el motor |
| `repository_url` | string nullable | URL validada |
| `demo_url` | string nullable | URL validada |
| `image_path` | string nullable | Ruta gestionada por Storage |
| `featured` | boolean | Por defecto falso |
| `sort_order` | integer | Por defecto cero |
| `seo_title` | string nullable | Opcional |
| `seo_description` | string nullable | Opcional |
| `published_at` | timestamp nullable | Nulo significa borrador |
| `created_at` / `updated_at` | timestamps | Convención Laravel |

## 3. Estados permitidos

Productos:

- `development`
- `beta`
- `production`
- `paused`
- `archived`

Proyectos:

- `idea`
- `in_development`
- `experimental`
- `active`
- `completed`
- `archived`

Los estados deben validarse en la aplicación y mostrarse al usuario con etiquetas legibles en español. Evitar acoplar la interfaz a los identificadores internos.

Los servicios no necesitan estado de ciclo de vida en la primera versión; su disponibilidad pública se determina por `published_at`.

## 4. Unicidad de slugs

Los slugs serán únicos dentro de cada tabla. Por tanto, puede existir el mismo slug en tablas diferentes, aunque es preferible evitarlo si la estructura de rutas pudiera generar ambigüedad.

Los slugs publicados se consideran URLs estables. La aplicación no debe regenerarlos automáticamente en cada edición del nombre.

## 5. Índices

Índices iniciales sugeridos:

- Índice único sobre `slug` en cada tabla.
- Índice sobre `published_at` para consultas públicas por publicación.
- Índice compuesto sobre `featured` y `sort_order` si las consultas y el motor lo justifican.

No agregar índices especulativos sin revisar consultas reales y el motor elegido.

## 6. Tecnologías de proyectos

Para la primera versión, las tecnologías pueden guardarse como una lista simple en un campo JSON si el motor elegido lo soporta de forma consistente. Alternativamente, puede usarse un campo de texto con formato definido por la aplicación.

No crear tablas `technologies`, `project_technology` o taxonomías completas hasta necesitar búsquedas, filtros o reutilización estructurada de tecnologías.

## 7. Imágenes

Guardar rutas relativas administradas por Laravel Storage. No guardar contenido binario de imágenes en las tablas.

Si más adelante se necesitan múltiples imágenes por contenido, se podrá introducir una tabla de medios; no es necesaria para la primera versión.

## 8. Borrado y conservación

La administración debe favorecer la despublicación o el archivo frente al borrado definitivo cuando existan enlaces publicados. Si se implementa borrado físico, limpiar archivos huérfanos de forma segura y evitar borrar archivos compartidos.

No se requiere `SoftDeletes` por defecto; se agregará si existe un requisito claro de recuperación de registros eliminados.

## 9. Migraciones y seeders

- Crear migraciones para todas las tablas y restricciones.
- No editar migraciones que ya se hayan aplicado en un entorno compartido; crear nuevas migraciones para cambios posteriores.
- Usar seeders para datos de demostración en desarrollo y pruebas.
- No sobrescribir contenido real de producción al ejecutar seeders.
- Verificar el resultado de las migraciones en el mismo motor que usará el entorno final.

## 10. Decisiones a confirmar

Antes de crear migraciones definitivas:

- Motor: PostgreSQL o MySQL/MariaDB.
- Representación de `technologies`.
- Longitudes máximas de strings según validaciones de formularios.
- Si se requiere un campo `excerpt` o resumen adicional, evitando duplicar `short_description`.
