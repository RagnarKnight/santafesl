# Plan de implementación

> **Aviso de estado:** superado por `05-ROADMAP.md`. Este plan incluye base de datos y panel dentro de la primera versión.

## 1. Objetivo

Implementar SantaFeSL en entregas pequeñas, verificables y fáciles de revisar. Cada fase debe dejar el proyecto en un estado funcional y evitar mezclar demasiados cambios sin pruebas.

## 2. Principios

- Seguir convenciones oficiales de Laravel.
- Mantener Blade y Bootstrap 5 como base.
- No introducir una SPA ni una API pública en la primera versión.
- No agregar dependencias sin necesidad.
- Trabajar en cambios pequeños.
- Ejecutar pruebas pertinentes después de cada fase.
- Documentar los comandos realmente probados.
- No afirmar que un comando, test o despliegue se ejecutó si no se ejecutó.

## 3. Fases

### Fase 0 — Decisiones de entorno

Tareas:

- Confirmar motor de base de datos.
- Confirmar uso de Docker.
- Confirmar destino de producción.
- Elegir versiones compatibles de Laravel, PHP, Node y dependencias.
- Registrar versiones en README y archivos de lock.

Criterio de salida: una persona puede identificar qué necesita instalado y cómo iniciar el proyecto.

### Fase 1 — Esqueleto de Laravel

Tareas:

- Crear aplicación.
- Configurar entorno local.
- Configurar base de datos.
- Configurar Vite y Bootstrap 5.
- Incorporar Inter y Font Awesome mediante dependencias apropiadas.
- Crear layout base, navegación y pie de página.
- Crear páginas públicas provisionales.

Criterios de salida:

- La aplicación arranca localmente.
- Las rutas iniciales responden.
- `npm run build` funciona.
- La interfaz es responsive y no usa estilos inline.

### Fase 2 — Modelos y contenido público

Tareas:

- Crear migraciones y modelos para productos, servicios y proyectos.
- Definir estados y regla común de publicación.
- Crear seeders de desarrollo.
- Implementar listados y detalles públicos.
- Implementar estados vacíos y 404.

Criterios de salida:

- Los datos de demostración se muestran correctamente.
- Borradores y publicaciones futuras no aparecen en el sitio público.
- Los slugs son únicos.

### Fase 3 — Autenticación y panel

Tareas:

- Integrar autenticación compatible con Laravel.
- Deshabilitar registro público.
- Proteger las rutas administrativas.
- Crear layout de administración.
- Crear listados y formularios de cada tipo de contenido.

Criterios de salida:

- Un visitante no puede entrar al panel.
- El administrador puede iniciar sesión y administrar contenidos.
- Los errores de validación se muestran correctamente.

### Fase 4 — Imágenes y SEO

Tareas:

- Incorporar carga y reemplazo de imágenes.
- Validar formato y tamaño.
- Configurar almacenamiento.
- Incorporar metadatos SEO.
- Crear sitemap y robots.txt si corresponde.

Criterios de salida:

- Los archivos inválidos son rechazados.
- Las imágenes persisten tras reiniciar la aplicación.
- Los metadatos se renderizan de forma consistente.

### Fase 5 — Contenido inicial y revisión

Tareas:

- Redactar contenido final de inicio, productos, servicios y laboratorio.
- Incorporar Mercadito WA y los proyectos que estén listos para publicar.
- Revisar enlaces, títulos, metadatos y estados.
- Revisar accesibilidad, responsive y rendimiento básico.

Criterios de salida:

- No hay contenido de ejemplo accidental en producción.
- Los enlaces públicos funcionan.
- Las páginas tienen contenido claro y realista.

### Fase 6 — Pruebas y seguridad

Tareas:

- Ejecutar pruebas automatizadas.
- Ejecutar Laravel Pint.
- Compilar assets de producción.
- Revisar permisos, validación, CSRF, escape de salida y exposición de errores.
- Revisar dependencias.
- Documentar resultados y pendientes.

Criterios de salida:

- Las pruebas definidas pasan, o los fallos conocidos quedan registrados.
- El build se completa correctamente.
- No quedan secretos versionados.

### Fase 7 — Despliegue

Tareas:

- Configurar variables de entorno.
- Preparar base de datos y almacenamiento persistente.
- Configurar HTTPS y servidor web.
- Ejecutar migraciones de forma controlada.
- Configurar cachés de producción.
- Verificar logs, backups y recuperación.
- Realizar una prueba de humo después del despliegue.

Criterios de salida:

- El sitio responde por HTTPS.
- El panel está protegido.
- Se puede restaurar la base de datos y los archivos siguiendo un procedimiento documentado.
- Hay un procedimiento de actualización y rollback.

## 4. Lista de verificación por entrega

Antes de cerrar una fase:

- [ ] El alcance de la fase está completo.
- [ ] No se agregaron dependencias sin justificar.
- [ ] Se ejecutaron las pruebas aplicables.
- [ ] Se ejecutó el build frontend cuando corresponde.
- [ ] Se revisaron rutas y errores.
- [ ] Se actualizó la documentación.
- [ ] Se documentaron comandos ejecutados y resultados reales.
- [ ] Se enumeraron pendientes y decisiones abiertas.

## 5. Instrucciones para agentes de código

Si se trabaja con Claude u otro agente:

1. Leer primero los documentos de `docs/`.
2. Respetar el alcance de la fase actual.
3. Inspeccionar el repositorio antes de modificarlo.
4. No reescribir archivos ajenos al alcance sin explicar por qué.
5. No añadir dependencias sin justificar el beneficio.
6. Implementar pruebas para la lógica nueva.
7. Ejecutar solo comandos apropiados para el entorno disponible.
8. Informar los archivos modificados, pruebas ejecutadas, resultados y pendientes.
9. No afirmar que se verificó algo que no se ejecutó.
10. Detenerse y preguntar si una decisión pendiente cambia sustancialmente la arquitectura.

## 6. Primer entregable de código

El primer entregable debería ser un esqueleto funcional, no el sitio completo:

- Aplicación Laravel creada.
- Entorno documentado.
- Bootstrap 5 compilado con Vite.
- Layout base.
- Navegación responsive.
- Rutas y vistas públicas vacías o con contenido inicial.
- Pruebas básicas de rutas.
- README con instrucciones verificadas.

No incorporar el panel completo antes de confirmar que el entorno y la base visual funcionan.
