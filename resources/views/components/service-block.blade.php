@props(['service', 'level' => 3, 'details' => false])
<div class="service-row h-100">
    @if ($service->icon)
        <span class="service-row__tile" aria-hidden="true"><x-icon :name="$service->icon" :size="26" /></span>
    @endif
    <div>
        <h{{ $level }} class="h5 mb-1">{{ $service->name }}</h{{ $level }}>
        <p class="mb-0">{{ $service->short_description }}</p>
        @if ($details && $service->description)
            <p class="mt-2 mb-0">{{ $service->description }}</p>
        @endif
        @if ($details && $service->features !== [])
            <details class="tech-details mt-2">
                <summary>Ver el detalle técnico</summary>
                <p class="small mt-2 mb-0">{{ implode(' · ', $service->features) }}</p>
            </details>
        @endif
    </div>
</div>
