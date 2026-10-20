# SantaFeSL — Reglas de desarrollo

## 1. Objetivo

Definir las reglas de trabajo para mantener el proyecto simple, consistente, verificable y mantenible.

## 2. Principios

### No sobreingeniería

No crear:
- interfaces sin necesidad;
- repositorios para todo;
- servicios vacíos;
- patrones complejos;
- capas duplicadas.

Una abstracción debe resolver un problema real.

### Convenciones primero

Preferir las convenciones de Laravel antes que inventar estructuras propias.

### Código legible

Nombres claros y métodos pequeños.

### Cambios pequeños

Cada tarea debe intentar resolver una necesidad concreta.

## 3. Backend

Utilizar:
- Eloquent;
- Form Requests;
- Policies;
- Migrations;
- Seeders;
- Commands cuando correspondan;
- Jobs solo cuando exista trabajo realmente asíncrono.

## 4. Controllers

Los controllers deben coordinar la petición.

Evitar colocar lógica de negocio extensa directamente en los controllers.

Pero tampoco extraer cada línea a una clase separada sin necesidad.

## 5. Models

Los modelos deben representar correctamente los datos y relaciones.

Evitar convertir los modelos en contenedores gigantes de lógica no relacionada.

## 6. Views

Blade debe concentrarse en presentación.

No colocar lógica de negocio en las vistas.

Reutilizar componentes Blade cuando exista repetición real.

## 7. Frontend

Utilizar:
- Bootstrap 5;
- Vite;
- Font Awesome;
- Inter.

No introducir frameworks adicionales sin justificación.

## 8. CSS

Reglas:
- no inline styles;
- no estilos en atributos HTML;
- no valores de color repetidos manualmente;
- no duplicar reglas;
- centralizar variables y personalizaciones.

## 9. JavaScript

JavaScript solo cuando sea necesario.

No agregar dependencias para:
- animaciones triviales;
- menús que Bootstrap resuelve;
- componentes que puedan resolverse con HTML/CSS;
- funcionalidades inexistentes.

## 10. Dependencias

Antes de agregar una dependencia:
1. comprobar si Laravel ya resuelve el problema;
2. comprobar si Bootstrap o el navegador lo resuelven;
3. evaluar mantenimiento;
4. evaluar tamaño;
5. evaluar seguridad;
6. justificar la dependencia.

## 11. Base de datos

Toda modificación estructural debe tener migration.

Los nombres deben seguir las convenciones de Laravel.

## 12. Validación

Validar:
- entrada del usuario;
- tipos;
- formatos;
- relaciones;
- reglas de negocio cuando corresponda.

Nunca confiar únicamente en validaciones del navegador.

## 13. Seguridad

Considerar:
- autenticación;
- autorización;
- CSRF;
- validación;
- escape de salida;
- subida segura de archivos;
- protección de secretos;
- configuración de producción.

Nunca almacenar secretos en el repositorio.

## 14. Testing

Antes de considerar una funcionalidad terminada se debe ejecutar la batería de pruebas disponible.

Cuando una prueba no pueda ejecutarse por una limitación del entorno, se debe documentar claramente.

Nunca inventar resultados.

## 15. Calidad

Cuando las herramientas estén disponibles, comprobar:

```text
php artisan test
vendor/bin/pint
npm run build
php artisan route:list
```

> La v1 **no usa base de datos**: no se ejecutan `migrate` ni seeders (la línea `php artisan migrate:fresh --seed` de versiones anteriores de este documento se retiró). Los comandos vigentes están en [`manual/01-instalacion.md`](manual/01-instalacion.md).

Los comandos exactos pueden variar según el proyecto.

## 16. Documentación

Las decisiones importantes deben reflejarse en `docs/`.

No documentar funcionalidades inexistentes como si fueran definitivas.

## 17. Git

Los commits deben ser:
- pequeños;
- descriptivos;
- relacionados con una tarea.

Evitar commits que mezclen cambios no relacionados.

## 18. Definición de terminado

Una tarea está terminada cuando:
- funciona;
- está integrada;
- tiene validación apropiada;
- tiene tests cuando corresponda;
- respeta el diseño;
- es responsive si afecta frontend;
- está documentada cuando corresponde;
- las comprobaciones disponibles fueron ejecutadas.

## 19. Regla de honestidad técnica

> **Lo que no fue ejecutado no se presenta como ejecutado.**

Esto aplica a:
- tests;
- builds;
- migrations;
- deploys;
- backups;
- comandos;
- verificaciones;
- benchmarks.

## 20. Principio

> **Código simple que podamos entender dentro de un año.**
