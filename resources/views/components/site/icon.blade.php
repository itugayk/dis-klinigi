@props(['name' => 'tooth', 'class' => 'h-6 w-6'])

@php
    $paths = [
        // genel diş
        'tooth'     => '<path d="M12 2c-1.5 0-2.5.6-3.6 1C7.2 3.4 6 3.5 5 3.2 3.4 2.7 2 4 2 6.3c0 2 .5 3.3.9 5 .3 1.3.4 3 .7 4.6.3 1.7.7 4 1.7 5.4.5.7 1.4.9 2 .2.6-.8.8-2.3 1-3.6.2-1.4.5-2.6 1.7-2.6s1.5 1.2 1.7 2.6c.2 1.3.4 2.8 1 3.6.6.7 1.5.5 2-.2 1-1.4 1.4-3.7 1.7-5.4.3-1.6.4-3.3.7-4.6.4-1.7.9-3 .9-5C22 4 20.6 2.7 19 3.2c-1 .3-2.2.2-3.4-.2C14.5 2.6 13.5 2 12 2z"/>',
        // implant — vida
        'implant'   => '<path d="M9 2h6M8 5h8M12 5v3M9 8h6l-.5 4h-5L9 8zm.6 4h4.8l-.4 3h-4l-.4-3zm.5 3h3.8L17 22l-2-2-1.5 1.5L12 20l-1.5 1.5L9 20l-2 2 2-7z"/>',
        // ortodonti — tel/braces
        'ortodonti' => '<path d="M3 9h18M3 15h18M7 9v6M12 9v6M17 9v6"/><circle cx="7" cy="12" r="1.4"/><circle cx="12" cy="12" r="1.4"/><circle cx="17" cy="12" r="1.4"/>',
        // estetik — parıltı
        'estetik'   => '<path d="M12 3l1.8 4.9L18.7 9l-4.9 1.8L12 16l-1.8-5.2L5.3 9l4.9-1.1L12 3zM19 14l.7 1.9 1.9.7-1.9.7L19 20l-.7-1.7-1.9-.7 1.9-.7L19 14zM5 14l.6 1.6L7 16.2l-1.4.6L5 18l-.6-1.2L3 16.2l1.4-.6L5 14z"/>',
        // beyazlatma — fırça/güneş
        'beyazlatma'=> '<circle cx="12" cy="12" r="4.2"/><path d="M12 2v2.5M12 19.5V22M22 12h-2.5M4.5 12H2M19 5l-1.8 1.8M6.8 17.2 5 19M19 19l-1.8-1.8M6.8 6.8 5 5"/>',
        // kanal — kök
        'kanal'     => '<path d="M8 3h8M9 6h6l-.6 5c-.2 1.6-.4 3.4-1 5-.4 1.1-.8 4-2.4 4-.6 0-.9-2.1-1.1-3.2C9.6 14.5 9.4 11 9 6zm3 0v14"/>',
        // çocuk
        'cocuk'     => '<circle cx="12" cy="7" r="3.2"/><path d="M5.5 21a6.5 6.5 0 0113 0M9.5 6.5h.01M14.5 6.5h.01M10 9c.6.6 3.4.6 4 0"/>',
        // güven / kalkan
        'shield'    => '<path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/><path d="M9 12l2 2 4-4"/>',
        'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'sparkle'   => '<path d="M12 3l1.8 4.9L18.7 9l-4.9 1.8L12 16l-1.8-5.2L5.3 9l4.9-1.1L12 3z"/>',
        'microscope'=> '<path d="M6 18h12M9 18V9a3 3 0 016 0M12 6V3M9 21h9a3 3 0 003-3c0-3-2-5-5-5"/>',
        'heart'     => '<path d="M12 21s-7-4.5-9.5-9C1 9 2.5 5.5 6 5.5c2 0 3 1.2 4 2.5 1-1.3 2-2.5 4-2.5 3.5 0 5 3.5 3.5 6.5C19 16.5 12 21 12 21z"/>',
    ];
    $d = $paths[$name] ?? $paths['tooth'];
@endphp

<svg class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
    {!! $d !!}
</svg>
