# Decisiones técnicas

> **Aviso de estado:** superado por `04-ESTANDARES-TECNICOS.md`. Supone base de datos y autenticación; v1 no las incluye.

## 1. Estado del documento

Este documento registra las decisiones recomendadas para la primera versión de SantaFeSL. Las versiones exactas de los runtimes y paquetes se fijarán al crear el repositorio, verificando compatibilidad y soporte vigente en ese momento.

## 2. Stack recomendado

| Área | Decisión |
|---|---|
| Backend | Laravel |
| Lenguaje | PHP |
| Renderizado | Blade del lado del servidor |
| Frontend | Bootstrap 5 |
| Build frontend | Vite |
| Iconos | Font Awesome |
| Tipografía | Inter |
| Base de datos | PostgreSQL o MySQL/MariaDB; elegir una antes de crear migraciones |
| Archivos | Laravel Filesystem / Storage |
| Pruebas backend | PHPUnit o Pest, según la configuración oficial elegida al crear el proyecto |
| Calidad de PHP | Laravel Pint |
| Contenedores | Docker Compose si forma parte del entorno de desarrollo y despliegue acordado |

No se utilizará un frontend separado con React, Vue o una SPA en la primera versión. Tampoco se incorporará una API pública.

## 3. Política de versiones

- Elegir una versión de Laravel con soporte vigente al iniciar la implementación.
- Usar una versión de PHP compatible con esa versión de Laravel y soportada por el entorno de producción.
- Fijar versiones de dependencias en los archivos de lock.
- No actualizar versiones mayores automáticamente en producción.
- Revisar compatibilidad antes de actualizar Laravel, PHP, Node o dependencias.
- Registrar en el README las versiones requeridas para desarrollo y despliegue.

No fijar versiones numéricas en esta documentación evita que el documento quede obsoleto antes de crear el proyecto. La elección exacta se registra en el repositorio cuando se genera la aplicación.

## 4. Base de datos

Usar una única base de datos relacional. Elegir PostgreSQL o MySQL/MariaDB en función de la infraestructura real y mantener la misma familia en desarrollo, pruebas y producción siempre que sea posible.

Criterios:

- Migraciones versionadas.
- Índices únicos para slugs.
- Fechas almacenadas de forma consistente.
- Integridad referencial cuando corresponda.
- Seeders solo para datos de desarrollo/demo; no usar seeders para sobrescribir contenido real de producción.
- Evitar SQL específico del motor cuando no aporte una ventaja concreta.

La elección definitiva del motor debe hacerse antes de implementar las migraciones.

## 5. Arquitectura de aplicación

- Seguir las convenciones de Laravel.
- Usar controladores pequeños.
- Validar entradas mediante Form Requests cuando aporte claridad.
- Usar Eloquent para el acceso habitual a datos.
- Aplicar middleware de autenticación a las rutas administrativas.
- Usar Policies o Gates si la autorización supera la comprobación simple de autenticación.
- Mantener la lógica de negocio en el lugar más sencillo y claro; no crear capas de servicios por defecto.
- Separar las consultas públicas de las consultas administrativas cuando sus requisitos sean distintos.
- Centralizar la regla que determina si un contenido está publicado.

No se introducirá arquitectura hexagonal, CQRS, repositorios genéricos ni un sistema de módulos propio sin una necesidad demostrable.

## 6. Frontend

- Blade para las vistas.
- Bootstrap 5 para grilla, componentes y utilidades.
- Vite para compilar los assets.
- Font Awesome para iconografía.
- Inter como tipografía.
- JavaScript limitado a interacciones que realmente lo necesiten.
- CSS personalizado solo cuando Bootstrap no cubra la necesidad; evitar estilos inline.
- No agregar dependencias para funcionalidades que puedan resolverse con herramientas ya presentes.

Las dependencias frontend deben instalarse y compilarse con el gestor y los scripts del proyecto, no mediante enlaces CDN improvisados.

## 7. Autenticación

Usar una solución compatible con la versión de Laravel elegida, priorizando el starter kit o mecanismo oficial que resulte más simple y apropiado para una aplicación Blade.

No implementar autenticación propia desde cero. Desactivar o no habilitar el registro público. El procedimiento para crear el administrador debe quedar documentado y no depender de credenciales conocidas o incrustadas en el código.

## 8. Archivos e imágenes

- Usar el filesystem de Laravel.
- Separar archivos públicos de archivos privados.
- No guardar binarios de imagen directamente en las tablas.
- Guardar la referencia del archivo y sus metadatos necesarios.
- Configurar almacenamiento persistente en producción.
- Definir límites de tamaño y formatos aceptados.
- Incluir los archivos necesarios en la estrategia de backup.

## 9. Entornos y configuración

- Separar desarrollo, pruebas y producción.
- Mantener `.env` fuera del control de versiones.
- Incluir `.env.example` sin secretos.
- Configurar secretos mediante el entorno de despliegue.
- No exponer debug en producción.
- Documentar comandos de instalación, pruebas, compilación y despliegue.
- No depender de configuraciones manuales no documentadas.

## 10. Docker

Si se usa Docker:

- Mantener el `Dockerfile` y `compose.yaml` versionados.
- No guardar datos persistentes dentro de la capa efímera del contenedor.
- Usar volúmenes para base de datos y archivos que deban persistir.
- Separar los secretos del archivo Compose versionado.
- Definir healthchecks cuando sean útiles.
- Documentar comandos habituales y procedimientos de recuperación.

No se deben añadir servicios de infraestructura que el proyecto no necesite.

## 11. Pruebas y calidad

La implementación debe incluir pruebas para:

- Acceso público a contenido publicado.
- Exclusión de borradores y publicaciones futuras.
- Autenticación y acceso administrativo.
- Validación de formularios.
- Unicidad de slugs.
- Publicación y despublicación.
- Carga y validación de imágenes.
- Errores esperados y páginas inexistentes.

Comandos que se documentarán según los scripts reales del proyecto:

```bash
php artisan test
vendor/bin/pint --test
npm run build
php artisan route:list
```

No afirmar que una prueba o comando se ejecutó si no se ejecutó. Si falla, registrar el error y el estado real.

## 12. Seguridad mínima

- HTTPS en producción.
- CSRF en formularios.
- Escape de salida en Blade.
- Validación en servidor.
- Consultas mediante Eloquent o parámetros seguros.
- Protección de rutas privadas.
- Secretos fuera del repositorio.
- Logs sin contraseñas, tokens ni datos innecesarios.
- Dependencias actualizadas con criterio.
- Backups y prueba periódica de restauración.

## 13. Decisiones pendientes antes de implementar

1. Elegir el motor de base de datos según el servidor disponible.
2. Confirmar si Docker se usará tanto en desarrollo como en producción.
3. Confirmar el destino de despliegue y el mecanismo de proxy/HTTPS.
4. Crear el proyecto con versiones compatibles y registrar las versiones exactas.
5. Decidir si el contacto será solo informativo o incluirá un formulario.

## 14. Regla general

Elegir la opción más sencilla que cubra los requisitos actuales, usando convenciones mantenidas por el ecosistema. Cada nueva dependencia o capa arquitectónica debe justificar su coste de instalación, aprendizaje, actualización y mantenimiento.
