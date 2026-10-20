# Manual de mantenimiento de SantaFeSL

Guías para instalar, cambiar y publicar el sitio **sin necesidad de entender todo Laravel**. Están escritas en español y con ejemplos para copiar.

| # | Guía | Para qué |
|---|---|---|
| 1 | [Instalación y desarrollo](01-instalacion.md) | Requisitos, instalar desde cero, `.env`, compilar, probar, iniciar el servidor |
| 2 | [Contenido](02-contenido.md) | Agregar o editar productos, servicios, textos y datos para buscadores (SEO) |
| 3 | [Imágenes](03-imagenes.md) | Reemplazar ilustraciones, texto alternativo, `public/storage` |
| 4 | [Contacto](04-contacto.md) | Cambiar correo y WhatsApp, comprobar enlaces, reemplazar datos de ejemplo |
| 5 | [Marca](05-marca.md) | Nombre, logo, favicon e imagen para compartir |
| 6 | [Actualizar](06-actualizar.md) | Flujo de cambios, recompilar, pruebas, armar un paquete, requisito de PHP |
| 7 | [Producción](07-produccion.md) | Variables, permisos, cachés, HTTPS, proxy y verificaciones al publicar |

## Antes de publicar por primera vez

- [ ] Reemplazar los datos de contacto de ejemplo ([Contacto](04-contacto.md), sección 6).
- [ ] Revisar el `.env` de producción: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` ([Producción](07-produccion.md), sección 2).
- [ ] Reescribir los textos alternativos que dicen "provisional" si se cambian las ilustraciones ([Imágenes](03-imagenes.md), sección 4).
- [ ] Reemplazar el favicon provisional cuando exista el definitivo ([Marca](05-marca.md), sección 3).
- [ ] Ejecutar `php artisan test` y `npm run build` sin errores.
- [ ] Repetir las verificaciones de [Producción](07-produccion.md), sección 8.

## Si algo falla

Mirá la tabla de problemas frecuentes de [Instalación](01-instalacion.md), sección 8. Si una prueba falla, el mensaje indica qué archivo y qué regla incumple.

Documentación de diseño, arquitectura y decisiones: [`docs/README.md`](../README.md).
