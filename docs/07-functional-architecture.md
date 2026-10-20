# Arquitectura funcional

> **Aviso de estado:** referencia para las fases 5–6 (base de datos y panel). **No aplica a la v1**, que no tiene administración ni persistencia. Ver `05-ROADMAP.md`.

## 1. Objetivo

Definir el comportamiento funcional de SantaFeSL para implementar una primera versión útil, mantenible y pequeña, sin convertir el sitio en un CMS genérico.

SantaFeSL tendrá dos áreas:

- **Sitio público:** presenta la marca, productos, servicios y proyectos.
- **Administración privada:** permite mantener esos contenidos sin editar código.

## 2. Alcance de la primera versión

Incluye:

- Página de inicio.
- Listados y páginas de detalle de productos.
- Página de servicios.
- Listado y páginas de detalle del laboratorio.
- Página «Sobre mí».
- Página de contacto.
- Acceso privado para administración.
- ABM/CRUD de productos, servicios y proyectos.
- Publicación, despublicación y selección de contenido destacado.
- Imágenes principales para productos y proyectos.
- Metadatos SEO básicos.
- Validación de formularios y protección de las rutas privadas.

Queda fuera del alcance inicial:

- Registro público de usuarios.
- Múltiples organizaciones o tenants.
- Roles y permisos configurables.
- API pública.
- Editor visual de páginas.
- Comentarios, reseñas o comunidad.
- Carrito de compras, cobros o facturación.
- Estadísticas avanzadas.
- Internacionalización.
- Sistema complejo de categorías y etiquetas.

## 3. Conceptos principales

### Producto

Representa una aplicación o herramienta de software que SantaFeSL ofrece, desarrolla o mantiene. Ejemplo inicial: **Mercadito WA**.

Campos funcionales:

- Nombre y slug.
- Descripción breve y descripción completa.
- Estado del producto.
- Imagen principal opcional.
- URL externa opcional.
- Indicador de destacado.
- Orden manual.
- Metadatos SEO.
- Fecha de publicación.

Los estados del ciclo de vida del producto serán:

- `development`: en desarrollo.
- `beta`: versión de prueba.
- `production`: disponible/estable.
- `paused`: pausado.
- `archived`: archivado.

El estado del ciclo de vida no determina por sí mismo si la ficha es pública. La publicación se gestiona por separado mediante `published_at` y las reglas de visibilidad.

### Servicio

Representa una prestación que SantaFeSL puede ofrecer, como configuración de servidores, Docker, Nginx, HTTPS, copias de seguridad, redes, automatización o desarrollo.

Campos funcionales:

- Nombre y slug.
- Descripción breve y descripción completa.
- Categoría textual inicial.
- Indicador de publicación.
- Indicador de destacado opcional.
- Orden manual.
- Metadatos SEO.
- Fecha de publicación.

No se incorporarán precios, pagos, contratación en línea ni disponibilidad automática en esta versión.

### Proyecto

Representa un proyecto del laboratorio, una herramienta propia, un experimento o una iniciativa técnica.

Campos funcionales:

- Nombre y slug.
- Descripción breve y descripción completa.
- Estado del proyecto.
- Tecnologías como lista simple.
- URL del repositorio opcional.
- URL de demostración opcional.
- Imagen principal opcional.
- Indicador de destacado.
- Orden manual.
- Metadatos SEO.
- Fecha de publicación.

Estados del proyecto:

- `idea`: idea.
- `in_development`: en desarrollo.
- `experimental`: experimental.
- `active`: activo.
- `completed`: completado.
- `archived`: archivado.

## 4. Publicación y visibilidad

La publicación será independiente del estado de ciclo de vida.

Reglas:

1. Un elemento solo es visible públicamente si tiene fecha de publicación y esa fecha no está en el futuro.
2. Los elementos sin `published_at` son borradores y solo aparecen en administración.
3. Una fecha futura permite programar una publicación sin incorporar un sistema de workflow complejo.
4. El contenido archivado puede seguir publicado si el administrador lo decide; si no debe mostrarse, se despublica.
5. Los listados públicos solo consultan contenido publicado.
6. Las rutas de administración nunca deben usar consultas públicas filtradas de forma que impidan editar borradores.

Para la primera versión no se necesita una columna `is_published` adicional: `published_at` puede representar borrador, publicación programada y publicación efectiva. Debe centralizarse la regla de visibilidad para evitar filtros inconsistentes.

## 5. Contenido destacado

Los productos y proyectos pueden marcarse como destacados. Los servicios también pueden tener esta opción si la implementación confirma que mejora la página de inicio.

Los elementos destacados:

- Deben estar publicados.
- Respetan un orden manual.
- No generan una ruta ni un tipo de contenido separado.
- No deben duplicarse innecesariamente en consultas.

La página de inicio mostrará una selección limitada, no un catálogo completo.

## 6. Imágenes y enlaces externos

- La imagen principal es opcional.
- Se validarán tipo MIME y tamaño máximo.
- Los archivos se almacenarán mediante el sistema de Storage de Laravel.
- No se aceptarán rutas de archivo arbitrarias suministradas por el usuario.
- Los enlaces externos se validarán como URL.
- La eliminación o sustitución de una imagen debe limpiar el archivo anterior solo cuando no siga siendo utilizado.
- No se permitirá HTML arbitrario en las descripciones.

Para la primera versión, las descripciones se tratarán como texto y se renderizarán de forma segura. Si luego se requiere formato enriquecido, se evaluará un editor y una estrategia de sanitización por separado.

## 7. Contacto

La página de contacto podrá mostrar un correo o enlace de contacto configurable. No se necesita almacenar mensajes en la base de datos ni enviar correos desde un formulario en la primera entrega, salvo que se decida expresamente.

Si se incorpora un formulario más adelante, deberá contemplar validación, limitación de frecuencia, protección contra spam y tratamiento responsable de datos personales.

## 8. Reglas de negocio

- Los slugs deben ser únicos dentro de su tipo de contenido.
- Un slug publicado no debe cambiar accidentalmente al editar el título.
- Si se cambia un slug publicado, debe decidirse cómo preservar enlaces anteriores; inicialmente, evitar cambios de slug después de publicar.
- No se permite acceder a borradores desde rutas públicas.
- La administración exige autenticación.
- Las operaciones de escritura usan validación del servidor y protección CSRF.
- Los errores no deben exponer secretos, trazas o datos internos en producción.

## 9. Criterios de aceptación

- El visitante puede navegar por el contenido publicado sin iniciar sesión.
- El visitante no puede acceder a borradores ni a pantallas de administración.
- El administrador puede crear, editar, publicar, despublicar y archivar contenidos.
- Los slugs son únicos y generan URLs estables.
- Las imágenes y los enlaces externos se validan.
- Los listados públicos no muestran contenido futuro o no publicado.
- El sitio sigue siendo usable en móvil y escritorio.
