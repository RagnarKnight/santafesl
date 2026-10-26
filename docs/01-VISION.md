# SantaFeSL — Visión del proyecto

> **Estado:** vigente · actualizado en la fase de arquitectura (v1 pública, sin base de datos ni panel).
> Este documento reemplaza al anterior `01-vision.md` (mismo archivo, renombrado a mayúsculas para seguir la numeración de `docs/README.md`). Las decisiones que cambiaron se listan en la sección 14.

## 1. Propósito

SantaFeSL será la presencia web oficial de la marca. El sitio presenta:

- los **productos de software** propios;
- los **servicios profesionales**;
- la forma de **contactar**.

No será inicialmente un portal complejo ni un CMS.

> **Mostrar qué construimos, qué sabemos hacer y cómo podemos ayudar.**

## 2. Concepto y propuesta de valor

> **Tecnología simple para problemas reales.**

Entender una necesidad y encontrar una solución tecnológica razonable, simple y mantenible. La identidad, el tono y el lenguaje están en [`00-brand.md`](00-brand.md) y no se repiten aquí.

## 3. Público

- **Principal:** kioscos, almacenes, pequeños comercios, emprendedores, profesionales independientes, **iglesias y pequeñas organizaciones** (por el CHMS).
- **Secundario:** otros desarrolladores, administradores de sistemas, personas interesadas en Software Libre.

El visitante no necesita conocimientos técnicos para entender la propuesta.

## 4. Productos del sitio (versión 1)

| Producto | Descripción mínima aprobada | Estado del contenido |
|---|---|---|
| CHMS para iglesias | Sistema de gestión para iglesias | **Por definir** (nombre comercial, funciones reales, estado) |
| Sistema POS | Punto de venta | **Por definir** |
| Catálogo web | Catálogo web | Ahora **Pediwa** (resuelto: era el mismo servicio) |

Regla: **no se publica ninguna función, cliente, métrica o precio que el autor no haya confirmado.** Hasta entonces el contenido se escribe con marcas `[POR DEFINIR]` y no se publica.

## 5. Pilares

- **Productos** — software propio para necesidades concretas. *(v1)*
- **Servicios** — trabajo tecnológico para terceros: servidores, infraestructura, desarrollo. *(v1)*
- **Laboratorio** — proyectos y experimentos. *(propuesto por la marca; **no se publica en la v1** por decisión del autor al cierre; los datos se conservan para el futuro)*

## 6. Objetivos de la primera versión

1. Presentar claramente SantaFeSL.
2. Mostrar los productos, cada uno con página propia.
3. Mostrar los servicios.
4. Permitir el contacto por canales simples.
5. Ser rápida, responsive y accesible.
6. Tener SEO básico correcto.
7. Ser fácil de mantener por una sola persona.
8. **Funcionar sin base de datos, sin autenticación y sin panel.**

## 7. Alcance de la versión 1

```text
/                       Inicio
/productos              Listado de productos
/productos/{slug}       Ficha de producto
/servicios              Servicios
/contacto               Contacto
/sitemap.xml            Generado
/robots.txt             Estático
/up                     Health check de Laravel (ya existe)
```

`/sobre-mi` se publica; `/laboratorio` **no se publica** en la v1 (decisión D3 al cierre). El detalle de rutas está en [`02-ARQUITECTURA.md`](02-ARQUITECTURA.md).

## 8. Inicio

```text
Hero → Productos → Servicios → Llamado a contacto → Footer
```

El hero responde tres preguntas: qué es SantaFeSL, qué hace y qué acción puede realizar el visitante. Sin sliders ni hero de pantalla completa.

## 9. Contacto

Canales simples y verificables: WhatsApp, correo, GitHub. **Sin formulario en v1** (un formulario exige correo saliente, antispam y tratamiento de datos personales; ver D4). Los datos reales de contacto no están definidos todavía.

## 10. Calidad esperada

- **Responsive:** móvil, tablet, notebook y escritorio; diseño mobile-first.
- **Accesibilidad:** WCAG 2.2 nivel AA como objetivo (detalle en `03-DISENO-UI-UX.md`).
- **Rendimiento:** HTML simple, CSS compilado y limitado, JavaScript mínimo, fuentes propias, imágenes optimizadas.
- **Seguridad:** buenas prácticas básicas, sin superficie de ataque innecesaria (sin formularios, sin login, sin base de datos).

## 11. Principios de desarrollo

Simple · Convencional · Mantenible · Documentado · Verificable · Honesto.

> **Lo que no fue ejecutado no se presenta como ejecutado.**

## 12. Fuera del alcance de la versión 1

Base de datos, autenticación, panel administrativo, API, formularios con envío de correo, blog, comentarios, newsletter, usuarios públicos, pagos, multiidioma, analítica compleja, modo oscuro, aplicación móvil.

## 13. Evolución

La v1 está diseñada para evolucionar **sin reescribir las vistas**:

1. Contenido en archivos PHP (v1).
2. Base de datos + modelos Eloquent con los mismos atributos.
3. Panel administrativo para productos, servicios y publicaciones.

El camino está descrito en `02-ARQUITECTURA.md` §7 y en `05-ROADMAP.md`.

## 14. Cambios respecto de la versión anterior

| Antes | Ahora | Motivo |
|---|---|---|
| Primer producto destacado: Mercadito WA | Tres productos: CHMS, POS y Pediwa | Indicación del autor |
| Zona privada de administración en el alcance | Fuera de v1; fase posterior | Indicación del autor |
| Base de datos relacional prevista | Sin base de datos hasta que exista necesidad real | Indicación del autor |
| Font Awesome y «Google Fonts / Inter» | Inter alojada localmente; iconos sin librería (propuesta, D5) | Sin CDN y dependencias mínimas |
| Docker «cuando corresponda» | Despliegue con o sin Docker | Indicación del autor |

## 15. Criterio de éxito

Un visitante nuevo responde rápidamente: ¿qué es SantaFeSL?, ¿qué productos tiene?, ¿qué servicios ofrece?, ¿cómo lo contacto?
