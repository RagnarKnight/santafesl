# Panel de administración

> **Aviso de estado:** referencia para la fase 6 (panel). **No aplica a la v1.** Ver `05-ROADMAP.md`.

## 1. Objetivo

Proporcionar una interfaz privada, clara y suficiente para mantener el contenido de SantaFeSL. El panel no será un CMS genérico: administrará únicamente los productos, servicios y proyectos definidos para el sitio.

## 2. Acceso y seguridad

- No habrá registro público.
- Se creará un usuario administrador mediante un mecanismo controlado de instalación o seeder local.
- Las rutas administrativas estarán protegidas por autenticación.
- No se dejarán credenciales predeterminadas en producción.
- El acceso de administración usará HTTPS en producción.
- Las operaciones de escritura validarán datos en el servidor.
- Se aplicarán CSRF, escape de salida y controles de autorización de Laravel.
- Los mensajes de error no revelarán información sensible.
- Se recomienda limitar intentos de inicio de sesión.

La primera versión tendrá un único tipo de usuario administrador. No se implementarán roles configurables hasta que exista una necesidad real.

## 3. Navegación propuesta

```text
/admin
├── Productos
│   ├── Listado
│   ├── Crear
│   └── Editar
├── Servicios
│   ├── Listado
│   ├── Crear
│   └── Editar
└── Proyectos
    ├── Listado
    ├── Crear
    └── Editar
```

El inicio del panel mostrará accesos rápidos y un resumen simple, por ejemplo, cantidad de productos, servicios y proyectos. No necesita gráficos ni analítica avanzada.

## 4. Listados

Cada listado deberá ofrecer:

- Nombre.
- Estado o situación editorial.
- Fecha de publicación.
- Indicador de destacado, cuando corresponda.
- Acciones para editar y previsualizar, si se implementa una previsualización segura.
- Paginación.
- Orden consistente.

Búsqueda y filtros avanzados pueden añadirse si el volumen de contenido lo justifica. Para el volumen inicial, una búsqueda por nombre y un filtro por estado son suficientes.

Las acciones de borrar deben pedir confirmación cuando exista riesgo de pérdida de contenido. Si una eliminación puede romper referencias o enlaces, preferir despublicar o archivar.

## 5. Formularios

### Producto

- Nombre.
- Slug.
- Descripción breve.
- Descripción completa.
- Estado del producto.
- Imagen principal.
- URL externa opcional.
- Destacado.
- Fecha de publicación.
- Título SEO.
- Descripción SEO.

### Servicio

- Nombre.
- Slug.
- Descripción breve.
- Descripción completa.
- Categoría.
- Destacado, si se usa en la página de inicio.
- Fecha de publicación.
- Título SEO.
- Descripción SEO.

### Proyecto

- Nombre.
- Slug.
- Descripción breve.
- Descripción completa.
- Estado del proyecto.
- Tecnologías.
- URL del repositorio.
- URL de demostración.
- Imagen principal.
- Destacado.
- Fecha de publicación.
- Título SEO.
- Descripción SEO.

Los campos obligatorios deben estar claramente indicados. Los errores de validación aparecerán junto al campo correspondiente y conservarán los datos no sensibles ya ingresados.

## 6. Borradores, publicación y archivo

- Sin fecha de publicación: borrador.
- Fecha futura: publicación programada.
- Fecha actual o pasada: publicado.
- Para retirar contenido del sitio, limpiar la fecha de publicación.
- El estado operativo (por ejemplo, `development` o `production`) se mantiene separado de la visibilidad pública.

La interfaz debe explicar estas reglas con etiquetas claras; no debe obligar al administrador a conocer detalles internos de la base de datos.

## 7. Imágenes

- Mostrar una previsualización cuando haya imagen.
- Permitir reemplazar o quitar la imagen.
- Validar formato y tamaño.
- Guardar usando Storage de Laravel.
- No confiar en el nombre original ni en la extensión declarada por el navegador.
- No aceptar SVG subidos por administradores en la primera versión, salvo que exista un proceso de sanitización específico.

Formatos iniciales sugeridos: JPEG, PNG y WebP. El límite de tamaño debe ser configurable y documentado.

## 8. Interfaz y experiencia

- Bootstrap 5, Blade y los componentes compartidos del proyecto.
- Diseño responsive.
- Etiquetas y controles accesibles.
- Confirmaciones claras para acciones destructivas.
- No usar JavaScript para reemplazar validaciones esenciales del servidor.
- No introducir un framework frontend separado.
- Mantener la administración visualmente consistente con la identidad, pero priorizar la legibilidad y la eficiencia.

## 9. Pruebas mínimas

- Un visitante no autenticado no puede acceder a rutas privadas.
- El administrador autenticado puede acceder al panel.
- Los formularios validan los campos requeridos.
- No se pueden crear slugs duplicados del mismo tipo.
- Los borradores no aparecen en el sitio público.
- Los archivos inválidos son rechazados.
- La publicación y despublicación cambian la visibilidad según las reglas.
- Las operaciones inválidas no modifican datos persistidos.

## 10. Fuera de alcance

- Gestión de múltiples administradores.
- Roles y permisos personalizables.
- Auditoría avanzada.
- Edición colaborativa.
- Flujos de aprobación.
- Constructor de páginas.
- Dashboard analítico.
