# SantaFeSL — Arquitectura de contenido

> **Aviso de estado:** vigente como guía editorial. Los modelos de datos y campos (secciones 4 y 8) corresponden a la fase de base de datos; en v1 el contenido vive en `resources/content/*.php` (ver `02-ARQUITECTURA.md`). «Mercadito WA» como producto inicial está pendiente de confirmar (decisión D2 en `05-ROADMAP.md`).

## 1. Objetivo

Definir la estructura del contenido público y administrativo de SantaFeSL.

El contenido debe ser claro para pequeños negocios y particulares, y suficientemente técnico para mostrar experiencia a visitantes interesados.

## 2. Navegación pública

```text
Inicio
Productos
Servicios
Laboratorio
Sobre mí
Contacto
```

La navegación debe mantenerse corta.

## 3. Inicio

Orden recomendado:

1. Hero.
2. Productos destacados.
3. Servicios.
4. Laboratorio.
5. Presentación breve.
6. CTA de contacto.
7. Footer.

### Hero

Título:

> **Tecnología simple para problemas reales.**

Descripción:

> Software, servidores y tecnología para pequeños negocios y personas.

Acciones:

- Ver productos.
- Ver servicios.

### Productos destacados

Título:

> **Productos**

Texto:

> Herramientas que construimos para resolver necesidades concretas.

Producto inicial:

> **Mercadito WA — Punto de venta simple para pequeños comercios.**

### Servicios

Título:

> **Servicios**

Texto:

> Tecnología sin complicaciones.

Categorías iniciales:
- Servidores.
- Infraestructura.
- Desarrollo.

### Laboratorio

Título:

> **Laboratorio**

Texto:

> No todo lo que construimos termina siendo un producto. Algunas cosas nacen para aprender, experimentar o resolver un problema puntual.

### CTA

Título:

> **¿Necesitás algo?**

Texto:

> Contame qué necesitás y vemos si podemos resolverlo.

## 4. Productos

Ruta:

```text
/productos
/productos/{slug}
```

### Campos de Product

- `name`
- `slug`
- `short_description`
- `description`
- `status`
- `featured`
- `published_at`
- `sort_order`
- `seo_title`
- `seo_description`

Los campos exactos se validarán durante la implementación.

### Estado

Valores iniciales sugeridos:
- `development`
- `beta`
- `production`
- `paused`
- `archived`

No crear un enum hasta definir los estados definitivos durante arquitectura.

## 5. Producto individual

Orden sugerido:

1. Nombre.
2. Descripción corta.
3. Estado.
4. Imagen principal.
5. Problema.
6. Para quién es.
7. Características.
8. Capturas.
9. Información técnica opcional.
10. CTA.
11. Contacto.

## 6. Mercadito WA

Descripción inicial:

> **Punto de venta simple para pequeños comercios.**

La descripción funcional detallada debe basarse únicamente en las características reales del producto.

No inventar funcionalidades.

Las capturas deberán provenir de la aplicación real.

## 7. Servicios

Ruta:

```text
/servicios
```

Categorías iniciales:

### Servidores

Configuración y puesta en funcionamiento de servidores, VPS y aplicaciones.

Posibles áreas:
- Debian/Linux.
- Docker.
- Nginx.
- HTTPS.
- Backups.
- Deploy.

### Infraestructura

Posibles áreas:
- redes;
- monitoreo;
- diagnóstico;
- herramientas internas;
- servidores.

### Desarrollo

Posibles áreas:
- aplicaciones web;
- herramientas internas;
- automatización;
- integraciones.

La oferta debe mantenerse orientada a problemas concretos.

## 8. Laboratorio

Rutas:

```text
/laboratorio
/laboratorio/{slug}
```

### Campos de Project

- `name`
- `slug`
- `short_description`
- `description`
- `status`
- `technologies`
- `featured`
- `published_at`
- `sort_order`
- `seo_title`
- `seo_description`

### Estado

Inicialmente:
- Idea.
- En desarrollo.
- Experimental.
- Activo.
- Completado.
- Archivado.

## 9. Proyectos iniciales

### SincNetwork

Descripción:

> Sistema para administrar y monitorear infraestructura de red.

Debe documentarse con información real del proyecto.

### Netwatch

Descripción:

> Herramientas para detectar y analizar problemas de conectividad.

### Infraestructura

Puede utilizarse para documentar implementaciones de servidores, Docker, Nginx, backups, monitoreo y otros trabajos concretos.

## 10. Sobre mí

Contenido:
- presentación breve;
- intereses;
- experiencia práctica;
- Software Libre;
- tipo de proyectos;
- fotografía opcional.

Debe evitarse un CV extenso.

## 11. Contacto

Debe priorizar:
- WhatsApp;
- email;
- GitHub.

Formulario solo si existe una necesidad real.

## 12. SEO editorial

Cada contenido público debe tener:
- título;
- descripción;
- slug;
- Open Graph;
- contenido semántico.

Los títulos deben describir realmente el contenido.

No utilizar títulos pensados únicamente para SEO.

## 13. Reglas editoriales

1. No inventar funcionalidades.
2. No inventar clientes.
3. No inventar métricas.
4. No inventar resultados.
5. No exagerar capacidades.
6. Diferenciar claramente productos, servicios y experimentos.
7. Indicar estados reales.
8. Escribir para personas antes que para buscadores.
9. Usar lenguaje claro.
10. Mantener actualizado el estado de los proyectos.

## 14. Modelo de publicación

Un contenido puede existir en borrador antes de publicarse.

Se recomienda que:
- contenido incompleto permanezca privado;
- proyectos experimentales se marquen como tales;
- contenido archivado no desaparezca sin razón, salvo que deba retirarse.

## 15. Contenido futuro

Se podrán agregar:
- casos de estudio;
- artículos;
- documentación;
- tutoriales;
- preguntas frecuentes;
- testimonios.

No forman parte del alcance inicial.
