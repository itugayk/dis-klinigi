@props(['testimonial'])

<figure class="card reveal flex h-full flex-col p-6">
    <div class="flex items-center gap-1 text-coral-500">
        @for($i = 1; $i <= 5; $i++)
            <svg class="h-4 w-4 {{ $i <= $testimonial->rating ? 'text-coral-500' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.05 2.93c.3-.92 1.6-.92 1.9 0l1.36 4.19a1 1 0 00.95.69h4.4c.97 0 1.37 1.24.59 1.81l-3.56 2.59a1 1 0 00-.36 1.12l1.36 4.19c.3.92-.76 1.69-1.54 1.12l-3.56-2.59a1 1 0 00-1.18 0l-3.56 2.59c-.78.57-1.84-.2-1.54-1.12l1.36-4.19a1 1 0 00-.36-1.12L1.4 9.62c-.78-.57-.38-1.81.59-1.81h4.4a1 1 0 00.95-.69l1.36-4.19z"/></svg>
        @endfor
    </div>
    <blockquote class="mt-4 flex-1 text-slate-600 leading-relaxed">“{{ $testimonial->body }}”</blockquote>
    <figcaption class="mt-5 flex items-center gap-3 border-t border-slate-100 pt-4">
        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-teal-100 font-bold text-teal-700">
            {{ \Illuminate\Support\Str::of($testimonial->patient_name)->explode(' ')->map(fn($w) => mb_substr($w,0,1))->take(2)->implode('') }}
        </span>
        <div>
            <p class="text-sm font-semibold text-slate-900">{{ $testimonial->patient_name }}</p>
            @if($testimonial->treatment_label)
                <p class="text-xs text-slate-400">{{ $testimonial->treatment_label }}</p>
            @endif
        </div>
    </figcaption>
</figure>
