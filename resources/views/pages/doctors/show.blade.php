<x-layouts.app
    :title="$doctor->full_name"
    :description="$doctor->specialty">

    <x-site.page-hero
        :title="$doctor->full_name"
        :subtitle="$doctor->specialty"
        :crumbs="['Hekimler' => route('doctors.index'), $doctor->full_name => null]" />

    {{-- ===================================================== İÇERİK --}}
    <section class="container-x py-16 sm:py-24">
        <div class="grid gap-10 lg:grid-cols-3">

            {{-- ============================ KENAR ÇUBUĞU (PROFİL) --}}
            <aside class="lg:col-span-1">
                <div class="reveal card sticky top-24 overflow-hidden">
                    {{-- Fotoğraf --}}
                    <div class="relative aspect-[4/5] overflow-hidden bg-gradient-to-br from-teal-400 to-teal-600">
                        <div class="absolute inset-0 flex items-center justify-center text-white/25">
                            <x-site.icon name="tooth" class="h-28 w-28" />
                        </div>
                        @if($doctor->photo_url)
                            <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->full_name }}" onerror="this.remove()"
                                 class="relative h-full w-full object-cover" loading="lazy">
                        @endif
                    </div>

                    <div class="p-6">
                        <h2 class="text-xl font-bold text-slate-900">{{ $doctor->full_name }}</h2>
                        <span class="mt-3 inline-flex items-center rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-700 ring-1 ring-teal-100">{{ $doctor->specialty }}</span>

                        @if($doctor->experience_years)
                            <p class="mt-4 flex items-center gap-2 text-sm text-slate-600">
                                <span class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-teal-100 text-teal-600">
                                    <x-site.icon name="shield" class="h-5 w-5" />
                                </span>
                                <span><span class="font-semibold text-slate-900">{{ $doctor->experience_years }}</span> yıl deneyim</span>
                            </p>
                        @endif

                        {{-- İletişim --}}
                        @if($doctor->phone || $doctor->email)
                            <div class="mt-5 space-y-2 border-t border-slate-100 pt-5">
                                @if($doctor->phone)
                                    <a href="tel:{{ $doctor->phone }}" class="flex items-center gap-3 text-sm text-slate-600 transition hover:text-teal-600">
                                        <span class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                        </span>
                                        {{ $doctor->phone }}
                                    </a>
                                @endif
                                @if($doctor->email)
                                    <a href="mailto:{{ $doctor->email }}" class="flex items-center gap-3 text-sm text-slate-600 transition hover:text-teal-600">
                                        <span class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                        </span>
                                        <span class="truncate">{{ $doctor->email }}</span>
                                    </a>
                                @endif
                            </div>
                        @endif

                        @if($doctor->accepts_appointments)
                            <a href="{{ route('booking', ['doctor' => $doctor->id]) }}" class="btn-primary mt-6 w-full">
                                <x-site.icon name="clock" class="h-5 w-5" />
                                Randevu Al
                            </a>
                        @endif
                    </div>
                </div>
            </aside>

            {{-- ============================ ANA İÇERİK --}}
            <div class="space-y-12 lg:col-span-2">
                {{-- Hakkında --}}
                @if($doctor->bio)
                    <div class="reveal">
                        <h2 class="text-2xl font-bold text-slate-900">Hakkında</h2>
                        <div class="prose-clinic mt-4">
                            <p>{!! nl2br(e($doctor->bio)) !!}</p>
                        </div>
                    </div>
                @endif

                {{-- Uzmanlık alanları --}}
                @if(! empty($doctor->specialties) || $doctor->treatments->isNotEmpty())
                    <div class="reveal">
                        <h2 class="text-2xl font-bold text-slate-900">Uzmanlık alanları</h2>

                        @if(! empty($doctor->specialties))
                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach($doctor->specialties as $specialty)
                                    <span class="inline-flex items-center gap-2 rounded-full bg-teal-50 px-4 py-2 text-sm font-medium text-teal-700 ring-1 ring-teal-100">
                                        <x-site.icon name="sparkle" class="h-4 w-4" />
                                        {{ $specialty }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        @if($doctor->treatments->isNotEmpty())
                            <div class="mt-6">
                                <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-400">Uyguladığı tedaviler</h3>
                                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                    @foreach($doctor->treatments as $treatment)
                                        <a href="{{ route('treatments.show', $treatment) }}" class="group flex items-center gap-3 rounded-2xl bg-white p-3 ring-1 ring-slate-100 transition hover:ring-teal-200 hover:shadow-sm">
                                            <span class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl text-white shadow"
                                                  style="background: linear-gradient(135deg, {{ $treatment->color ?? '#15a3a8' }}, color-mix(in srgb, {{ $treatment->color ?? '#15a3a8' }} 70%, #000));">
                                                <x-site.icon :name="$treatment->icon ?? 'tooth'" class="h-5 w-5" />
                                            </span>
                                            <span class="min-w-0">
                                                <span class="block truncate text-sm font-semibold text-slate-900 transition group-hover:text-teal-600">{{ $treatment->name }}</span>
                                                @if($treatment->excerpt)
                                                    <span class="block truncate text-xs text-slate-500">{{ $treatment->excerpt }}</span>
                                                @endif
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Haftalık çalışma takvimi --}}
                @php
                    $schedulesByDay = $doctor->schedules->groupBy('day_of_week');
                @endphp
                @if($doctor->schedules->isNotEmpty())
                    <div class="reveal">
                        <h2 class="text-2xl font-bold text-slate-900">Haftalık Çalışma Takvimi</h2>
                        <div class="card mt-5 divide-y divide-slate-100 overflow-hidden">
                            @foreach(\App\Models\DoctorSchedule::DAYS as $dayNum => $dayName)
                                @php
                                    $daySchedules = $schedulesByDay->get($dayNum);
                                @endphp
                                <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 {{ $daySchedules ? 'bg-white' : 'bg-slate-50/60' }}">
                                    <span class="flex items-center gap-3 text-sm font-semibold {{ $daySchedules ? 'text-slate-900' : 'text-slate-400' }}">
                                        <span class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl {{ $daySchedules ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-400' }}">
                                            <x-site.icon name="clock" class="h-5 w-5" />
                                        </span>
                                        {{ $dayName }}
                                    </span>

                                    @if($daySchedules)
                                        <div class="flex flex-wrap items-center justify-end gap-2 text-sm">
                                            @foreach($daySchedules as $schedule)
                                                <span class="inline-flex items-center rounded-lg bg-teal-50 px-3 py-1 font-semibold text-teal-700 ring-1 ring-teal-100">
                                                    {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                                                </span>
                                                @if($schedule->break_start && $schedule->break_end)
                                                    <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1 text-xs font-medium text-slate-500">
                                                        Mola {{ substr($schedule->break_start, 0, 5) }} - {{ substr($schedule->break_end, 0, 5) }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-sm font-medium text-slate-400">Kapalı</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
