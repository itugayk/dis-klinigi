@php
    $steps = [1 => 'Tedavi', 2 => 'Hekim', 3 => 'Tarih', 4 => 'Saat', 5 => 'Bilgiler'];
@endphp

<div>
    <x-site.page-hero
        title="Online Randevu"
        subtitle="Birkaç adımda kolayca randevunuzu oluşturun. Onay için kliniğimiz sizinle iletişime geçecektir."
        :crumbs="['Randevu' => null]" />

    <section class="container-x -mt-2 py-12">
        <div class="mx-auto max-w-4xl">

            {{-- Adım göstergesi --}}
            @if($step <= 5)
            <ol class="mb-10 flex items-center justify-between gap-1">
                @foreach($steps as $i => $label)
                    <li class="flex flex-1 items-center {{ $i < count($steps) ? '' : 'flex-none' }}">
                        <button type="button" wire:click="goToStep({{ $i }})"
                            @class([
                                'flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full text-sm font-bold transition',
                                'bg-teal-500 text-white shadow-lg shadow-teal-500/30' => $step >= $i,
                                'bg-slate-100 text-slate-400' => $step < $i,
                                'cursor-pointer' => $i < $step,
                                'cursor-default' => $i >= $step,
                            ])>
                            @if($step > $i)
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            @else
                                {{ $i }}
                            @endif
                        </button>
                        <span class="ml-2 hidden text-sm font-medium sm:block {{ $step >= $i ? 'text-slate-900' : 'text-slate-400' }}">{{ $label }}</span>
                        @if($i < count($steps))
                            <span class="mx-2 h-0.5 flex-1 rounded {{ $step > $i ? 'bg-teal-400' : 'bg-slate-100' }}"></span>
                        @endif
                    </li>
                @endforeach
            </ol>
            @endif

            <div class="card relative p-6 sm:p-8" wire:loading.class="opacity-60">
                <div wire:loading.flex class="absolute inset-0 z-10 hidden items-center justify-center rounded-3xl bg-white/60">
                    <svg class="h-8 w-8 animate-spin text-teal-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"/></svg>
                </div>

                {{-- ====================================== ADIM 1: TEDAVİ --}}
                @if($step === 1)
                    <h2 class="text-xl font-bold text-slate-900">Hangi tedavi için geliyorsunuz?</h2>
                    <p class="mt-1 text-sm text-slate-500">Emin değilseniz "Genel muayene" seçebilirsiniz.</p>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach($this->treatments as $t)
                            <button type="button" wire:click="selectTreatment({{ $t->id }})"
                                class="group flex items-center gap-4 rounded-2xl border-2 p-4 text-left transition {{ $treatmentId === $t->id ? 'border-teal-500 bg-teal-50' : 'border-slate-100 hover:border-teal-200 hover:bg-slate-50' }}">
                                <span class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl text-white" style="background:{{ $t->color ?? '#15a3a8' }}">
                                    <x-site.icon :name="$t->icon ?? 'tooth'" class="h-6 w-6" />
                                </span>
                                <span class="min-w-0">
                                    <span class="block font-semibold text-slate-900">{{ $t->name }}</span>
                                    <span class="block truncate text-xs text-slate-400">{{ $t->excerpt }}</span>
                                </span>
                            </button>
                        @endforeach
                    </div>

                    <button type="button" wire:click="skipTreatment" class="mt-5 text-sm font-medium text-teal-600 hover:text-teal-700">
                        → Genel muayene / Henüz emin değilim
                    </button>
                @endif

                {{-- ====================================== ADIM 2: HEKİM --}}
                @if($step === 2)
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-900">Hekim seçin</h2>
                        <button wire:click="goToStep(1)" class="text-sm text-slate-400 hover:text-slate-600">← Geri</button>
                    </div>
                    @if($this->selectedTreatment)
                        <p class="mt-1 text-sm text-slate-500">{{ $this->selectedTreatment->name }} için uygun hekimler.</p>
                    @endif

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        @forelse($this->doctors as $d)
                            <button type="button" wire:click="selectDoctor({{ $d->id }})"
                                class="flex items-center gap-4 rounded-2xl border-2 p-4 text-left transition {{ $doctorId === $d->id ? 'border-teal-500 bg-teal-50' : 'border-slate-100 hover:border-teal-200 hover:bg-slate-50' }}">
                                <span class="relative flex h-14 w-14 flex-shrink-0 items-center justify-center overflow-hidden rounded-full bg-teal-100 text-teal-600">
                                    @if($d->photo_url)
                                        <img src="{{ $d->photo_url }}" alt="{{ $d->full_name }}" onerror="this.remove()" class="h-full w-full object-cover">
                                    @else
                                        <x-site.icon name="tooth" class="h-7 w-7" />
                                    @endif
                                </span>
                                <span>
                                    <span class="block font-semibold text-slate-900">{{ $d->full_name }}</span>
                                    <span class="block text-xs text-teal-600">{{ $d->specialty }}</span>
                                </span>
                            </button>
                        @empty
                            <p class="col-span-full rounded-2xl bg-amber-50 p-4 text-sm text-amber-700">Bu tedavi için şu an uygun hekim bulunmuyor. Lütfen başka bir tedavi seçin veya bizi arayın.</p>
                        @endforelse
                    </div>
                @endif

                {{-- ====================================== ADIM 3: TARİH --}}
                @if($step === 3)
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-900">Tarih seçin</h2>
                        <button wire:click="goToStep(2)" class="text-sm text-slate-400 hover:text-slate-600">← Geri</button>
                    </div>
                    <p class="mt-1 text-sm text-slate-500">{{ $this->selectedDoctor?->full_name }} için müsait günler vurgulanmıştır.</p>

                    <div class="mt-6 rounded-2xl border border-slate-100 p-4 sm:p-6">
                        <div class="mb-4 flex items-center justify-between">
                            <button wire:click="prevMonth" @disabled(! $this->canGoPrevMonth)
                                class="flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 disabled:opacity-30">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                            </button>
                            <span class="font-display text-lg font-bold capitalize text-slate-900">{{ $this->monthLabel }}</span>
                            <button wire:click="nextMonth" @disabled(! $this->canGoNextMonth)
                                class="flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 disabled:opacity-30">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-7 gap-1 text-center text-xs font-semibold text-slate-400">
                            @foreach(['Pzt','Sal','Çar','Per','Cum','Cmt','Paz'] as $d)<div class="py-2">{{ $d }}</div>@endforeach
                        </div>
                        <div class="mt-1 grid grid-cols-7 gap-1.5">
                            @foreach($this->calendar as $day)
                                @if($day['bookable'])
                                    <button type="button" wire:click="selectDate('{{ $day['date'] }}')"
                                        class="aspect-square rounded-xl text-sm font-semibold transition {{ $date === $day['date'] ? 'bg-teal-500 text-white shadow-lg shadow-teal-500/30' : 'bg-teal-50 text-teal-700 hover:bg-teal-100' }}">
                                        {{ $day['day'] }}
                                    </button>
                                @else
                                    <div @class([
                                        'flex aspect-square items-center justify-center rounded-xl text-sm',
                                        'text-slate-300' => $day['inMonth'],
                                        'text-slate-200' => ! $day['inMonth'],
                                    ])>{{ $day['day'] }}</div>
                                @endif
                            @endforeach
                        </div>

                        <p class="mt-4 flex items-center gap-2 text-xs text-slate-400">
                            <span class="inline-block h-3 w-3 rounded bg-teal-50 ring-1 ring-teal-200"></span> Müsait gün
                        </p>
                    </div>

                    @if(empty($bookableDates))
                        <p class="mt-4 rounded-2xl bg-amber-50 p-4 text-sm text-amber-700">Önümüzdeki günlerde uygun gün bulunamadı. Lütfen bizi arayın: <strong>{{ site('contact_phone') }}</strong></p>
                    @endif
                @endif

                {{-- ====================================== ADIM 4: SAAT --}}
                @if($step === 4)
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-900">Saat seçin</h2>
                        <button wire:click="goToStep(3)" class="text-sm text-slate-400 hover:text-slate-600">← Geri</button>
                    </div>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y, l') }} · {{ $this->selectedDoctor?->full_name }}
                    </p>

                    @error('startTime')<p class="mt-3 rounded-xl bg-coral-50 px-4 py-2 text-sm text-coral-700">{{ $message }}</p>@enderror

                    @if(count($this->timeSlots))
                        <div class="mt-6 grid grid-cols-3 gap-2.5 sm:grid-cols-5">
                            @foreach($this->timeSlots as $slot)
                                <button type="button" wire:click="selectSlot('{{ $slot['start'] }}')"
                                    class="rounded-xl border-2 py-2.5 text-sm font-semibold transition {{ $startTime === $slot['start'] ? 'border-teal-500 bg-teal-500 text-white' : 'border-slate-100 text-slate-700 hover:border-teal-300 hover:bg-teal-50' }}">
                                    {{ $slot['label'] }}
                                </button>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-6 rounded-2xl bg-amber-50 p-4 text-sm text-amber-700">Bu gün için uygun saat kalmadı. Lütfen başka bir gün seçin.</p>
                    @endif
                @endif

                {{-- ====================================== ADIM 5: BİLGİLER --}}
                @if($step === 5)
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-900">İletişim bilgileriniz</h2>
                        <button wire:click="goToStep(4)" class="text-sm text-slate-400 hover:text-slate-600">← Geri</button>
                    </div>

                    <div class="mt-6 grid gap-6 lg:grid-cols-5">
                        {{-- Form --}}
                        <form wire:submit.prevent="submit" class="space-y-4 lg:col-span-3">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-slate-700">Ad Soyad *</label>
                                <input type="text" wire:model="patientName" placeholder="Adınız Soyadınız"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-teal-400 focus:bg-white focus:ring-teal-400">
                                @error('patientName')<p class="mt-1 text-xs text-coral-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Telefon *</label>
                                    <input type="tel" wire:model="patientPhone" placeholder="05XX XXX XX XX"
                                        class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-teal-400 focus:bg-white focus:ring-teal-400">
                                    @error('patientPhone')<p class="mt-1 text-xs text-coral-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-slate-700">E-posta</label>
                                    <input type="email" wire:model="patientEmail" placeholder="ornek@eposta.com"
                                        class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-teal-400 focus:bg-white focus:ring-teal-400">
                                    @error('patientEmail')<p class="mt-1 text-xs text-coral-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-slate-700">Notunuz (opsiyonel)</label>
                                <textarea wire:model="notes" rows="3" placeholder="Belirtmek istedikleriniz..."
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-teal-400 focus:bg-white focus:ring-teal-400"></textarea>
                            </div>
                            <label class="flex items-start gap-2.5 text-sm text-slate-500">
                                <input type="checkbox" wire:model="kvkk" class="mt-0.5 rounded border-slate-300 text-teal-500 focus:ring-teal-400">
                                <span>Kişisel verilerimin randevu amacıyla işlenmesini kabul ediyorum (KVKK).</span>
                            </label>
                            @error('kvkk')<p class="text-xs text-coral-600">{{ $message }}</p>@enderror

                            <button type="submit" class="btn-primary w-full text-base" wire:loading.attr="disabled" wire:target="submit">
                                <span wire:loading.remove wire:target="submit">Randevuyu Tamamla</span>
                                <span wire:loading wire:target="submit">Gönderiliyor...</span>
                            </button>
                        </form>

                        {{-- Özet --}}
                        <aside class="lg:col-span-2">
                            <div class="rounded-2xl bg-teal-50 p-5 ring-1 ring-teal-100">
                                <h3 class="font-display font-bold text-teal-900">Randevu Özeti</h3>
                                <dl class="mt-4 space-y-3 text-sm">
                                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Tedavi</dt><dd class="text-right font-semibold text-slate-900">{{ $this->selectedTreatment?->name ?? 'Genel muayene' }}</dd></div>
                                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Hekim</dt><dd class="text-right font-semibold text-slate-900">{{ $this->selectedDoctor?->full_name }}</dd></div>
                                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Tarih</dt><dd class="text-right font-semibold text-slate-900">{{ $date ? \Carbon\Carbon::parse($date)->translatedFormat('d F Y') : '-' }}</dd></div>
                                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Saat</dt><dd class="text-right font-semibold text-slate-900">{{ $startTime ?? '-' }}</dd></div>
                                </dl>
                            </div>
                        </aside>
                    </div>
                @endif

                {{-- ====================================== ADIM 6: ONAY --}}
                @if($step === 6)
                    <div class="py-8 text-center">
                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-green-600">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <h2 class="mt-6 text-2xl font-extrabold text-slate-900">Randevu talebiniz alındı! 🎉</h2>
                        <p class="mx-auto mt-2 max-w-md text-slate-500">Randevu numaranız <strong class="text-teal-600">{{ $confirmationNo }}</strong>. Kliniğimiz en kısa sürede sizinle iletişime geçerek randevunuzu onaylayacaktır.</p>

                        <div class="mx-auto mt-6 max-w-sm rounded-2xl bg-slate-50 p-5 text-left text-sm">
                            <div class="flex justify-between gap-3 py-1"><span class="text-slate-500">Hekim</span><span class="font-semibold text-slate-900">{{ $this->selectedDoctor?->full_name }}</span></div>
                            <div class="flex justify-between gap-3 py-1"><span class="text-slate-500">Tarih</span><span class="font-semibold text-slate-900">{{ $date ? \Carbon\Carbon::parse($date)->translatedFormat('d F Y, l') : '' }}</span></div>
                            <div class="flex justify-between gap-3 py-1"><span class="text-slate-500">Saat</span><span class="font-semibold text-slate-900">{{ $startTime }}</span></div>
                        </div>

                        <div class="mt-8 flex flex-wrap justify-center gap-3">
                            <a href="{{ route('home') }}" class="btn-ghost">Ana sayfaya dön</a>
                            <button wire:click="resetWizard" class="btn-primary">Yeni randevu</button>
                        </div>
                    </div>
                @endif
            </div>

            @if($step <= 5)
            <p class="mt-6 text-center text-sm text-slate-400">
                Telefonla randevu için: <a href="tel:{{ site('contact_phone_e164') }}" class="font-semibold text-teal-600">{{ site('contact_phone') }}</a>
            </p>
            @endif
        </div>
    </section>
</div>
