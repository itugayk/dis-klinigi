@props(['doctor'])

<div class="card card-hover reveal group overflow-hidden">
    <div class="relative aspect-[4/5] overflow-hidden bg-teal-50">
        @if($doctor->photo_url)
            <div class="absolute inset-0 flex items-center justify-center text-teal-200"><x-site.icon name="tooth" class="h-20 w-20" /></div>
            <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->full_name }}" onerror="this.remove()"
                 class="relative h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
        @else
            <div class="flex h-full w-full items-center justify-center text-teal-200">
                <x-site.icon name="tooth" class="h-20 w-20" />
            </div>
        @endif
        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-900/80 to-transparent p-4">
            <span class="inline-block rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-teal-700">{{ $doctor->specialty }}</span>
        </div>
    </div>

    <div class="p-5">
        <h3 class="text-lg font-bold text-slate-900">{{ $doctor->full_name }}</h3>
        @if($doctor->experience_years)
            <p class="mt-1 text-sm text-slate-500">{{ $doctor->experience_years }} yıl deneyim</p>
        @endif
        <div class="mt-4 flex items-center gap-2">
            <a href="{{ route('doctors.show', $doctor) }}" class="flex-1 rounded-full bg-slate-100 px-4 py-2 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Profil</a>
            @if($doctor->accepts_appointments)
                <a href="{{ route('booking', ['doctor' => $doctor->id]) }}" class="flex-1 rounded-full bg-teal-500 px-4 py-2 text-center text-sm font-semibold text-white transition hover:bg-teal-600">Randevu</a>
            @endif
        </div>
    </div>
</div>
