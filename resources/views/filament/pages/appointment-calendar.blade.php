<x-filament-panels::page>
    {{-- Üst kontroller --}}
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold capitalize text-gray-900 dark:text-white">{{ $this->monthLabel }}</h2>
        <div class="flex items-center gap-2">
            <x-filament::button color="gray" size="sm" wire:click="prevMonth" icon="heroicon-m-chevron-left" />
            <x-filament::button color="gray" size="sm" wire:click="today">Bugün</x-filament::button>
            <x-filament::button color="gray" size="sm" wire:click="nextMonth" icon="heroicon-m-chevron-right" />
        </div>
    </div>

    <div class="overflow-hidden rounded-xl ring-1 ring-gray-200 dark:ring-white/10">
        {{-- Gün başlıkları --}}
        <div class="grid grid-cols-7 bg-gray-50 text-center text-xs font-semibold text-gray-500 dark:bg-white/5 dark:text-gray-400">
            @foreach(['Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi','Pazar'] as $d)
                <div class="px-2 py-2.5">{{ $d }}</div>
            @endforeach
        </div>

        {{-- Haftalar --}}
        @foreach($this->weeks as $week)
            <div class="grid grid-cols-7 border-t border-gray-200 dark:border-white/10">
                @foreach($week as $day)
                    <div @class([
                        'min-h-28 border-r border-gray-100 p-1.5 last:border-r-0 dark:border-white/5',
                        'bg-white dark:bg-transparent' => $day['inMonth'],
                        'bg-gray-50/60 dark:bg-white/5' => ! $day['inMonth'],
                    ])>
                        <div class="mb-1 flex justify-end">
                            <span @class([
                                'flex h-6 w-6 items-center justify-center rounded-full text-xs font-semibold',
                                'bg-primary-500 text-white' => $day['isToday'],
                                'text-gray-700 dark:text-gray-300' => $day['inMonth'] && ! $day['isToday'],
                                'text-gray-300 dark:text-gray-600' => ! $day['inMonth'],
                            ])>{{ $day['day'] }}</span>
                        </div>

                        <div class="space-y-1">
                            @foreach($day['items']->take(4) as $apt)
                                <a href="{{ \App\Filament\Resources\AppointmentResource::getUrl('edit', ['record' => $apt]) }}"
                                   @class([
                                       'block truncate rounded-md px-1.5 py-1 text-[11px] font-medium leading-tight transition hover:opacity-80',
                                       'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-200' => $apt->status->value === 'pending',
                                       'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-200' => $apt->status->value === 'confirmed',
                                       'bg-sky-100 text-sky-800 dark:bg-sky-500/20 dark:text-sky-200' => $apt->status->value === 'completed',
                                       'bg-gray-100 text-gray-500 line-through dark:bg-white/10' => in_array($apt->status->value, ['cancelled','no_show']),
                                   ])
                                   title="{{ $apt->patient_name }} · {{ $apt->doctor?->full_name }}">
                                    {{ \Illuminate\Support\Str::of($apt->start_time)->substr(0,5) }} {{ $apt->patient_name }}
                                </a>
                            @endforeach
                            @if($day['items']->count() > 4)
                                <span class="block px-1.5 text-[11px] text-gray-400">+{{ $day['items']->count() - 4 }} daha</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    {{-- Açıklama --}}
    <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">
        <span class="flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-amber-200"></span> Onay bekliyor</span>
        <span class="flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-emerald-200"></span> Onaylandı</span>
        <span class="flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-sky-200"></span> Tamamlandı</span>
        <span class="flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-gray-200"></span> İptal / gelmedi</span>
    </div>
</x-filament-panels::page>
