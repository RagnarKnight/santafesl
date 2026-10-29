php artisan test

   FAIL  Tests\Feature\IllustrationsTest

   PASS  Tests\Unit\CatalogTest
  ✓ it muestra solo los elementos publicados                                                                                                                 0.24s  
  ✓ it incluye los borradores solo cuando se piden                                                                                                           0.01s  
  ✓ it ordena por sort_order y luego por nombre
  ✓ it devuelve solo los destacados
  ✓ it rechaza datos inválidos with dataset "sin nombre"                                                                                                     0.01s  
  ✓ it rechaza datos inválidos with dataset "sin descripción corta"
  ✓ it rechaza datos inválidos with dataset "slug con mayúsculas"
  ✓ it rechaza datos inválidos with dataset "slug con espacios"
  ✓ it rechaza datos inválidos with dataset "estado inexistente"
  ✓ it rechaza datos inválidos with dataset "imagen sin alt"
  ✓ it rechaza slugs duplicados
  ✓ it acepta imágenes decorativas con alt vacío y estados válidos
  ✓ it divide la descripción en párrafos
  ✓ it usa el SEO propio o, si falta, el nombre y la descripción corta

   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                                                                                                        0.06s  

   PASS  Tests\Unit\HtmlAuditTest
  ✓ it detecta estilos inline with dataset "atributo style"                                                                                                  0.04s  
  ✓ it detecta estilos inline with dataset "elemento style"                                                                                                  0.01s  
  ✓ it detecta JavaScript inline with dataset "script con código"
  ✓ it detecta JavaScript inline with dataset "manejador onclick"
  ✓ it detecta JavaScript inline with dataset "URL javascript:"
  ✓ it detecta recursos externos (CDN) with dataset "hoja de estilos"                                                                                        0.01s  
  ✓ it detecta recursos externos (CDN) with dataset "hoja de estilos sin protocolo"
  ✓ it detecta recursos externos (CDN) with dataset "preload de fuente"
  ✓ it detecta recursos externos (CDN) with dataset "script externo"
  ✓ it detecta recursos externos (CDN) with dataset "imagen externa"
  ✓ it detecta recursos externos (CDN) with dataset "imagen con srcset externo"
  ✓ it no genera falsos positivos con contenido legítimo with dataset "enlace externo normal"
  ✓ it no genera falsos positivos con contenido legítimo with dataset "enlace a WhatsApp"
  ✓ it no genera falsos positivos con contenido legítimo with dataset "mailto"
  ✓ it no genera falsos positivos con contenido legítimo with dataset "canonical y alternate"
  ✓ it no genera falsos positivos con contenido legítimo with dataset "recursos propios relativos"
  ✓ it no genera falsos positivos con contenido legítimo with dataset "recursos propios absolutos"
  ✓ it no genera falsos positivos con contenido legítimo with dataset "JSON-LD como datos"
  ✓ it no genera falsos positivos con contenido legítimo with dataset "texto que menciona style y onclick"                                                   0.01s  
  ✓ it no genera falsos positivos con contenido legítimo with dataset "atributo cuyo nombre empieza con on pero no es un manejador"
  ✓ it extrae los hosts externos de un texto e ignora los espacios de nombres                                                                                0.01s  

   PASS  Tests\Feature\ContactPageTest
  ✓ it muestra el correo y el enlace oficial de WhatsApp configurados                                                                                        1.60s  
  ✓ it normaliza el número de WhatsApp a solo dígitos                                                                                                        0.07s  
  ✓ it explica que no hay canales publicados cuando no se configuró ninguno                                                                                  0.05s  
  ✓ it ignora un correo o un número inválidos with dataset "correo sin dominio"                                                                              0.05s  
  ✓ it ignora un correo o un número inválidos with dataset "texto cualquiera"                                                                                0.05s  
  ✓ it ignora un correo o un número inválidos with dataset "número demasiado largo"                                                                          0.05s  
  ✓ it marca los datos de ejemplo como ejemplo fuera de producción                                                                                           0.05s  
  ✓ it nunca presenta datos de ejemplo como contacto real en producción                                                                                      0.06s  
  ✓ it usa el mismo contacto en el pie de página                                                                                                             0.07s  
  ✓ it mantiene el .env.example con valores de ejemplo reconocidos como tales                                                                                0.04s  
  ✓ it no incluye ningún formulario                                                                                                                          0.06s  
  ✓ it trata como ejemplo cualquier número que termine en ocho ceros                                                                                         0.06s  

   FAIL  Tests\Feature\ContentIntegrityTest
  ✓ it carga y valida el contenido real (incluidos los borradores) with ('products')                                                                         0.09s  
  ✓ it carga y valida el contenido real (incluidos los borradores) with ('services')                                                                         0.04s  
  ✓ it carga y valida el contenido real (incluidos los borradores) with ('projects')                                                                         0.04s  
  ✓ it no publica marcas de contenido pendiente with ('products')                                                                                            0.04s  
  ✓ it no publica marcas de contenido pendiente with ('services')                                                                                            0.05s  
  ✓ it no publica marcas de contenido pendiente with ('projects')                                                                                            0.04s  
  ✓ it referencia solo imágenes que existen en el disco público with ('products')                                                                            0.04s  
  ⨯ it referencia solo imágenes que existen en el disco público with ('projects')                                                                            0.07s  
  ✓ it ilustra los servicios con iconos propios y no con imágenes                                                                                            0.09s  
  ✓ it usa solo iconos propios existentes y los dibuja como SVG decorativo                                                                                   0.09s  
  ✓ it rechaza un icono desconocido                                                                                                                          0.08s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                                                                                                            0.24s  

   PASS  Tests\Feature\FaviconTest
  ✓ it incluye el favicon: un .ico con varios tamaños y un PNG, ambos válidos                                                                                0.07s  
  ✓ it declara el favicon en el encabezado de cada página                                                                                                    0.07s  
  ✓ it muestra el logo SFSL en el encabezado con el nombre del sitio como texto alternativo                                                                  0.07s  

   PASS  Tests\Feature\FrontendRulesTest
  ✓ it no genera CSS ni JavaScript inline ni recursos externos en ninguna página                                                                             0.36s  
  ✓ it no referencia CDN ni fuentes remotas en el código fuente                                                                                              0.05s  
  ✓ it no incluye librerías prohibidas                                                                                                                       0.04s  
  ✓ it no deja recursos externos en los assets compilados                                                                                                    0.04s  

   FAIL  Tests\Feature\IllustrationsTest
  ⨯ it incluye las ilustraciones provisionales esperadas with ('hero-technology')                                                                            0.06s  
  ⨯ it incluye las ilustraciones provisionales esperadas with ('product-church')                                                                             0.03s  
  ⨯ it incluye las ilustraciones provisionales esperadas with ('product-pos')                                                                                0.04s  
  ⨯ it incluye las ilustraciones provisionales esperadas with ('product-catalog')                                                                            0.05s  
  ⨯ it incluye las ilustraciones provisionales esperadas with ('project-sincnetwork')                                                                        0.04s  
  ⨯ it incluye las ilustraciones provisionales esperadas with ('project-netwatch')                                                                           0.05s  
  ⨯ it usa en el contenido solo imágenes que existen y llevan texto alternativo                                                                              0.04s  
  ✓ it muestra la ilustración de portada configurada en el inicio                                                                                            0.07s  
  ✓ it sirve las imágenes con rutas relativas, sin depender de APP_URL                                                                                       0.03s  
  ✓ it muestra los párrafos de la ficha sin secuencias de escape literales                                                                                   0.10s  
  ✓ it publica storage/app/public mediante el enlace public/storage versionado                                                                               0.04s  

   FAIL  Tests\Feature\ProductPagesTest
  ✓ it genera el mensaje de WhatsApp de cada producto con el formato oficial y bien codificado with dataset "iglesias"                                       0.14s  
  ✓ it genera el mensaje de WhatsApp de cada producto con el formato oficial y bien codificado with dataset "caja"                                           0.09s  
  ✓ it genera el mensaje de WhatsApp de cada producto con el formato oficial y bien codificado with dataset "pediwa"                                         0.08s  
  ✓ it usa el número centralizado en la configuración y no lo escribe en ninguna vista                                                                       0.08s  
  ✓ it sin WhatsApp usa el correo y, sin correo, la página de contacto: nunca un enlace roto                                                                 0.12s  
  ✓ it no muestra el número de ejemplo en producción                                                                                                         0.09s  
  ✓ it marca el número de ejemplo fuera de producción                                                                                                        0.14s  
  ✓ it usa llamadas a la acción específicas en las tarjetas y no «Conocer más»                                                                               0.24s  
  ✓ it lleva cada llamada a la acción a su ficha o a su sección y esa sección existe                                                                         0.26s  
  ✓ it las maquetas no usan estilos en línea ni imágenes externas with ('church')                                                                            0.05s  
  ✓ it las maquetas no usan estilos en línea ni imágenes externas with ('pos')                                                                               0.04s  
  ✓ it las maquetas no usan estilos en línea ni imágenes externas with ('catalog')                                                                           0.04s  
  ✓ it tiene títulos y descripciones propios en cada producto                                                                                                0.17s  
  ✓ it dibuja un video local sin descargarlo hasta que se reproduce                                                                                          0.05s  
  ✓ it dibuja un video externo como portada con botón y sin cargar nada de afuera                                                                            0.04s  
  ✓ it no dibuja nada si el producto no tiene video                                                                                                          0.04s  
  ✓ it rechaza videos mal definidos with dataset "proveedor desconocido"                                                                                     0.04s  
  ✓ it rechaza videos mal definidos with dataset "sin portada"                                                                                               0.04s  
  ✓ it rechaza videos mal definidos with dataset "sin título"                                                                                                0.04s  
  ✓ it rechaza videos mal definidos with dataset "local sin archivo"                                                                                         0.03s  
  ✓ it rechaza videos mal definidos with dataset "externo sin https"                                                                                         0.03s  
  ✓ it rechaza videos mal definidos with dataset "orientación inválida"                                                                                      0.03s  
  ✓ it solo referencia videos y portadas que existen y proveedores permitidos                                                                                0.04s  
  ✓ it mantiene la CSP estricta y solo agrega frame-src para los dominios de video configurados                                                              0.04s  
  ✓ it explica cada servicio por su beneficio y enlaza a los programas                                                                                       0.05s  
  ✓ it la portada conserva «Ver todos los servicios» apuntando a una página existente                                                                        0.08s  
  ✓ it presenta el perfil de software libre y cultura maker sin inventar datos                                                                               0.07s  
  ✓ it el pie de página presenta «Sobre mí» y enlaza a la página                                                                                             0.07s  
  ✓ it presenta CHMS con su título, descripción y los dos botones principales                                                                                0.08s  
  ✓ it muestra las cuatro capturas reales con texto alternativo, tamaño y carga diferida                                                                     0.09s  
  ✓ it explica las etapas de consolidación y los datos de eventos y tesorería sin mezclar pagado con pendiente                                               0.08s  
  ✓ it agrupa los otros ocho módulos en tarjetas compactas                                                                                                   0.09s  
  ✓ it sin video real muestra la captura del panel y un aviso discreto, sin reproductor                                                                      0.10s  
  ✓ it con un video real, la ficha de CHMS usa el reproductor en lugar de la alternativa                                                                     0.11s  
  ✓ it la ficha de CHMS usa el mismo contacto centralizado y cae al correo o a /contacto                                                                     0.11s  
  ✓ it rechaza capturas y módulos mal definidos with dataset "captura sin alt"                                                                               0.05s  
  ✓ it rechaza capturas y módulos mal definidos with dataset "captura sin tamaño"                                                                            0.08s  
  ✓ it rechaza capturas y módulos mal definidos with dataset "módulo con icono inexistente"                                                                  0.04s  
  ✓ it presenta Pediwa con su título, descripción y los dos botones pedidos                                                                                  0.09s  
  ✓ it muestra el collage y las cuatro capturas con sus proporciones originales                                                                              0.10s  
  ✓ it explica el flujo en tres pasos y aclara que no es una tienda con pagos                                                                                0.14s  
  ✓ it no promete resultados comerciales ni funciones no verificadas                                                                                         0.13s  
  ✓ it lista los cinco rubros de los catálogos de ejemplo                                                                                                    0.15s  
  ✓ it Pediwa usa el contacto central y no muestra video vacío                                                                                               0.11s  
  ✓ it rechaza secciones mal definidas with dataset "tipo inválido"                                                                                          0.04s  
  ✓ it rechaza secciones mal definidas with dataset "sin ítems"                                                                                              0.04s  
  ✓ it rechaza secciones mal definidas with dataset "tarjeta sin título"                                                                                     0.04s  
  ✓ it rechaza secciones mal definidas with dataset "collage sin tamaño"                                                                                     0.04s  
  ✓ it la dirección vieja del «Catálogo web» redirige a Pediwa y ya no figura entre los programas                                                            0.09s  
  ✓ it presenta el POS con su título, descripción y los dos botones pedidos                                                                                  0.08s  
  ⨯ it muestra la captura principal y las capturas del POS con sus proporciones originales                                                                   0.12s  
  ✓ it usa en el celular la captura vertical de la misma pantalla, sin deslizar la imagen                                                                    0.08s  
  ✓ it presenta las funciones, los tres pasos y la administración del POS                                                                                    0.08s  
  ✓ it el POS no promete funciones, planes ni resultados no verificados                                                                                      0.09s  
  ✓ it el POS usa el contacto central y cae al correo o a /contacto                                                                                          0.08s  
  ✓ it alterna el orden de texto e imagen en las capturas lado a lado                                                                                        0.08s  
  ✓ it rechaza capturas con layout o versión móvil mal definidos with dataset "layout inválido"                                                              0.04s  
  ✓ it rechaza capturas con layout o versión móvil mal definidos with dataset "mobile sin tamaño"                                                            0.04s  
  ✓ it rechaza capturas con layout o versión móvil mal definidos with dataset "hero mobile sin imagen"                                                       0.04s  

   PASS  Tests\Feature\PublicPagesTest
  ✓ it responde 200 con la estructura básica en cada página pública with dataset "inicio"                                                                    0.29s  
  ✓ it responde 200 con la estructura básica en cada página pública with dataset "productos"                                                                 0.08s  
  ✓ it responde 200 con la estructura básica en cada página pública with dataset "servicios"                                                                 0.06s  
  ✓ it responde 200 con la estructura básica en cada página pública with dataset "sobre mí"                                                                  0.05s  
  ✓ it responde 200 con la estructura básica en cada página pública with dataset "contacto"                                                                  0.05s  
  ✓ it responde 200 en la ficha de cada producto publicado                                                                                                   0.18s  
  ✓ it muestra los productos publicados con el estado Terminado                                                                                              0.20s  
  ✓ it no publica el Laboratorio: sin rutas, enlaces ni menciones visibles                                                                                   0.74s  
  ✓ it conserva los datos internos de los proyectos sin publicarlos                                                                                          0.12s  
  ✓ it devuelve 404 para slugs inexistentes o inválidos with ('/productos/no-existe')                                                                        0.08s  
  ✓ it devuelve 404 para slugs inexistentes o inválidos with ('/productos/Mayusculas_y_guion_bajo')                                                          0.05s  
  ✓ it devuelve 404 para slugs inexistentes o inválidos with ('/laboratorio')                                                                                0.06s  
  ✓ it devuelve 404 para slugs inexistentes o inválidos with ('/laboratorio/no-existe')                                                                      0.05s  
  ✓ it devuelve 404 para slugs inexistentes o inválidos with ('/servicios/desarrollo')                                                                       0.05s  
  ✓ it devuelve 404 para slugs inexistentes o inválidos with ('/admin')                                                                                      0.05s  
  ✓ it devuelve 404 para slugs inexistentes o inválidos with ('/login')                                                                                      0.05s  
  ✓ it muestra una página 404 en español sin indexar                                                                                                         0.05s  
  ✓ it marca la sección activa con aria-current                                                                                                              0.07s  
  ✓ it publica un sitemap con todas las páginas y fichas publicadas                                                                                          0.05s  
  ✓ it no envía cookies en el sitio público                                                                                                                  0.10s  

   PASS  Tests\Feature\SecurityHeadersTest
  ✓ it envía las cabeceras de seguridad y una CSP sin inline                                                                                                 0.15s  
  ✓ it también protege las páginas de error                                                                                                                  0.06s  
  ✓ it no aplica la CSP en el entorno local para no bloquear el servidor de Vite                                                                             0.07s  

   PASS  Tests\Feature\SeoTest
  ✓ it define título único, descripción, canonical y Open Graph en cada página                                                                               0.44s  
  ✓ it no usa el Host de la petición para construir el canonical                                                                                             0.07s  
  ✓ it mantiene un robots.txt con la referencia al sitemap                                                                                                   0.04s  
  ────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\IllustrationsTest >                                                                                                                        
  The data provider specified for P\Tests\Feature\IllustrationsTest::__pest_evaluable_it_mantiene_cada_SVG_válido__liviano_y_sin_scripts_ni_referencias_externas is invalid
