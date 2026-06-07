<x-layouts.app
    :title="$post->title"
    :description="$post->excerpt"
    :jsonLd="$jsonLd">

    <x-site.page-hero
        :title="$post->title"
        :crumbs="['Blog' => route('blog.index'), $post->title => null]" />

    <article class="container-x py-16 sm:py-24">
        <div class="mx-auto max-w-3xl">
            {{-- Meta satırı --}}
            <div class="reveal flex flex-wrap items-center gap-3 text-sm text-slate-400">
                @if($post->category)
                    <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-700 ring-1 ring-teal-100">{{ $post->category->name }}</span>
                @endif
                @if($post->published_at)
                    <span>{{ $post->published_at->translatedFormat('d F Y') }}</span>
                @endif
                @if($post->reading_minutes)
                    <span>· {{ $post->reading_minutes }} dk okuma</span>
                @endif
            </div>

            {{-- Kapak görseli --}}
            @if($post->coverUrl())
                <div class="reveal mt-8 overflow-hidden rounded-3xl bg-gradient-to-br from-teal-400 to-teal-600 aspect-[16/9]">
                    <img src="{{ $post->coverUrl() }}" alt="{{ $post->title }}" onerror="this.remove()"
                         class="h-full w-full object-cover" loading="lazy">
                </div>
            @endif

            {{-- Yazı gövdesi --}}
            <div class="reveal prose-clinic mt-10 max-w-3xl">
                {!! $post->body !!}
            </div>

            {{-- Yazar kutusu --}}
            @if($post->author)
                <div class="reveal mt-12 flex items-center gap-4 rounded-3xl bg-slate-50 p-6 ring-1 ring-slate-100">
                    <span class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-teal-100 text-lg font-bold text-teal-700">
                        {{ \Illuminate\Support\Str::of($post->author)->substr(0, 1)->upper() }}
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Yazar</p>
                        <p class="font-semibold text-slate-900">{{ $post->author }}</p>
                    </div>
                </div>
            @endif

            {{-- Tüm yazılar bağlantısı --}}
            <div class="mt-10">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-teal-600 transition hover:gap-3">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    Tüm yazılar
                </a>
            </div>
        </div>
    </article>

    {{-- ===================================================== İLGİLİ YAZILAR --}}
    @if($related->isNotEmpty())
        <section class="bg-slate-50 py-16 sm:py-24">
            <div class="container-x">
                <x-site.section-heading
                    align="left"
                    eyebrow="Okumaya devam edin"
                    title="İlgili yazılar"
                    subtitle="İlginizi çekebilecek diğer içeriklerimize göz atın." />

                <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($related as $relatedPost)
                        <x-site.blog-card :post="$relatedPost" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ===================================================== CTA BANDI --}}
    <section class="container-x py-16 sm:py-24">
        <div class="reveal relative overflow-hidden rounded-4xl bg-gradient-to-br from-teal-600 to-teal-800 px-6 py-14 text-center shadow-2xl shadow-teal-600/25 sm:px-12 sm:py-16">
            <div class="absolute -left-16 -top-16 h-64 w-64 rounded-full bg-teal-400/30 blur-3xl"></div>
            <div class="absolute -bottom-20 -right-10 h-72 w-72 rounded-full bg-coral-400/25 blur-3xl"></div>

            <div class="relative mx-auto max-w-2xl">
                <h2 class="text-2xl font-extrabold text-white sm:text-3xl">Sağlığınızla ilgili sorularınız mı var?</h2>
                <p class="mt-3 text-lg text-teal-50/90">Uzman hekimlerimizle bir randevu oluşturun, size özel değerlendirme yapalım.</p>
                <div class="mt-7 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('booking') }}" class="btn-accent text-base">
                        <x-site.icon name="clock" class="h-5 w-5" />
                        Online Randevu Al
                    </a>
                    <a href="{{ route('contact') }}" class="btn-outline-white text-base">İletişime Geçin</a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
