@props(['treatment'])

<a href="{{ route('treatments.show', $treatment) }}"
   class="card card-hover reveal group flex flex-col p-6">
    <span class="flex h-14 w-14 items-center justify-center rounded-2xl text-white shadow-lg transition-transform duration-300 group-hover:scale-110"
          style="background: linear-gradient(135deg, {{ $treatment->color ?? '#15a3a8' }}, color-mix(in srgb, {{ $treatment->color ?? '#15a3a8' }} 70%, #000));
                 box-shadow: 0 12px 24px -8px {{ $treatment->color ?? '#15a3a8' }}66;">
        <x-site.icon :name="$treatment->icon ?? 'tooth'" class="h-7 w-7" />
    </span>

    <h3 class="mt-5 text-lg font-bold text-slate-900 transition group-hover:text-teal-600">{{ $treatment->name }}</h3>
    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-500">{{ $treatment->excerpt }}</p>

    <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
        @if($treatment->price_from)
            <span class="text-sm text-slate-400">başlayan<br><span class="text-base font-bold text-slate-900">{{ number_format($treatment->price_from, 0, ',', '.') }} ₺</span></span>
        @else
            <span class="text-sm font-medium text-teal-600">Detaylı bilgi</span>
        @endif
        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-teal-50 text-teal-600 transition group-hover:bg-teal-500 group-hover:text-white">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </span>
    </div>
</a>
