# SantaFeSL — Diseño UI/UX

> **Estado:** propuesta. Complementa `00-brand.md` (identidad) y reemplaza en lo técnico a `03-design.md`, que se conserva como referencia histórica. Donde difieren, manda este documento.

## 1. Principios

Simple · limpio · cercano · honesto · responsive · accesible · rápido. La interfaz ayuda al contenido, no compite con él. Se evita lo que `00-brand.md` §17 ya excluye (sliders, glassmorphism, exceso de sombras y tarjetas).

## 2. Base visual

- **Bootstrap 5.3** como sistema de layout y componentes, compilado desde Sass.
- **Inter** como única familia, alojada en el propio sitio.
- **Iconos:** SVG inline mediante `<x-icon>` (propuesta D5; Font Awesome queda descartado salvo que se apruebe).
- Sin modo oscuro en v1.

## 3. Color

Paleta de marca (`00-brand.md` §11) con la verificación de contraste calculada para este documento (relación WCAG 2.x; objetivo texto normal ≥ 4.5:1, texto grande y componentes de interfaz ≥ 3:1):

| Rol | HEX | Sobre blanco | Sobre `#F8FAFC` | Texto blanco encima | Veredicto |
|---|---|---|---|---|---|
| Principal `#155EEF` | azul | 5.41 | 5.17 | 5.41 | Cumple AA para texto, enlaces y botones |
| Oscuro `#0B1F3A` | azul oscuro | 16.52 | 15.79 | 16.52 | Cumple (header/footer) |
| Texto `#1E293B` | slate 800 | 14.63 | 13.98 | — | Cumple |
| Secundario `#64748B` | slate 500 | 4.76 | **4.55** | — | Cumple justo; no usar para texto pequeño sobre otras superficies |
| Acento `#E53935` | rojo | **4.23** | **4.04** | **4.23** | **No cumple 4.5:1** para texto normal |
| Borde `#E2E8F0` | slate 200 | 1.23 | 1.18 | — | Solo decorativo; no sirve como único indicador de un campo o control (exige 3:1) |

**Hallazgo y propuesta (D9):** el rojo de marca no alcanza AA para texto normal ni para botones con texto blanco pequeño. Se propone un token `--sfsl-accent-strong` para texto y botones, por ejemplo `#C62828` (5.62:1 sobre blanco), y reservar `#E53935` para elementos decorativos o texto grande (≥ 24 px, o ≥ 18.66 px en negrita). El valor definitivo lo aprueba el autor tras verlo en pantalla.

Reglas de uso (de `00-brand.md`): azul = identidad y estructura; rojo = acción puntual; neutros = fondo y contenido. El rojo no es el botón primario de toda la web. Los colores semánticos de Bootstrap (success/warning/danger/info) se mantienen para estados.

La información **nunca** se transmite solo con color (los estados de producto llevan texto).

## 4. Tipografía

- Inter, pesos **400, 600 y 700**, subconjunto `latin` (cubre á é í ó ú ñ ü ¿ ¡). Peso 500 solo si se justifica.
- Cuerpo ≥ 16 px (`1rem`), interlineado ≥ 1.5; ancho de línea de lectura ≤ ~75 caracteres.
- Escala con las clases responsive de Bootstrap (`display-*`, `fs-*`), sin tamaños arbitrarios.
- Fuente de respaldo: `system-ui, sans-serif`. `font-display: swap`.

## 5. Layout y navegación

- Mobile-first con `.container`, grilla y utilidades de Bootstrap; sin grillas propias.
- Breakpoints a revisar: 320, 375, 768, 1024 y 1440 px.
- **Header:** logo/nombre, Productos, Servicios, Contacto (más Laboratorio / Sobre mí si se aprueban, D3). En móvil, menú colapsable con `Collapse`.
- **Footer:** nombre, descriptor, enlaces a secciones, canales de contacto.
- **Skip-link** «Saltar al contenido» como primer elemento enfocable.
- Página actual marcada con `aria-current="page"`.

## 6. Páginas

| Página | Estructura |
|---|---|
| Inicio | Hero (h1 + descriptor + 2 acciones) → productos destacados → servicios → CTA de contacto |
| Productos | `page-header` + grilla de tarjetas; estado vacío si no hay publicados |
| Producto | Nombre (h1), descripción corta, estado, imagen, problema/público/funciones **confirmadas**, CTA |
| Servicios | Lista por categoría, enfocada en problemas del cliente, sin precios |
| Contacto | Canales verificables; mensaje «Contame qué necesitás y vemos si podemos resolverlo» (de `02-content.md`) |
| 404 / 500 | Mensaje claro en español + enlace al inicio |

Contenido y reglas editoriales: `02-content.md` (se mantiene). Regla de oro: **no inventar funciones, clientes, métricas ni precios.**

## 7. Componentes y estados

Botones: primario (azul), secundario/outline, acento solo para acciones puntuales. Tarjetas solo cuando agrupan contenido repetido. Badge de estado con texto. Focus visible en todos los controles (no se elimina `outline`). Estados vacíos redactados, no pantallas en blanco.

## 8. Imágenes

