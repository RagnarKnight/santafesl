# SantaFeSL — Producción

> **Aviso de estado:** parcialmente superado por `04-ESTANDARES-TECNICOS.md` §10. Las secciones sobre base de datos y panel aplican solo a las fases 5–6; v1 no tiene base de datos.

## 1. Objetivo

Definir las bases para desplegar SantaFeSL de forma segura y mantenible.

La configuración final dependerá del proveedor y del entorno elegido.

## 2. Arquitectura conceptual

```text
Internet
   │
   ▼
DNS
   │
   ▼
Nginx / Reverse Proxy
   │
   ▼
Aplicación Laravel
   │
   ├── PHP-FPM
   ├── Database
   └── Storage
```

La implementación podrá utilizar Docker si resulta conveniente.

## 3. Dominio

Dominio principal:

```text
santafesl.com
```

Debe configurarse HTTPS.

HTTP debe redirigir a HTTPS.

## 4. Entorno

Debe existir separación entre:
- desarrollo;
- producción.

Nunca utilizar credenciales de producción en desarrollo.

## 5. Variables de entorno

Los secretos deben permanecer fuera del repositorio.

Ejemplos:
- credenciales de base de datos;
- claves;
- tokens;
- credenciales SMTP;
- secretos de aplicación.

## 6. Base de datos

Producción debe utilizar una base de datos persistente.

Las migraciones deben ejecutarse de manera controlada.

Nunca ejecutar comandos destructivos como `migrate:fresh` en producción.

## 7. Backups

Antes de considerar producción como completa deben definirse:
- backup de base de datos;
- backup de archivos importantes;
- retención;
- ubicación;
- restauración;
- verificación.

Un backup que nunca fue restaurado o verificado no debe considerarse completamente confiable.

## 8. Storage

Los archivos persistentes deben almacenarse en un volumen o mecanismo adecuado.

No depender del filesystem efímero de un contenedor.

## 9. HTTPS

Debe utilizarse TLS válido.

La renovación debe ser automática o documentada.

## 10. Deploy

El proceso de deploy debe ser reproducible.

Como mínimo debe contemplar:
1. obtener código;
2. instalar dependencias;
3. construir assets;
4. configurar entorno;
5. ejecutar migraciones de forma segura;
6. limpiar cachés cuando corresponda;
7. verificar aplicación.

## 11. Health check

Debe existir una forma sencilla de comprobar que la aplicación está funcionando.

Inicialmente puede consistir en:
- respuesta HTTP;
- página pública;
- conexión a base de datos cuando sea necesario.

No implementar un sistema de monitoreo complejo hasta necesitarlo.

## 12. Logs

Los logs de aplicación y servidor deben poder consultarse.

Debe evitarse registrar:
- contraseñas;
- tokens;
- secretos;
- información sensible innecesaria.

## 13. Seguridad

Producción debe contemplar:
- HTTPS;
- firewall;
- actualizaciones;
- secretos protegidos;
- permisos correctos;
- protección del panel administrativo;
- backups;
- logs.

## 14. Actualizaciones

Las actualizaciones deben probarse antes de producción cuando sea razonable.

No actualizar dependencias críticas a ciegas.

## 15. Rollback

Debe existir una estrategia razonable para volver a una versión anterior.

La estrategia exacta dependerá del método de despliegue.

## 16. Rendimiento

Inicialmente se priorizará:
- caché de configuración;
- assets compilados;
- imágenes optimizadas;
- PHP configurado correctamente;
- base de datos indexada donde corresponda;
- Nginx correctamente configurado.

No optimizar prematuramente.

## 17. Monitoreo

El monitoreo inicial debe ser sencillo.

Se podrá incorporar posteriormente:
- uptime;
- errores;
- uso de recursos;
- certificados;
- backups.

## 18. Checklist inicial de producción

```text
[ ] Dominio configurado
[ ] DNS correcto
[ ] HTTPS funcionando
[ ] Aplicación desplegada
[ ] Base de datos configurada
[ ] Migraciones ejecutadas
[ ] Storage persistente
[ ] Backups configurados
[ ] Restauración verificada
[ ] Logs disponibles
[ ] Panel administrativo protegido
[ ] Variables de entorno protegidas
[ ] Health check verificado
[ ] Assets compilados
[ ] Tests ejecutados
[ ] Deploy documentado
```

## 19. Principio

> **Producción debe ser aburrida, reproducible y recuperable.**

La infraestructura no debe depender de pasos manuales desconocidos.

## 20. Evolución

A medida que SantaFeSL tenga tráfico o necesidades reales podrán incorporarse:
- CDN;
- monitoreo avanzado;
- alertas;
- despliegues automatizados;
- servidores adicionales;
- almacenamiento externo;
- observabilidad.

No forman parte de la primera versión.
