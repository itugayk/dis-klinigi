@props(['case'])

<figure class="card reveal overflow-hidden">
    <div
        x-data="{ pos: 50, drag(e){ const r = this.$refs.box.getBoundingClientRect(); const x = (e.touches ? e.touches[0].clientX : e.clientX) - r.left; this.pos = Math.min(100, Math.max(0, (x / r.width) * 100)); } }"
        x-ref="box"
        @mousemove="if($event.buttons===1) drag($event)"
        @touchmove.passive="drag($event)"
        @click="drag($event)"
        class="relative aspect-[4/3] cursor-ew-resize select-none overflow-hidden bg-slate-100"
    >
        {{-- Sonrası (alt katman) --}}
        <img src="{{ $case->after_url }}" alt="{{ $case->title }} - sonrası" class="absolute inset-0 h-full w-full object-cover" draggable="false" loading="lazy">
        <span class="absolute right-3 top-3 rounded-full bg-teal-500/90 px-3 py-1 text-xs font-semibold text-white">Sonrası</span>

        {{-- Öncesi (üst katman, kırpılır) --}}
        <div class="absolute inset-0 overflow-hidden" :style="`width:${pos}%`">
            <img src="{{ $case->before_url }}" alt="{{ $case->title }} - öncesi"
                 class="absolute inset-0 h-full w-full max-w-none object-cover" draggable="false" loading="lazy"
                 :style="`width:${$refs.box ? $refs.box.clientWidth : 0}px`">
            <span class="absolute left-3 top-3 rounded-full bg-slate-900/80 px-3 py-1 text-xs font-semibold text-white">Öncesi</span>
        </div>

        {{-- Tutamak --}}
        <div class="absolute inset-y-0 z-10 flex w-0.5 items-center justify-center bg-white shadow" :style="`left:${pos}%`">
            <span class="absolute flex h-10 w-10 items-center justify-center rounded-full bg-white text-teal-600 shadow-lg ring-1 ring-slate-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l-4 3 4 3M16 9l4 3-4 3"/></svg>
            </span>
        </div>
    </div>

    <figcaption class="flex items-center justify-between gap-3 p-4">
        <div>
            <p class="font-semibold text-slate-900">{{ $case->title }}</p>
            @if($case->treatment)
                <p class="text-xs text-teal-600">{{ $case->treatment->name }}</p>
            @endif
        </div>
        <span class="text-xs text-slate-400">← kaydır →</span>
    </figcaption>
</figure>
