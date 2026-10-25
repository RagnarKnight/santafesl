@props(['type'])
@php
    $labels = [
        'church' => 'Ilustración conceptual de un panel de gestión para iglesias: menú lateral, resumen y lista de registros.',
        'pos' => 'Ilustración conceptual de una pantalla de caja: productos a la izquierda y el ticket de la venta a la derecha.',
        'catalog' => 'Ilustración conceptual de un catálogo en un teléfono: categorías y productos con imagen y precio.',
    ];
@endphp
{{-- Maqueta de interfaz hecha con HTML y CSS propios. Es una idea, NO una captura de un programa real. --}}
<div class="mockup mockup--{{ $type }}" role="img" aria-label="{{ $labels[$type] ?? 'Ilustración conceptual de la interfaz.' }}">
    @if ($type === 'church')
        <div class="mk-window" aria-hidden="true">
            <div class="mk-bar"><i></i><i></i><i></i></div>
            <div class="mk-body">
                <div class="mk-side">
                    <b class="mk-nav is-on"></b><b class="mk-nav"></b><b class="mk-nav"></b><b class="mk-nav"></b>
                </div>
                <div class="mk-main">
                    <div class="mk-title"></div>
                    <div class="mk-stats">
                        <div class="mk-card"><span></span><strong></strong></div>
                        <div class="mk-card"><span></span><strong></strong></div>
                        <div class="mk-card d-none d-sm-block"><span></span><strong></strong></div>
                    </div>
                    <div class="mk-list">
                        @foreach ([68, 54, 76, 48] as $w)
                            <div class="mk-row"><i class="mk-dot"></i><span class="mk-line mk-w-{{ $w }}"></span><em class="mk-pill"></em></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @elseif ($type === 'pos')
        <div class="mk-window" aria-hidden="true">
            <div class="mk-bar"><i></i><i></i><i></i></div>
            <div class="mk-body">
                <div class="mk-main">
                    <div class="mk-title"></div>
                    <div class="mk-tiles">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="mk-tile"><span class="mk-img"></span><span class="mk-line mk-w-68"></span></div>
                        @endfor
                    </div>
                </div>
                <div class="mk-ticket">
                    <div class="mk-title mk-w-48"></div>
                    @foreach ([76, 54, 68] as $w)
                        <div class="mk-row"><span class="mk-line mk-w-{{ $w }}"></span><em class="mk-pill"></em></div>
                    @endforeach
                    <div class="mk-total"><span class="mk-line mk-w-48"></span><strong></strong></div>
                    <div class="mk-button"></div>
                </div>
            </div>
        </div>
    @else
        <div class="mk-phone" aria-hidden="true">
            <div class="mk-notch"></div>
            <div class="mk-title"></div>
            <div class="mk-chips"><em class="is-on"></em><em></em><em></em></div>
            <div class="mk-products">
                @for ($i = 0; $i < 4; $i++)
                    <div class="mk-product"><span class="mk-img"></span><span class="mk-line mk-w-76"></span><em class="mk-pill"></em></div>
                @endfor
            </div>
        </div>
    @endif
</div>
