@props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
    'align' => 'center',   // center | left
])

<div class="reveal {{ $align === 'center' ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl' }}">
    @if($eyebrow)
        <span class="eyebrow">{{ $eyebrow }}</span>
    @endif
    <h2 class="mt-4 text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $title }}</h2>
    @if($subtitle)
        <p class="mt-4 text-lg leading-relaxed text-slate-500">{{ $subtitle }}</p>
    @endif
</div>