Empty data set provided by data provider

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\ContentIntegrityTest > it referencia solo imágenes que existen en el disco público with ('projects')                                       
  Falta la imagen illustrations/project-sincnetwork.svg de sincnetwork
Failed asserting that false is true.

  at tests/Feature/ContentIntegrityTest.php:34
     30▕ 
     31▕     foreach (app(Catalog::class)->all($type, publishedOnly: false) as $entry) {
     32▕         if ($entry->image_path !== null) {
     33▕             expect(Storage::disk('public')->exists($entry->image_path))
  ➜  34▕                 ->toBeTrue("Falta la imagen {$entry->image_path} de {$entry->slug}");
     35▕             $checked++;
     36▕         }
     37▕     }
     38▕ 

  1   tests/Feature/ContentIntegrityTest.php:34

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\IllustrationsTest > it incluye las ilustraciones provisionales esperadas with ('hero-technology')                                          
  Failed asserting that file "/home/ragnar/GIT/github/RagnarKnight/WEB/santafesl/storage/app/public/illustrations/hero-technology.svg" exists.

  at tests/Feature/IllustrationsTest.php:12
      8▕     return glob(dirname(__DIR__, 2).'/storage/app/public/illustrations/*.svg') ?: [];
      9▕ }
     10▕ 
     11▕ it('incluye las ilustraciones provisionales esperadas', function (string $name) {
  ➜  12▕     expect(storage_path("app/public/illustrations/{$name}.svg"))->toBeFile();
     13▕ })->with(['hero-technology', 'product-church', 'product-pos', 'product-catalog', 'project-sincnetwork', 'project-netwatch']);
     14▕ 
     15▕ it('mantiene cada SVG válido, liviano y sin scripts ni referencias externas', function (string $file) {
     16▕     $xml = file_get_contents($file);

  1   tests/Feature/IllustrationsTest.php:12

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\IllustrationsTest > it incluye las ilustraciones provisionales esperadas with ('product-church')                                           
  Failed asserting that file "/home/ragnar/GIT/github/RagnarKnight/WEB/santafesl/storage/app/public/illustrations/product-church.svg" exists.

  at tests/Feature/IllustrationsTest.php:12
      8▕     return glob(dirname(__DIR__, 2).'/storage/app/public/illustrations/*.svg') ?: [];
      9▕ }
     10▕ 
     11▕ it('incluye las ilustraciones provisionales esperadas', function (string $name) {
  ➜  12▕     expect(storage_path("app/public/illustrations/{$name}.svg"))->toBeFile();
     13▕ })->with(['hero-technology', 'product-church', 'product-pos', 'product-catalog', 'project-sincnetwork', 'project-netwatch']);
     14▕ 
     15▕ it('mantiene cada SVG válido, liviano y sin scripts ni referencias externas', function (string $file) {
     16▕     $xml = file_get_contents($file);

  1   tests/Feature/IllustrationsTest.php:12

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\IllustrationsTest > it incluye las ilustraciones provisionales esperadas with ('product-pos')                                              
  Failed asserting that file "/home/ragnar/GIT/github/RagnarKnight/WEB/santafesl/storage/app/public/illustrations/product-pos.svg" exists.

  at tests/Feature/IllustrationsTest.php:12
      8▕     return glob(dirname(__DIR__, 2).'/storage/app/public/illustrations/*.svg') ?: [];
      9▕ }
     10▕ 
     11▕ it('incluye las ilustraciones provisionales esperadas', function (string $name) {
  ➜  12▕     expect(storage_path("app/public/illustrations/{$name}.svg"))->toBeFile();
     13▕ })->with(['hero-technology', 'product-church', 'product-pos', 'product-catalog', 'project-sincnetwork', 'project-netwatch']);
     14▕ 
     15▕ it('mantiene cada SVG válido, liviano y sin scripts ni referencias externas', function (string $file) {
     16▕     $xml = file_get_contents($file);

  1   tests/Feature/IllustrationsTest.php:12

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\IllustrationsTest > it incluye las ilustraciones provisionales esperadas with ('product-catalog')                                          
  Failed asserting that file "/home/ragnar/GIT/github/RagnarKnight/WEB/santafesl/storage/app/public/illustrations/product-catalog.svg" exists.

  at tests/Feature/IllustrationsTest.php:12
      8▕     return glob(dirname(__DIR__, 2).'/storage/app/public/illustrations/*.svg') ?: [];
      9▕ }
     10▕ 
     11▕ it('incluye las ilustraciones provisionales esperadas', function (string $name) {
  ➜  12▕     expect(storage_path("app/public/illustrations/{$name}.svg"))->toBeFile();
     13▕ })->with(['hero-technology', 'product-church', 'product-pos', 'product-catalog', 'project-sincnetwork', 'project-netwatch']);
     14▕ 
     15▕ it('mantiene cada SVG válido, liviano y sin scripts ni referencias externas', function (string $file) {
     16▕     $xml = file_get_contents($file);

  1   tests/Feature/IllustrationsTest.php:12

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\IllustrationsTest > it incluye las ilustraciones provisionales esperadas with ('project-sincnetwork')                                      
  Failed asserting that file "/home/ragnar/GIT/github/RagnarKnight/WEB/santafesl/storage/app/public/illustrations/project-sincnetwork.svg" exists.

  at tests/Feature/IllustrationsTest.php:12
      8▕     return glob(dirname(__DIR__, 2).'/storage/app/public/illustrations/*.svg') ?: [];
      9▕ }
     10▕ 
     11▕ it('incluye las ilustraciones provisionales esperadas', function (string $name) {
  ➜  12▕     expect(storage_path("app/public/illustrations/{$name}.svg"))->toBeFile();
     13▕ })->with(['hero-technology', 'product-church', 'product-pos', 'product-catalog', 'project-sincnetwork', 'project-netwatch']);
     14▕ 
     15▕ it('mantiene cada SVG válido, liviano y sin scripts ni referencias externas', function (string $file) {
     16▕     $xml = file_get_contents($file);

  1   tests/Feature/IllustrationsTest.php:12

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\IllustrationsTest > it incluye las ilustraciones provisionales esperadas with ('project-netwatch')                                         
  Failed asserting that file "/home/ragnar/GIT/github/RagnarKnight/WEB/santafesl/storage/app/public/illustrations/project-netwatch.svg" exists.

  at tests/Feature/IllustrationsTest.php:12
      8▕     return glob(dirname(__DIR__, 2).'/storage/app/public/illustrations/*.svg') ?: [];
      9▕ }
     10▕ 
     11▕ it('incluye las ilustraciones provisionales esperadas', function (string $name) {
  ➜  12▕     expect(storage_path("app/public/illustrations/{$name}.svg"))->toBeFile();
     13▕ })->with(['hero-technology', 'product-church', 'product-pos', 'product-catalog', 'project-sincnetwork', 'project-netwatch']);
     14▕ 
     15▕ it('mantiene cada SVG válido, liviano y sin scripts ni referencias externas', function (string $file) {
     16▕     $xml = file_get_contents($file);

  1   tests/Feature/IllustrationsTest.php:12

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\IllustrationsTest > it usa en el contenido solo imágenes que existen y llevan texto alternativo                                            
  Failed asserting that false is true.

  at tests/Feature/IllustrationsTest.php:42
     38▕ 
     39▕     foreach (array_merge($catalog->products(), $catalog->projects()) as $entry) {
     40▕         expect($entry->image_path)->not->toBeNull();
     41▕         expect($entry->image_alt)->not->toBeEmpty();
  ➜  42▕         expect(Storage::disk('public')->exists($entry->image_path))->toBeTrue();
     43▕     }
     44▕ });
     45▕ 
     46▕ it('muestra la ilustración de portada configurada en el inicio', function () {

  1   tests/Feature/IllustrationsTest.php:42

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\ProductPagesTest > it muestra la captura principal y las capturas del POS con sus proporciones originales                                  
  Failed asserting that two arrays are identical.
   Array &0 [
       0 => 1351,
  -    1 => 587,
  +    1 => 582,
   ]
  

  at tests/Feature/ProductPagesTest.php:479
    475▕ 
    476▕         expect(is_file($path))->toBeTrue("Falta {$file['image']}");
    477▕ 
    478▕         [$w, $h] = getimagesize($path);
  ➜ 479▕         expect([$w, $h])->toBe([$file['width'], $file['height']])
    480▕             ->and($html)->toContain('width="'.$file['width'].'" height="'.$file['height'].'"');
    481▕     }
    482▕ 
    483▕     foreach ([$product->hero_image, ...$product->screens] as $file) {

  1   tests/Feature/ProductPagesTest.php:479


  Tests:    10 failed, 154 passed (723 assertions)
  Duration: 15.00s
