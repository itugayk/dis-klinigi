<x-layouts.app
    :title="$treatment->name"
    :description="$treatment->excerpt"
    :jsonLd="$jsonLd">

    <x-site.page-hero
        :title="$treatment->name"
        :subtitle="$treatment->excerpt"
        :crumbs="['Tedaviler' => route('treatments.index'), $treatment->name => null]" />

    {{-- ===================================================== İÇERİK --}}
    <section class="container-x py-16 sm:py-24">
        <div class="grid gap-10 lg:grid-cols-3">

            {{-- ============================ ANA İÇERİK --}}
            <div class="lg:col-span-2">
                {{-- Görsel --}}
                <div class="reveal relative mb-10 overflow-hidden rounded-4xl bg-gradient-to-br from-teal-400 to-teal-600 shadow-xl shadow-teal-500/20">
                    <div class="absolute inset-0 flex items-center justify-center text-white/20">
                        <x-site.icon :name="$treatment->icon ?? 'tooth'" class="h-32 w-32" />
                    </div>
                    @if($treatment->image_url)
                        <img src="{{ $treatment->image_url }}" alt="{{ $treatment->name }}" onerror="this.remove()"
                             class="relative aspect-[16/9] w-full object-cover" loading="lazy">
                    @endif
                </div>

                {{-- Açıklama --}}
                <div class="reveal prose-clinic">
                    {!! $treatment->description !!}
                </div>

                {{-- Faydalar --}}
                @if(! empty($treatment->benefits))
                    <div class="reveal mt-12">
                        <h2 class="text-2xl font-bold text-slate-900">Tedavinin faydaları</h2>
                        <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                            @foreach($treatment->benefits as $benefit)
                                <li class="flex items-start gap-3 rounded-2xl bg-teal-50/60 p-4 ring-1 ring-teal-100">
                                    <span class="mt-0.5 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-teal-500 text-white">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    </span>
                                    <span class="text-sm font-medium leading-relaxed text-slate-700">{{ $benefit }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- ============================ KENAR ÇUBUĞU --}}
            <aside class="lg:col-span-1">
                <div class="reveal card sticky top-24 p-6">
                    <div class="flex items-center gap-3">
                        <span class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl text-white shadow-lg"
                              style="background: linear-gradient(135deg, {{ $treatment->color ?? '#15a3a8' }}, color-mix(in srgb, {{ $treatment->color ?? '#15a3a8' }} 70%, #000));">
                            <x-site.icon :name="$treatment->icon ?? 'tooth'" class="h-6 w-6" />
                        </span>
                        <h2 class="text-lg font-bold text-slate-900">{{ $treatment->name }}</h2>
                    </div>

                    {{-- Fiyat & Süre --}}
                    <div class="mt-6 space-y-3">
                        @if($treatment->price_from)
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <span class="text-sm text-slate-500">Başlayan fiyat</span>
                                <span class="text-lg font-bold text-slate-900">{{ number_format($treatment->price_from, 0, ',', '.') }} ₺</span>
                            </div>
                        @endif
                        @if($treatment->duration_minutes)
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <span class="flex items-center gap-2 text-sm text-slate-500">
                                    <x-site.icon name="clock" class="h-4 w-4 text-teal-500" />
                                    Tahmini süre
                                </span>
                                <span class="text-sm font-semibold text-slate-900">~{{ $treatment->duration_minutes }} dk</span>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('booking', ['treatment' => $treatment->id]) }}" class="btn-primary mt-6 w-full">
                        <x-site.icon name="clock" class="h-5 w-5" />
                        Bu tedavi için randevu al
                    </a>

                    {{-- İlgili hekimler --}}
                    @if($treatment->doctors->isNotEmpty())
                        <div class="mt-8 border-t border-slate-100 pt-6">
                            <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-400">Bu tedaviyi uygulayan hekimler</h3>
                            <ul class="mt-4 space-y-3">
                                @foreach($treatment->doctors as $doctor)
                                    <li>
                                        <a href="{{ route('doctors.show', $doctor) }}" class="group flex items-center gap-3 rounded-2xl p-2 transition hover:bg-teal-50">
                                            <span class="relative flex h-11 w-11 flex-shrink-0 items-center justify-center overflow-hidden rounded-full bg-teal-100 text-teal-300">
                                                <x-site.icon name="tooth" class="h-6 w-6" />
                                                @if($doctor->photo_url)
                                                    <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->full_name }}" onerror="this.remove()"
                                                         class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                                                @endif
                                            </span>
                                            <span class="min-w-0">
                                                <span class="block truncate text-sm font-semibold text-slate-900 transition group-hover:text-teal-600">{{ $doctor->full_name }}</span>
                                                <span class="block truncate text-xs text-slate-500">{{ $doctor->specialty }}</span>
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </section>

    {{-- ===================================================== İLGİLİ TEDAVİLER --}}
    @if($related->isNotEmpty())
        <section class="bg-slate-50 py-16 sm:py-24">
            <div class="container-x">
                <x-site.section-heading
                    eyebrow="Keşfetmeye devam edin"
                    title="İlgili tedaviler"
                    subtitle="İhtiyaçlarınıza uygun olabilecek diğer tedavilerimize göz atın." />

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($related as $relatedTreatment)
                        <x-site.treatment-card :treatment="$relatedTreatment" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
