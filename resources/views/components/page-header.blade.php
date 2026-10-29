@props(['title', 'lead' => null])
<div class="page-header">
    <div class="container">
        <h1 class="page-header__title mb-3">{{ $title }}</h1>
        @if ($lead)
            <p class="lead  mb-0">{{ $lead }}</p>
        @endif
        {{ $slot }}
    </div>
</div>
