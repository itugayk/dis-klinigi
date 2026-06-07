@props([
    'title',
    'subtitle' => null,
    'crumbs' => [],   // ['Tedaviler' => route(...), 'Aktif' => null]
])

<section class="relative overflow-hidden bg-teal-700">
    <div class="absolute inset-0 opacity-20" style="background-image:radial-gradient(circle at 20% 20%, #34cfc9 0, transparent 45%),radial-gradient(circle at 85% 30%, #ff7a6b 0, transparent 40%);"></div>
    <div class="absolute -right-16 -top-16 h-72 w-72 rounded-full bg-teal-500/40 blur-3xl"></div>

    <div class="container-x relative py-14 sm:py-20">
        @if(! empty($crumbs))
            <nav class="mb-5 flex flex-wrap items-center gap-2 text-sm text-teal-100/80">
                <a href="{{ route('home') }}" class="hover:text-white">Ana Sayfa</a>
                @foreach($crumbs as $label => $url)
                    <span class="text-teal-300/60">/</span>
                    @if($url)
                        <a href="{{ $url }}" class="hover:text-white">{{ $label }}</a>
                    @else
                        <span class="text-white">{{ $label }}</span>
                    @endif
                @endforeach
            </nav>
        @endif

        <h1 class="max-w-3xl text-3xl font-extrabold text-white sm:text-4xl lg:text-5xl">{{ $title }}</h1>
        @if($subtitle)
            <p class="mt-4 max-w-2xl text-lg text-teal-50/90">{{ $subtitle }}</p>
        @endif
    </div>

    <div class="h-6 bg-white" style="border-top-left-radius:2rem;border-top-right-radius:2rem;"></div>
</section>
