# SantaFeSL — Arquitectura de aplicación

> **Aviso de estado:** superado por `02-ARQUITECTURA.md`. Este plan supone base de datos, panel y autenticación desde la primera versión, lo cual queda fuera de v1.

## 1. Objetivo

Definir una arquitectura Laravel sencilla, convencional y mantenible para la primera versión de SantaFeSL.

## 2. Stack

La versión inicial utilizará:

- Laravel.
- PHP.
- Blade.
- Bootstrap 5.
- Vite.
- Font Awesome.
- Inter.
- Base de datos relacional.
- Docker.

Las versiones concretas se definirán al crear el proyecto.

## 3. Arquitectura general

```text
Navegador
   │
   ▼
Web / Nginx
   │
   ▼
Laravel
   │
   ├── Controllers
   ├── Requests
   ├── Models
   ├── Policies
   ├── Views
   └── Services cuando exista una necesidad real
            │
            ▼
        Base de datos
```

No introducir capas adicionales únicamente por seguir una moda arquitectónica.

## 4. Frontend

Se utilizará:
- Blade;
- Bootstrap 5;
- Vite;
- Font Awesome.

JavaScript solo cuando exista una necesidad real.

No introducir React, Vue, Livewire, Alpine u otros frameworks sin un caso de uso concreto.

## 5. Modelos principales

### Product

Producto de software propio.

### Service

Servicio ofrecido.

### Project

Proyecto del Laboratorio.

Las relaciones exactas se definirán después de revisar los requisitos reales.

## 6. Contenido

Los modelos tendrán:
- nombre;
- slug cuando sean públicos;
- descripción corta;
- descripción;
- estado cuando corresponda;
- publicación;
- destacado cuando corresponda.

No crear campos por anticipación si todavía no existe una necesidad.

## 7. Slugs

Las URLs públicas utilizarán slugs legibles.

Ejemplo:

```text
/productos/mercadito-wa
/laboratorio/sincnetwork
```

No utilizar IDs como URL pública principal.

## 8. Publicación

Los contenidos públicos deben distinguir entre:
- borrador;
- publicado;
- archivado cuando corresponda.

El contenido no publicado no debe ser accesible mediante rutas públicas normales.

## 9. Administración

Existirá una zona privada para gestionar:
- productos;
- servicios;
- proyectos.

La autenticación y autorización deben implementarse siguiendo las capacidades y convenciones de Laravel.

No se implementará un sistema de usuarios públicos.

## 10. Validación

La validación compleja debe realizarse mediante Form Requests cuando corresponda.

La validación simple puede permanecer en el contexto adecuado sin crear abstracciones innecesarias.

## 11. Autorización

Las acciones administrativas deben estar protegidas.

Utilizar Policies o Gates cuando correspondan.

No confiar únicamente en ocultar botones en la interfaz.

## 12. Imágenes

Las imágenes de productos y proyectos deben gestionarse mediante storage.

Debe evitarse guardar archivos subidos directamente como parte del código fuente.

Las imágenes públicas deben servirse de forma segura y optimizada.

## 13. SEO

La arquitectura debe permitir:
- title;
- meta description;
- canonical;
- Open Graph.

No duplicar lógica SEO innecesariamente.

## 14. Rutas

Las rutas públicas deben ser legibles y agrupadas por recurso.

Ejemplo conceptual:

```text
GET /productos
GET /productos/{product:slug}

GET /servicios

GET /laboratorio
GET /laboratorio/{project:slug}

GET /sobre-mi
GET /contacto
```

Las rutas administrativas deberán estar separadas y protegidas.

## 15. Base de datos

Usar migrations como fuente de verdad.

No modificar manualmente el esquema como práctica normal.

Seeders únicamente para datos necesarios de desarrollo, pruebas o datos iniciales deliberadamente definidos.

## 16. Tests

La primera versión debe cubrir al menos:
- páginas públicas principales;
- acceso a contenidos publicados;
- exclusión de contenidos no publicados;
- autenticación administrativa;
- operaciones CRUD principales;
- validaciones relevantes.

La cobertura exacta se definirá según el código real.

## 17. API

No se implementará una API pública inicialmente.

Si posteriormente aparece una necesidad real, se diseñará como una extensión independiente.

## 18. Caché

No implementar una estrategia de caché compleja desde el comienzo.

Evaluar caché cuando:
- el contenido lo justifique;
- aparezca una necesidad de rendimiento;
- existan métricas que demuestren el problema.

## 19. Logs

Los errores de aplicación y eventos relevantes deben utilizar el sistema de logging de Laravel.

No almacenar información sensible innecesariamente.

## 20. Principio arquitectónico

> **La arquitectura debe ser tan simple como sea posible y tan estructurada como sea necesario.**
