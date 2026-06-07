<x-layouts.app
    title="İletişim"
    description="Dentila Diş Polikliniği ile iletişime geçin. Adresimiz, telefon numaramız, çalışma saatlerimiz ve randevu talebi için iletişim formumuz.">

    <x-site.page-hero
        title="İletişim"
        subtitle="Sorularınız, randevu talepleriniz veya bilgi almak için bize ulaşın. Size yardımcı olmaktan memnuniyet duyarız."
        :crumbs="['İletişim' => null]" />

    <section class="container-x py-16 sm:py-24">
        <div class="grid gap-10 lg:grid-cols-2 lg:gap-12">
            {{-- ====================================== SOL: İLETİŞİM BİLGİLERİ --}}
            <div class="reveal space-y-5">
                <div>
                    <span class="eyebrow">Bize ulaşın</span>
                    <h2 class="mt-4 text-2xl font-extrabold text-slate-900 sm:text-3xl">İletişim bilgilerimiz</h2>
                    <p class="mt-3 text-slate-500">Aşağıdaki kanallardan dilediğiniz şekilde bize ulaşabilir veya kliniğimizi ziyaret edebilirsiniz.</p>
                </div>

                {{-- Adres --}}
                @if(site('address'))
                    <div class="card flex items-start gap-4 p-5">
                        <span class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-teal-100 text-teal-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Adres</p>
                            <p class="mt-1 font-medium text-slate-700">{{ site('address') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Telefon --}}
                @if(site('contact_phone'))
                    <a href="tel:{{ site('contact_phone_e164') }}" class="card card-hover flex items-start gap-4 p-5">
                        <span class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-teal-100 text-teal-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Telefon</p>
                            <p class="mt-1 font-medium text-slate-700">{{ site('contact_phone') }}</p>
                        </div>
                    </a>
                @endif

                {{-- E-posta --}}
                @if(site('contact_email'))
                    <a href="mailto:{{ site('contact_email') }}" class="card card-hover flex items-start gap-4 p-5">
                        <span class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-teal-100 text-teal-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </span>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">E-posta</p>
                            <p class="mt-1 font-medium text-slate-700">{{ site('contact_email') }}</p>
                        </div>
                    </a>
                @endif

                {{-- Çalışma saatleri --}}
                @php($workingHours = \App\Models\Setting::get('working_hours', config('clinic.working_hours')))
                @if(! empty($workingHours))
                    <div class="card p-5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-teal-100 text-teal-600">
                                <x-site.icon name="clock" class="h-6 w-6" />
                            </span>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Çalışma Saatleri</p>
                                <p class="mt-1 font-medium text-slate-700">Sizi bekliyoruz</p>
                            </div>
                        </div>
                        <dl class="mt-4 divide-y divide-slate-100 border-t border-slate-100">
                            @foreach($workingHours as $day => $time)
                                <div class="flex items-center justify-between py-2.5 text-sm">
                                    <dt class="font-medium text-slate-600">{{ $day }}</dt>
                                    <dd class="font-semibold text-slate-900">{{ $time }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif

                {{-- Sosyal medya --}}
                @php($social = site('social'))
                @if(! empty($social))
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-sm font-semibold text-slate-500">Bizi takip edin:</span>
                        @foreach($social as $slug => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener"
                               class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-teal-600 ring-1 ring-teal-200 transition hover:bg-teal-50 hover:ring-teal-300"
                               aria-label="{{ ucfirst($slug) }}">
                                <span class="text-sm font-bold capitalize">{{ \Illuminate\Support\Str::substr($slug, 0, 1) }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ====================================== SAĞ: İLETİŞİM FORMU --}}
            <div class="reveal">
                <div class="card p-6 sm:p-8">
                    <h2 class="text-2xl font-extrabold text-slate-900">Bize yazın</h2>
                    <p class="mt-2 text-sm text-slate-500">Formu doldurun, ekibimiz en kısa sürede sizinle iletişime geçsin.</p>

                    @if(session('contact_success'))
                        <div class="mt-6 flex items-start gap-3 rounded-2xl bg-teal-50 p-4 text-sm text-teal-800 ring-1 ring-teal-200">
                            <svg class="h-5 w-5 flex-shrink-0 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p>{{ session('contact_success') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" class="mt-6 space-y-5">
                        @csrf

                        {{-- Ad Soyad --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700">Ad Soyad <span class="text-coral-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="mt-2 w-full rounded-2xl border-0 bg-slate-50 px-4 py-3 text-slate-900 ring-1 ring-slate-200 transition placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 @error('name') ring-coral-400 @enderror"
                                   placeholder="Adınız ve soyadınız">
                            @error('name')<p class="mt-1.5 text-xs text-coral-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            {{-- Telefon --}}
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-slate-700">Telefon <span class="text-coral-500">*</span></label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                       class="mt-2 w-full rounded-2xl border-0 bg-slate-50 px-4 py-3 text-slate-900 ring-1 ring-slate-200 transition placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 @error('phone') ring-coral-400 @enderror"
                                       placeholder="0(5xx) xxx xx xx">
                                @error('phone')<p class="mt-1.5 text-xs text-coral-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- E-posta --}}
                            <div>
                                <label for="email" class="block text-sm font-semibold text-slate-700">E-posta</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                       class="mt-2 w-full rounded-2xl border-0 bg-slate-50 px-4 py-3 text-slate-900 ring-1 ring-slate-200 transition placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 @error('email') ring-coral-400 @enderror"
                                       placeholder="ornek@eposta.com">
                                @error('email')<p class="mt-1.5 text-xs text-coral-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Konu --}}
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-slate-700">Konu</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                   class="mt-2 w-full rounded-2xl border-0 bg-slate-50 px-4 py-3 text-slate-900 ring-1 ring-slate-200 transition placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 @error('subject') ring-coral-400 @enderror"
                                   placeholder="Mesajınızın konusu">
                            @error('subject')<p class="mt-1.5 text-xs text-coral-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Mesaj --}}
                        <div>
                            <label for="message" class="block text-sm font-semibold text-slate-700">Mesajınız <span class="text-coral-500">*</span></label>
                            <textarea name="message" id="message" rows="5" required
                                      class="mt-2 w-full rounded-2xl border-0 bg-slate-50 px-4 py-3 text-slate-900 ring-1 ring-slate-200 transition placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 @error('message') ring-coral-400 @enderror"
                                      placeholder="Bize iletmek istediğiniz mesajı yazın...">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1.5 text-xs text-coral-600">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="btn-primary w-full text-base">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M6 12L3.27 3.41a.5.5 0 01.65-.65L21 12 3.92 21.24a.5.5 0 01-.65-.65L6 12zm0 0h6"/></svg>
                            Mesajı Gönder
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ====================================== HARİTA --}}
        @if(site('map_embed'))
            <div class="reveal mt-12 overflow-hidden rounded-3xl ring-1 ring-slate-100 shadow-sm">
                <iframe src="{{ site('map_embed') }}"
                        class="h-96 w-full"
                        style="border:0;"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Harita"></iframe>
            </div>
        @endif
    </section>
</x-layouts.app>
