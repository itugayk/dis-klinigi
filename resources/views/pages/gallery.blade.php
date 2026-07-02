<x-layouts.app
    title="Galeri — Tedavi Sonuçlarımız"
    description="Mardent Ağız ve Diş Sağlığı Polikliniği'nde gerçekleştirdiğimiz tedavilerin gerçek öncesi ve sonrası sonuçları. Görseli kaydırarak değişimi keşfedin.">

    <x-site.page-hero
        title="Galeri"
        subtitle="Gerçek hastalarımızın tedavi sonuçları. Görseli kaydırarak öncesi ve sonrası arasındaki değişimi kendiniz keşfedin."
        :crumbs="['Galeri' => null]" />

    <section class="container-x py-16 sm:py-24" x-data="{ filter: 'all' }">
        <x-site.section-heading
            eyebrow="Sonuçlarımız"
            title="Öncesi & Sonrası"
            subtitle="Tedavi türüne göre filtreleyerek ilgilendiğiniz alandaki dönüşümleri inceleyebilirsiniz." />

        @if($cases->isNotEmpty())
            {{-- Filtre pilleri --}}
            <div class="reveal mt-10 flex flex-wrap items-center justify-center gap-3">
                <button type="button"
                    @click="filter = 'all'"
                    :class="filter === 'all' ? 'bg-teal-500 text-white shadow-lg shadow-teal-500/25' : 'bg-white text-teal-700 ring-1 ring-teal-200 hover:bg-teal-50'"
                    class="rounded-full px-5 py-2.5 text-sm font-semibold transition-all duration-200">
                    Tümü
                </button>
                @foreach($treatments as $treatment)
                    <button type="button"
                        @click="filter = '{{ $treatment->id }}'"
                        :class="filter === '{{ $treatment->id }}' ? 'bg-teal-500 text-white shadow-lg shadow-teal-500/25' : 'bg-white text-teal-700 ring-1 ring-teal-200 hover:bg-teal-50'"
                        class="rounded-full px-5 py-2.5 text-sm font-semibold transition-all duration-200">
                        {{ $treatment->name }}
                    </button>
                @endforeach
            </div>

            {{-- Galeri ızgarası --}}
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($cases as $case)
                    <div x-show="filter === 'all' || filter === '{{ $case->treatment_id ?? 'none' }}'" x-cloak>
                        <x-site.before-after :case="$case" />
                    </div>
                @endforeach
            </div>
        @else
            {{-- Boş durum --}}
            <div class="reveal mt-12 rounded-3xl bg-slate-50 px-6 py-16 text-center ring-1 ring-slate-100">
                <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-teal-100 text-teal-600">
                    <x-site.icon name="sparkle" class="h-8 w-8" />
                </span>
                <h3 class="mt-5 text-lg font-bold text-slate-900">Galeri yakında güncellenecek</h3>
                <p class="mt-2 text-sm text-slate-500">Şu anda gösterilecek bir sonuç bulunmuyor. Tedavi sonuçlarımız hakkında bilgi almak için bizimle iletişime geçebilirsiniz.</p>
            </div>
        @endif
    </section>

    {{-- ===================================================== CTA BANDI --}}
    <section class="container-x pb-16 sm:pb-24">
        <div class="reveal relative overflow-hidden rounded-4xl bg-gradient-to-br from-teal-600 to-teal-800 px-6 py-14 text-center shadow-2xl shadow-teal-600/25 sm:px-12 sm:py-20">
            <div class="absolute -left-16 -top-16 h-64 w-64 rounded-full bg-teal-400/30 blur-3xl"></div>
            <div class="absolute -bottom-20 -right-10 h-72 w-72 rounded-full bg-coral-400/25 blur-3xl"></div>

            <div class="relative mx-auto max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-teal-50 ring-1 ring-white/20">Randevu</span>
                <h2 class="mt-5 text-3xl font-extrabold text-white sm:text-4xl">Sizin gülüşünüz de bir sonraki olabilir</h2>
                <p class="mt-4 text-lg text-teal-50/90">Hayalinizdeki gülüşe ulaşmak için uzman hekimlerimizle ücretsiz bir değerlendirme randevusu oluşturun.</p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('booking') }}" class="btn-accent text-base">
                        <x-site.icon name="clock" class="h-5 w-5" />
                        Online Randevu Al
                    </a>
                    <a href="{{ route('treatments.index') }}" class="btn-outline-white text-base">Tedavileri Keşfet</a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