Capturas y fotografías reales (`00-brand.md` §15). Siempre con `width`/`height` (evita saltos de maquetación), `loading="lazy"` salvo la imagen principal visible al cargar, `alt` descriptivo o `alt=""` si es decorativa. Formatos WebP/AVIF/JPEG; peso objetivo < 200 KB por imagen de contenido. Imagen Open Graph de 1200×630.

## 9. Organización de CSS y JavaScript

```text
resources/css/
├── app.scss                  único entry point
├── abstracts/_variables.scss   tokens de marca → variables Sass de Bootstrap ($primary, $font-family-base…)
├── base/_fonts.scss          @font-face de Inter (resuelto por Vite/@fontsource)
├── base/_base.scss           ajustes globales mínimos (skip-link, foco)
└── components/               un parcial por componente propio, solo si Bootstrap no lo cubre
resources/js/
└── app.js                    import 'bootstrap/js/dist/collapse'
```

Reglas:

1. Personalizar con **variables de Sass de Bootstrap** antes de importarlo; no sobrescribir con selectores.
2. Importar solo los módulos de Bootstrap necesarios (`functions`, `variables`, `maps`, `mixins`, `root`, `reboot`, `type`, `containers`, `grid`, `buttons`, `nav`, `navbar`, `card`, `badge`, `utilities`, `helpers`, `transitions` y los que se agreguen).
3. Cero `style=""`, cero `<style>`, cero `<script>` con código, cero `onclick=`.
4. Un valor de color aparece una sola vez (en `_variables.scss`).
5. `prefers-reduced-motion` respetado; sin animaciones en v1.
6. Se pueden usar utilidades de Bootstrap en Blade; los estilos propios van en `components/`.

## 10. Accesibilidad (resumen operativo)

Objetivo WCAG 2.2 AA. Checklist por página:

- [ ] Un solo `<h1>`; jerarquía sin saltos.
- [ ] Landmarks: `header`, `nav` (con `aria-label`), `main`, `footer`.
- [ ] Skip-link funcional; foco visible; todo operable con teclado; sin trampas de foco.
- [ ] `lang="es"` en `<html>`.
- [ ] Contraste verificado (§3); zonas táctiles ≥ 24×24 px (preferible 44×44).
- [ ] Enlaces con texto descriptivo (no «clic aquí»); los que abren fuera indican destino.
- [ ] Imágenes con `alt` correcto; iconos decorativos con `aria-hidden="true"`.
- [ ] Zoom al 200 % y reflow a 320 px sin scroll horizontal.
- [ ] Menú colapsable con `aria-expanded`/`aria-controls` (provisto por Bootstrap).
- [ ] Probado con teclado y un lector de pantalla antes de publicar.

## 11. Criterio de aceptación visual

Una persona sin conocimientos técnicos, desde un teléfono, entiende en pocos segundos qué es SantaFeSL, qué productos tiene y cómo contactar.

## Dirección visual v2 (rojo y blanco sobre crema)

Reemplaza la paleta fría de las secciones anteriores. Se probó una variante azul noche/naranja y el autor prefirió el estilo rojo y blanco; esta es la vigente.

- **Paleta (`resources/css/abstracts/_variables.scss`):** fondo crema `#FFFAF3`, secciones alternas blanco y arena `#F6EBDC`, texto `#2B2420`, secundario `#6B5F55`, borde `#E6D8C5`, círculo de icono `#FDEBE3`. Rojo `#C62828` (`$primary`) para botones, enlaces y palabras destacadas (5,4:1 sobre crema; 5,6:1 con texto blanco). `#E53935` solo decorativo. El azul `#155eef` queda para «SantaFe» del logo y el foco del teclado.
- **Estructura del inicio (según la referencia móvil del autor):** portada con etiqueta «Soluciones tecnológicas», título, dos botones e ilustración → programas (tarjeta horizontal: icono en recuadro durazno, texto, ilustración difuminada a la derecha y botón circular con flecha) → servicios (filas con icono, sin tarjeta; detalle técnico plegable en `/servicios`) → laboratorio (un solo panel blanco con encabezado y dos filas compactas) → contacto (tarjeta roja redondeada con botón blanco) → pie claro y compacto. Las tarjetas de programas son verticales (imagen arriba) desde 768 px; las del laboratorio son horizontales en todos los tamaños. Las páginas internas abren con una cabecera durazno.
- **Ilustraciones:** SVG propios y provisionales en `storage/app/public/illustrations/`, referenciados desde `image_path`/`image_alt` en `resources/content/*.php` y, la portada, desde `config/site.php` (`hero`). `IllustrationsTest` exige SVG válidos, sin scripts, estilos ni referencias externas.
- **URLs de imágenes relativas:** el disco `public` usa `/storage`, no `APP_URL`. El enlace `public/storage → ../storage/app/public` está **versionado** (se quitó de `.gitignore`) para que las imágenes funcionen sin pasos extra; `composer setup` además ejecuta `storage:link --force`. `IllustrationsTest` comprueba que el enlace apunte a `storage/app/public`.
- **Tras cambiar estilos hay que recompilar:** `npm run build` (o `npm run dev`); si no, se ve HTML nuevo con CSS viejo.
- **Lenguaje:** frases cortas, sin jerga; CHMS y POS solo como «también se lo conoce como…». Detalle técnico de servicios en `<details>` nativo.
- **Sin contenido nuevo:** no hay funciones, estados, precios ni contactos inventados.
