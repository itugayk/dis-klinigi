@php
    $hours = \App\Models\Setting::get('working_hours', config('clinic.working_hours'));
@endphp
<footer class="mt-24 bg-slate-900 text-slate-300">
    {{-- Üst CTA şeridi --}}
    <div class="container-x">
        <div class="-mt-16 mb-14 overflow-hidden rounded-4xl bg-gradient-to-br from-teal-500 to-teal-700 p-8 shadow-2xl shadow-teal-900/30 sm:p-12">
            <div class="flex flex-col items-center gap-6 text-center md:flex-row md:justify-between md:text-left">
                <div>
                    <h2 class="text-2xl font-bold text-white sm:text-3xl">Sağlıklı gülüşler için ilk adım</h2>
                    <p class="mt-2 max-w-xl text-white/85">Uzman hekim kadromuzla tanışın. Online randevu sistemimizle dakikalar içinde yerinizi ayırtın.</p>
                </div>
                <div class="flex flex-shrink-0 flex-wrap justify-center gap-3">
                    <a href="{{ route('booking') }}" class="btn bg-white text-teal-700 hover:bg-teal-50">Randevu Al</a>
                    <a href="tel:{{ site('contact_phone_e164') }}" class="btn-outline-white">{{ site('contact_phone') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-x grid gap-10 pb-12 md:grid-cols-2 lg:grid-cols-4">
        {{-- Marka --}}
        <div class="lg:col-span-1">
            <div class="flex items-center gap-2.5">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-teal-500 text-white">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2c-1.5 0-2.5.6-3.6 1C7.2 3.4 6 3.5 5 3.2 3.4 2.7 2 4 2 6.3c0 2 .5 3.3.9 5 .3 1.3.4 3 .7 4.6.3 1.7.7 4 1.7 5.4.5.7 1.4.9 2 .2.6-.8.8-2.3 1-3.6.2-1.4.5-2.6 1.7-2.6s1.5 1.2 1.7 2.6c.2 1.3.4 2.8 1 3.6.6.7 1.5.5 2-.2 1-1.4 1.4-3.7 1.7-5.4.3-1.6.4-3.3.7-4.6.4-1.7.9-3 .9-5C22 4 20.6 2.7 19 3.2c-1 .3-2.2.2-3.4-.2C14.5 2.6 13.5 2 12 2z"/></svg>
                </span>
                <span class="font-display text-xl font-extrabold text-white">{{ site('short_name') }}</span>
            </div>
            <p class="mt-4 text-sm leading-relaxed text-slate-400">{{ site('description') }}</p>
            <div class="mt-5 flex gap-2.5">
                @foreach(site('social', []) as $k => $url)
                    @if($url)
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/5 text-slate-300 ring-1 ring-white/10 transition hover:bg-teal-500 hover:text-white" aria-label="{{ $k }}">
                            <span class="text-[11px] font-semibold uppercase">{{ substr($k, 0, 2) }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Hızlı linkler --}}
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Keşfet</h3>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('treatments.index') }}" class="text-slate-400 transition hover:text-teal-300">Tedaviler</a></li>
                <li><a href="{{ route('doctors.index') }}" class="text-slate-400 transition hover:text-teal-300">Hekimlerimiz</a></li>
                <li><a href="{{ route('gallery') }}" class="text-slate-400 transition hover:text-teal-300">Öncesi / Sonrası</a></li>
                <li><a href="{{ route('blog.index') }}" class="text-slate-400 transition hover:text-teal-300">Blog</a></li>
                <li><a href="{{ route('contact') }}" class="text-slate-400 transition hover:text-teal-300">İletişim</a></li>
            </ul>
        </div>

        {{-- Çalışma saatleri --}}
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Çalışma Saatleri</h3>
            <ul class="mt-4 space-y-2.5 text-sm">
                @foreach($hours as $day => $time)
                    <li class="flex items-center justify-between gap-4">
                        <span class="text-slate-400">{{ $day }}</span>
                        <span class="font-medium text-slate-200">{{ $time }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- İletişim --}}
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-white">İletişim</h3>
            <ul class="mt-4 space-y-3 text-sm">
                <li class="flex items-start gap-2.5 text-slate-400">
                    <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-teal-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    {{ site('address') }}
                </li>
                <li><a href="tel:{{ site('contact_phone_e164') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-teal-300"><svg class="h-4 w-4 text-teal-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>{{ site('contact_phone') }}</a></li>
                <li><a href="mailto:{{ site('contact_email') }}" class="flex items-center gap-2.5 text-slate-400 hover:text-teal-300"><svg class="h-4 w-4 text-teal-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>{{ site('contact_email') }}</a></li>
                <li class="pt-1">
                    <a href="{{ route('booking') }}" class="inline-flex items-center gap-1.5 font-medium text-teal-300 hover:text-teal-200">Online randevu al →</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-x flex flex-col items-center justify-between gap-3 py-6 text-xs text-slate-500 sm:flex-row">
            <p>© {{ date('Y') }} {{ site('name') }}. Tüm hakları saklıdır.</p>
            <p class="flex items-center gap-2">
                <a href="{{ route('booking') }}" class="hover:text-slate-300">Randevu</a>
                <span class="text-slate-700">·</span>
                <span>Demo: <span class="text-teal-400">dis-klinigi.demo.dijifa.com</span></span>
            </p>
        </div>
    </div>
</footer>
