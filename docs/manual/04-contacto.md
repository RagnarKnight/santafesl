# Cambiar el contacto (correo y WhatsApp)

El correo y el WhatsApp se configuran **en un solo lugar**: el archivo `.env`. El archivo `config/site.php` los lee y el resto del sitio (página Contacto y pie de página) los usa sin que tengas que tocar ninguna vista.

El sitio **no tiene formulario** ni guarda mensajes: solo muestra un botón de correo (`mailto:`) y un botón que abre WhatsApp.

## 1. Cambiar el correo

En `.env`:

```env
SITE_CONTACT_EMAIL=hola@tudominio.com
```

Tiene que ser una dirección válida. Si está vacía o es inválida, el correo no se muestra.

## 2. Cambiar el número de WhatsApp

En `.env`:

```env
SITE_CONTACT_WHATSAPP=5491100000000
```

Formato internacional, **solo dígitos**: código de país + número, sin `+`, espacios, guiones ni paréntesis. Entre 8 y 15 dígitos.

Para un celular de Argentina el formato es `54` + `9` + código de área **sin el 0** + número **sin el 15**. Por ejemplo, un celular de código de área 11 y número 0000-0000 (ficticio) se escribe `5491100000000`. (Ese número es solo un ejemplo de formato: usá el tuyo.)

El sitio arma el enlace oficial de WhatsApp: `https://wa.me/<número>?text=<mensaje>`. En un teléfono con la aplicación instalada abre WhatsApp con la conversación lista; sin la aplicación, abre WhatsApp Web para continuar cuando es posible.

Si el número está vacío o no tiene un formato válido, el botón no se muestra.

## 3. Cambiar el mensaje inicial

Es el texto con el que se abre el chat (opcional). En `.env`:

```env
SITE_CONTACT_WHATSAPP_MESSAGE="Hola, quiero consultar por los servicios de SantaFeSL."
```

Si lo dejás vacío (`SITE_CONTACT_WHATSAPP_MESSAGE=`) el chat se abre sin texto. El valor por defecto está en `config/site.php`.

## 4. Aplicar el cambio

- **En tu computadora:** guardá `.env` y recargá la página. Si no cambia, ejecutá `php artisan config:clear`.
- **En producción:** editá el `.env` **del servidor** y volvé a generar la caché:

  ```bash
  php artisan config:cache
  ```

  Mientras exista la caché, Laravel ignora los cambios del `.env` hasta que la regeneres.

## 5. Comprobar los enlaces

1. Abrí `/contacto` y revisá que los botones aparezcan.
2. Pasá el mouse sobre cada botón (o hacé clic derecho → *Copiar dirección del enlace*) y verificá:
   - correo: `mailto:hola@tudominio.com`
   - WhatsApp: `https://wa.me/5491100000000?text=...`
3. Hacé clic en el botón de WhatsApp y comprobá que se abre la conversación con **tu** número.
4. Mirá también el pie de página: muestra el mismo correo.
5. Ejecutá `php artisan test --filter=ContactPage`.

## 6. Datos de ejemplo

El archivo `.env.example` trae datos **ficticios**: `contacto@example.com` (dominio reservado para ejemplos) y el número `5490000000000`, que no pertenece a nadie. Se consideran de ejemplo el correo con dominio `example.com`, `example.org` o `example.net`, y cualquier número que termine en ocho ceros (como `5490000000000` o `5491100000000`). El sitio los reconoce y se comporta así:

| Entorno | Qué pasa con los datos de ejemplo |
|---|---|
| Desarrollo (`APP_ENV=local` o similar) | Se muestran con el aviso *"Correo de ejemplo / Número de ejemplo: reemplazalo antes de publicar"* |
| Producción (`APP_ENV=production`) | **No se muestran**: la página dice que los canales todavía no están publicados |

Así los datos ficticios nunca se presentan como contacto real.

### Reemplazar los datos ficticios antes de publicar

- [ ] En el `.env` **del servidor** poné tu correo real en `SITE_CONTACT_EMAIL`.
- [ ] Poné tu número real en `SITE_CONTACT_WHATSAPP` (formato internacional, solo dígitos).
- [ ] Ejecutá `php artisan config:cache`.
- [ ] Abrí `/contacto` en el sitio publicado y probá ambos enlaces (sección 5).
- [ ] Confirmá que no aparezca la palabra "ejemplo" ni `example.com`.

## 7. Agregar otro canal

Fuera del alcance de la v1 (la decisión fue usar solo correo y WhatsApp). Si más adelante se quiere sumar uno, hay que agregar la variable en `.env.example`, su lectura en `config/site.php`, la lógica en `app/Support/SiteContact.php`, el botón en `pages/contact.blade.php` y su prueba.
