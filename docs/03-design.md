# SantaFeSL — Diseño y sistema visual

## 1. Objetivo

Definir las reglas visuales y de interfaz para que SantaFeSL mantenga una apariencia consistente.

## 2. Principios

- Simple.
- Limpio.
- Profesional.
- Cercano.
- Responsive.
- Accesible.
- Rápido.
- Sin decoración innecesaria.

## 3. Stack visual

- Bootstrap 5.
- Inter.
- Font Awesome.
- Vite.

Bootstrap será la base del layout y de los componentes.

## 4. Colores

```text
Primary:   #155EEF
Dark:      #0B1F3A
Accent:    #E53935
Background:#FFFFFF
Surface:   #F8FAFC
Text:      #1E293B
Muted:     #64748B
Border:    #E2E8F0
```

### Regla

Azul = identidad y estructura.

Rojo = acción y atención.

Neutros = fondo y contenido.

No utilizar azul y rojo en cantidades equivalentes en cada sección.

## 5. Tipografía

Familia principal:

**Inter**

Jerarquía conceptual:

```text
Display / H1
H2
H3
H4
Body
Small
```

Los tamaños definitivos deben aprovechar las clases responsive de Bootstrap.

## 6. Layout

Usar:
- `.container`
- `.container-fluid` solo cuando tenga sentido;
- `.row`;
- `.col-*`;
- utilidades de spacing;
- flexbox de Bootstrap.

Evitar crear sistemas de grid propios.

## 7. Espaciado

Preferir la escala de Bootstrap.

No utilizar valores arbitrarios en cada componente.

Si aparece una necesidad recurrente que Bootstrap no cubre, evaluar una regla global antes de crear una excepción.

## 8. Botones

Tipos principales:
- Primary.
- Secondary.
- Outline.
- Danger solo para acciones destructivas.

El rojo no debe utilizarse como botón primario de toda la web.

## 9. Cards

Las tarjetas deben utilizarse cuando ayudan a organizar contenido.

No convertir cada bloque de texto en una card.

Preferir:
- bordes suaves;
- sombra mínima;
- contenido claro;
- suficiente espacio interno.

## 10. Navegación

Desktop:
- logo;
- Productos;
- Servicios;
- Laboratorio;
- Sobre mí;
- Contacto.

Mobile:
- navegación colapsable.

La navegación debe permanecer sencilla.

## 11. Hero

No utilizar hero de pantalla completa por defecto.

El hero debe comunicar:
1. qué es SantaFeSL;
2. qué hace;
3. qué acción puede realizar el visitante.

## 12. Imágenes

Preferir imágenes reales de:
- productos;
- proyectos;
- infraestructura.

Optimizar tamaño y formato.

Utilizar `alt` descriptivo cuando corresponda.

## 13. Iconos

Font Awesome.

Los iconos deben tener una función clara.

No utilizar iconos como único medio de transmitir información.

## 14. Responsive

Diseño mobile-first.

Debe revisarse al menos:
- móvil pequeño;
- móvil;
- tablet;
- desktop.

No asumir que un layout desktop se adaptará automáticamente.

## 15. Accesibilidad

Requisitos:
- contraste suficiente;
- foco visible;
- navegación por teclado;
- labels;
- headings semánticos;
- `alt`;
- botones y enlaces diferenciados;
- no transmitir información únicamente por color.

## 16. Estados

Los estados funcionales pueden utilizar los colores semánticos de Bootstrap:
- success;
- warning;
- danger;
- info.

La paleta de marca no debe reemplazar la semántica cuando esta sea necesaria.

## 17. Animaciones

No son necesarias inicialmente.

Si se incorpora alguna:
- debe ser breve;
- no debe bloquear contenido;
- debe respetar `prefers-reduced-motion`;
- debe tener una finalidad concreta.

## 18. Dark mode

Fuera del alcance inicial.

## 19. CSS

Reglas:
- no estilos inline;
- no CSS hardcodeado en Blade;
- no duplicar clases;
- no crear reglas para resolver una sola instancia sin necesidad;
- centralizar personalizaciones.

## 20. Principio visual

> **La interfaz debe ayudar al contenido, no competir con él.**
