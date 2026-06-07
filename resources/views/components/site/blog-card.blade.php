@props(['post'])

<article class="card card-hover reveal group flex flex-col overflow-hidden">
    <a href="{{ route('blog.show', $post) }}" class="relative aspect-[16/10] overflow-hidden bg-slate-100">
        @if($post->coverUrl())
            <div class="absolute inset-0 flex items-center justify-center bg-teal-50 text-teal-200"><x-site.icon name="tooth" class="h-14 w-14" /></div>
            <img src="{{ $post->coverUrl() }}" alt="{{ $post->title }}" onerror="this.remove()" class="relative h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
        @else
            <div class="flex h-full w-full items-center justify-center bg-teal-50 text-teal-200"><x-site.icon name="tooth" class="h-14 w-14" /></div>
        @endif
        @if($post->category)
            <span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1 text-xs font-semibold text-teal-700">{{ $post->category->name }}</span>
        @endif
    </a>
    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center gap-3 text-xs text-slate-400">
            <span>{{ optional($post->published_at)->translatedFormat('d M Y') }}</span>
            @if($post->reading_minutes)<span>· {{ $post->reading_minutes }} dk okuma</span>@endif
        </div>
        <h3 class="mt-2 text-lg font-bold leading-snug text-slate-900 transition group-hover:text-teal-600">
            <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
        </h3>
        <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-500">{{ \Illuminate\Support\Str::limit($post->excerpt, 110) }}</p>
        <a href="{{ route('blog.show', $post) }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-teal-600 hover:gap-2.5 transition-all">
            Devamını oku
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </a>
    </div>
</article>
