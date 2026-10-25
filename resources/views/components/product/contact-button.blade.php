@props(['product', 'class' => 'btn-primary btn-lg', 'label' => 'Solicitar una demostración'])
@php
    $contact = \App\Support\SiteContact::fromConfig();
    $whatsapp = $contact->whatsappUrl($product->inquiryMessage());
    $mailto = $contact->mailtoUrl('Consulta por '.$product->name);
@endphp
{{-- Un solo botón: WhatsApp si está configurado; si no, correo; si no, la página de contacto. Nunca un enlace roto. --}}
@if ($whatsapp)
    <a class="btn {{ $class }}" href="{{ $whatsapp }}" rel="noopener noreferrer"><x-icon name="chat" :size="20" /> {{ $label }}</a>
@elseif ($mailto)
    <a class="btn {{ $class }}" href="{{ $mailto }}"><x-icon name="chat" :size="20" /> Consultar por correo</a>
@else
    <a class="btn {{ $class }}" href="{{ route('contact') }}"><x-icon name="chat" :size="20" /> Cómo contactarme</a>
@endif
