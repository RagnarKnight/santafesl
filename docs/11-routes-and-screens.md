# Rutas y pantallas

> **Cierre de la v1:** `/laboratorio` y `/laboratorio/{slug}` no están publicadas.
>
> **Aviso de estado:** las rutas públicas están actualizadas en `02-ARQUITECTURA.md` §6 (sin `/laboratorio` ni `/sobre-mi` hasta la decisión D3). Las rutas `/admin` corresponden a la fase 6.

## 1. Objetivo

Definir las rutas públicas y administrativas de la primera versión de SantaFeSL, con URLs legibles y responsabilidades claras.

## 2. Rutas públicas

| Método | Ruta | Propósito |
|---|---|---|
| GET | `/` | Inicio |
| GET | `/productos` | Listado de productos publicados |
| GET | `/productos/{product:slug}` | Detalle de producto publicado |
| GET | `/servicios` | Listado de servicios publicados |
| GET | `/laboratorio` | Listado de proyectos publicados |
| GET | `/laboratorio/{project:slug}` | Detalle de proyecto publicado |
| GET | `/sobre-mi` | Presentación |
| GET | `/contacto` | Información de contacto |

Las rutas de detalle deben resolver solo contenido publicado. Un borrador no debe ser accesible conociendo su slug.

La ruta `/servicios/{slug}` no se incluye inicialmente porque la primera versión contempla una página general de servicios. Puede agregarse si cada servicio necesita una página de detalle independiente.

## 3. Rutas administrativas

Prefijo `/admin`, protegidas por autenticación.

| Método | Ruta | Propósito |
|---|---|---|
| GET | `/admin` | Resumen del panel |
| GET | `/admin/products` | Listado |
| GET/POST | `/admin/products/create` | Formulario y creación |
| GET/PATCH/DELETE | `/admin/products/{product}` | Editar, actualizar o eliminar según convención adoptada |
| GET | `/admin/services` | Listado |
| GET/POST | `/admin/services/create` | Formulario y creación |
| GET/PATCH/DELETE | `/admin/services/{service}` | Editar, actualizar o eliminar según convención adoptada |
| GET | `/admin/projects` | Listado |
| GET/POST | `/admin/projects/create` | Formulario y creación |
| GET/PATCH/DELETE | `/admin/projects/{project}` | Editar, actualizar o eliminar según convención adoptada |

La tabla resume las acciones. La implementación debe seguir las convenciones REST de Laravel (`index`, `create`, `store`, `edit`, `update`, `destroy`) y no necesariamente declarar cada acción en una única ruta con varios métodos.

## 4. Autenticación

Se usará una solución de autenticación compatible con la versión de Laravel seleccionada. No habrá registro público.

La ruta de login dependerá del starter kit o mecanismo oficial elegido. Las rutas privadas deberán aplicar middleware de autenticación.

Después de iniciar sesión, redirigir al panel. Después de cerrar sesión, redirigir al login o a la página pública de inicio.

## 5. Pantalla de inicio

Orden sugerido:

1. Navegación principal.
2. Hero con una propuesta de valor clara.
3. Presentación breve de SantaFeSL.
4. Producto destacado: Mercadito WA.
5. Resumen de servicios.
6. Proyectos destacados del laboratorio.
7. Llamada a contacto.
8. Pie de página.

No usar sliders. La página debe funcionar aunque no haya suficientes contenidos destacados.

## 6. Listados y detalles

### Productos

El listado muestra productos publicados, ordenados por `sort_order` y luego por fecha o nombre según la decisión de interfaz.

La ficha de detalle incluye nombre, descripción, estado del producto, imagen opcional y enlace externo opcional.

### Servicios

La página general presenta los servicios agrupados por categoría, si las categorías tienen valor para la lectura. Evitar filtros complejos si hay pocos servicios.

### Laboratorio

El listado muestra proyectos publicados con su estado, descripción breve y tecnologías. La página de detalle puede incluir repositorio y demo cuando existan.

## 7. Administración

Cada sección tendrá:

- Listado con paginación.
- Acción para crear.
- Formulario para crear/editar.
- Validación visible.
- Estado editorial.
- Acción de publicar/despublicar.
- Acción de borrar solo cuando corresponda.

No es necesario construir un dashboard complejo. El panel debe permitir encontrar y modificar contenido con pocos pasos.

## 8. Errores y estados vacíos

- Mostrar una página 404 para recursos inexistentes o no publicados.
- Mostrar un estado vacío útil cuando todavía no haya productos o proyectos.
- Mostrar errores de validación cerca de los campos.
- Mostrar confirmación tras guardar o publicar.
- No exponer excepciones técnicas en producción.

## 9. SEO y navegación

- Usar títulos y descripciones SEO opcionales por contenido.
- Incluir canonical URL cuando sea apropiado.
- Añadir sitemap XML y robots.txt cuando se implemente el sitio público.
- Usar enlaces internos descriptivos.
- Evitar exponer páginas administrativas a indexación.
- Mantener URLs estables.

## 10. Criterios de aceptación

- Todas las rutas públicas funcionan sin autenticación.
- Las rutas administrativas requieren sesión.
- Las páginas de detalle no muestran borradores.
- Los enlaces internos apuntan a rutas válidas.
- Las páginas responden correctamente en móvil y escritorio.
- Las páginas de error y los estados vacíos son comprensibles.
