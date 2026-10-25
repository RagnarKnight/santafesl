// Video de un proveedor externo, bajo demanda: no se carga nada de afuera
// hasta que la persona toca el botón de reproducir.
// El dominio tiene que estar permitido en config/site.php ('video_hosts'): la CSP
// bloquea cualquier otro.
document.querySelectorAll('[data-video-embed]').forEach((box) => {
    const button = box.querySelector('button');

    if (!button) {
        return;
    }

    button.addEventListener('click', () => {
        let url;

        try {
            url = new URL(box.dataset.videoEmbed);
        } catch {
            return;
        }

        if (url.protocol !== 'https:') {
            return;
        }

        url.searchParams.set('autoplay', '1');

        const frame = document.createElement('iframe');
        frame.className = 'product-video__frame';
        frame.src = url.toString();
        frame.title = box.dataset.videoTitle || 'Video';
        frame.allow = 'autoplay; fullscreen; picture-in-picture';
        frame.allowFullscreen = true;
        frame.referrerPolicy = 'strict-origin-when-cross-origin';

        box.replaceChildren(frame);
        frame.focus();
    });
});
