@props(['name', 'size' => 28])
{{-- Iconos propios (trazo, 24×24). Decorativos: siempre aria-hidden. --}}
<svg xmlns="http://www.w3.org/2000/svg" width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
    @switch($name)
        @case('church')
            <path d="M12 2v5M10 4.5h4M6 21V11l6-4 6 4v10M3 21h18M10 21v-5a2 2 0 0 1 4 0v5"/>
            @break
        @case('bag')
            <path d="M5 8h14l-1 12H6L5 8zM9 8V6a3 3 0 0 1 6 0v2"/>
            @break
        @case('grid')
            <rect x="4" y="4" width="7" height="7" rx="1.5"/><rect x="13" y="4" width="7" height="7" rx="1.5"/><rect x="4" y="13" width="7" height="7" rx="1.5"/><rect x="13" y="13" width="7" height="7" rx="1.5"/>
            @break
        @case('server')
            <rect x="3" y="4" width="18" height="6" rx="2"/><rect x="3" y="14" width="18" height="6" rx="2"/><path d="M7 7h.01M7 17h.01"/>
            @break
        @case('wifi')
            <path d="M2 9a15 15 0 0 1 20 0M5 12.5a10 10 0 0 1 14 0M8.5 16a5 5 0 0 1 7 0"/><circle cx="12" cy="19" r="1"/>
            @break
        @case('code')
            <path d="M8 8l-4 4 4 4M16 8l4 4-4 4M14 5l-4 14"/>
            @break
        @case('chat')
            <path d="M4 5h16v11H9l-5 4V5z"/>
            @break
        @case('flask')
            <path d="M9 3h6M10 3v6l-5 9a2 2 0 0 0 2 3h10a2 2 0 0 0 2-3l-5-9V3"/>
            @break
        @case('register')
            <path d="M7 4h10l1 5H6l1-5zM4 9h16v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9zM8 13h.01M12 13h.01M16 13h.01M8 16h.01M12 16h.01M16 16h.01"/>
            @break
        @case('globe')
            <circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 3 15 0 18M12 3c-3 3-3 15 0 18"/>
            @break
        @case('search')
            <circle cx="11" cy="11" r="6"/><path d="M16 16l4 4"/>
            @break
        @case('gear')
            <circle cx="12" cy="12" r="3.2"/><path d="M12 4.5l1.3 2.2 2.5-.5.9 2.4 2.3 1.1-.9 2.4.9 2.4-2.3 1.1-.9 2.4-2.5-.5L12 19.5l-1.3-2.2-2.5.5-.9-2.4-2.3-1.1.9-2.4-.9-2.4 2.3-1.1.9-2.4 2.5.5z"/>
            @break
        @case('network')
            <circle cx="12" cy="5" r="2"/><circle cx="5" cy="19" r="2"/><circle cx="19" cy="19" r="2"/><path d="M12 7v4M12 11l-6 6M12 11l6 6"/>
            @break
        @case('wrench')
            <path d="M14.5 6.5a4 4 0 0 0-5 5L4 17l3 3 5.5-5.5a4 4 0 0 0 5-5l-2.5 2.5-2.5-.5-.5-2.5 2.5-2.5z"/>
            @break
        @case('arrow')
            <path d="M5 12h14M13 6l6 6-6 6"/>
            @break
        @case('monitor')
            <rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4"/>
            @break
    @endswitch
</svg>
