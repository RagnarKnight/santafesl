{{-- Bloque de texto de una ficha: cards, steps o checks (ver intro_sections / outro_sections en products.php). --}}
<section id="{{ $section['id'] }}" class="section product-section {{ $tint ? 'section--tint' : '' }}" aria-labelledby="titulo-{{ $section['id'] }}">
    <div class="container">
        <h2 id="titulo-{{ $section['id'] }}" class="section-title mb-3">{{ $section['title'] }}</h2>
        @if ($section['lead'])
            <p class="prose mb-4">{{ $section['lead'] }}</p>
        @endif

        @if ($section['type'] === 'cards')
            <ul class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4 list-unstyled mb-0">
                @foreach ($section['items'] as $item)
                    <li class="col">
                        <div class="service-block h-100">
                            <h3 class="h5">{{ $item['title'] }}</h3>
                            <p class="mb-0">{{ $item['text'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @elseif ($section['type'] === 'steps')
            <ol class="step-list list-unstyled mb-0">
                @foreach ($section['items'] as $item)
                    <li class="step-list__item">
                        <span class="step-list__number" aria-hidden="true">{{ $loop->iteration }}</span>
                        <div>
                            <h3 class="h5 mb-1">{{ $item['title'] }}</h3>
                            <p class="mb-0">{{ $item['text'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        @else
            <ul class="feature-list mb-0">
                @foreach ($section['items'] as $item)
                    <li><span class="feature-list__tick"><x-icon name="check" :size="16" /></span><span>{{ $item['text'] }}</span></li>
                @endforeach
            </ul>
        @endif

        @if ($section['note'])
            <p class="demo-note mt-4 mb-0">{{ $section['note'] }}</p>
        @endif
    </div>
</section>
