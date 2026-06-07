<x-layouts.app
    title="Blog"
    description="Ağız ve diş sağlığı, estetik diş hekimliği ve tedavi süreçleri hakkında uzman hekimlerimizden güncel içerikler.">

    <x-site.page-hero
        title="Blog & Sağlık Rehberi"
        subtitle="Ağız ve diş sağlığınız için uzman hekimlerimizden güncel bilgiler, ipuçları ve tedavi rehberleri."
        :crumbs="['Blog' => null]" />

    <section class="container-x py-16 sm:py-24">
        {{-- Kategori filtreleri --}}
        @if($categories->isNotEmpty())
            <div class="reveal flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('blog.index') }}"
                   class="rounded-full px-5 py-2.5 text-sm font-semibold transition-all duration-200 {{ ! $active ? 'bg-teal-500 text-white shadow-lg shadow-teal-500/25' : 'bg-white text-teal-700 ring-1 ring-teal-200 hover:bg-teal-50' }}">
                    Tümü
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['kategori' => $cat->slug]) }}"
                       class="rounded-full px-5 py-2.5 text-sm font-semibold transition-all duration-200 {{ $active === $cat->slug ? 'bg-teal-500 text-white shadow-lg shadow-teal-500/25' : 'bg-white text-teal-700 ring-1 ring-teal-200 hover:bg-teal-50' }}">
                        {{ $cat->name }} ({{ $cat->posts_count }})
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Yazı ızgarası --}}
        @if($posts->isNotEmpty())
            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                    <x-site.blog-card :post="$post" />
                @endforeach
            </div>

            {{-- Sayfalama --}}
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            {{-- Boş durum --}}
            <div class="reveal mt-12 rounded-3xl bg-slate-50 px-6 py-16 text-center ring-1 ring-slate-100">
                <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-teal-100 text-teal-600">
                    <x-site.icon name="tooth" class="h-8 w-8" />
                </span>
                <h3 class="mt-5 text-lg font-bold text-slate-900">Henüz yazı bulunmuyor</h3>
                <p class="mt-2 text-sm text-slate-500">Bu kategoride şu anda görüntülenecek bir yazı yok. Yakında yeni içeriklerle burada olacağız.</p>
                @if($active)
                    <a href="{{ route('blog.index') }}" class="btn-ghost mt-6">Tüm yazıları gör</a>
                @endif
            </div>
        @endif
    </section>
</x-layouts.app>
