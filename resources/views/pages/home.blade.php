<x-layouts.app>
    {{-- ============================================================ HERO --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-teal-50/70 to-white">
        <div class="absolute -left-20 top-10 h-72 w-72 rounded-full bg-teal-200/40 blur-3xl"></div>
        <div class="absolute right-0 top-40 h-80 w-80 rounded-full bg-coral-200/40 blur-3xl"></div>

        <div class="container-x relative grid items-center gap-12 py-14 lg:grid-cols-2 lg:py-20">
            <div class="reveal is-visible">
                <span class="eyebrow">🦷 {{ site('tagline') }}</span>
                <h1 class="mt-5 text-4xl font-extrabold leading-[1.1] text-slate-900 sm:text-5xl lg:text-6xl">
                    Sağlıklı ve <span class="text-teal-500">estetik</span> gülüşler
                    <span class="relative whitespace-nowrap">
                        <span class="relative text-coral-500">burada</span>
                    </span> başlar
                </h1>
                <p class="mt-5 max-w-xl text-lg leading-relaxed text-slate-500">
                    {{ site('description') }}
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="{{ route('booking') }}" class="btn-primary text-base">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        Online Randevu Al
                    </a>
                    <a href="{{ route('treatments.index') }}" class="btn-ghost text-base">Tedavileri Keşfet</a>
                </div>

                {{-- Güven rozetleri --}}
                <div class="mt-10 flex flex-wrap items-center gap-x-8 gap-y-4">
                    @foreach([
                        ['shield', 'Tam sterilizasyon'],
                        ['heart', 'Ağrısız tedavi'],
                        ['microscope', 'Dijital teknoloji'],
                    ] as [$ic, $label])
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-100 text-teal-600"><x-site.icon :name="$ic" class="h-5 w-5" /></span>
                            <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Görsel --}}
            <div class="reveal is-visible relative">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <div class="relative overflow-hidden rounded-3xl bg-slate-100 ring-1 ring-slate-900/5 shadow-2xl shadow-teal-500/30">
                        <img src="/images/hero-clinic.jpg"
                             alt="Modern Diş Kliniği" onerror="this.remove()"
                             class="relative aspect-[4/5] w-full object-cover">
                    </div>

                    {{-- Yüzen kart: değerlendirme --}}
                    <div class="animate-float absolute -bottom-6 -left-4 rounded-2xl bg-white p-4 shadow-xl shadow-slate-200/70 ring-1 ring-slate-100 sm:-left-8">
                        <div class="flex items-center gap-1 text-coral-500">
                            @for($i=0;$i<5;$i++)<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.05 2.93c.3-.92 1.6-.92 1.9 0l1.36 4.19a1 1 0 00.95.69h4.4c.97 0 1.37 1.24.59 1.81l-3.56 2.59a1 1 0 00-.36 1.12l1.36 4.19c.3.92-.76 1.69-1.54 1.12l-3.56-2.59a1 1 0 00-1.18 0l-3.56 2.59c-.78.57-1.84-.2-1.54-1.12l1.36-4.19a1 1 0 00-.36-1.12L1.4 9.62c-.78-.57-.38-1.81.59-1.81h4.4a1 1 0 00.95-.69l1.36-4.19z"/></svg>@endfor
                        </div>
                        <p class="mt-1 text-sm font-semibold text-slate-900">5.0 / 5.0</p>
                        <p class="text-xs text-slate-400">162+ Google yorumu</p>
                    </div>

                    {{-- Yüzen kart: bugün müsait --}}
                    <div class="animate-float absolute -right-2 top-8 rounded-2xl bg-white p-3 shadow-xl shadow-slate-200/70 ring-1 ring-slate-100 sm:-right-6" style="animation-delay:-3s">
                        <div class="flex items-center gap-2">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-green-100 text-green-600"><x-site.icon name="clock" class="h-5 w-5" /></span>
                            <div>
                                <p class="text-xs text-slate-400">Bugün</p>
                                <p class="text-sm font-semibold text-slate-900">Randevu müsait</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================================================== TEDAVİLER --}}
    <section class="container-x py-16 sm:py-24">
        <x-site.section-heading
            eyebrow="Uzmanlık alanlarımız"
            title="Sunduğumuz tedaviler"
            subtitle="İmplanttan ortodontiye, estetik diş hekimliğinden çocuk diş sağlığına kadar tüm ihtiyaçlarınız tek çatı altında." />

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($treatments as $treatment)
                <x-site.treatment-card :treatment="$treatment" />
            @empty
                <p class="col-span-full text-center text-slate-400">Tedaviler yakında eklenecek.</p>
            @endforelse
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('treatments.index') }}" class="btn-ghost">Tüm tedaviler</a>
        </div>
    </section>

    {{-- ===================================================== NEDEN BİZ --}}
    <section class="bg-teal-700 py-16 sm:py-24">
        <div class="container-x">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div class="reveal text-white">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-teal-50 ring-1 ring-white/20">Neden MarDent?</span>
                    <h2 class="mt-4 text-3xl font-extrabold text-white sm:text-4xl">Güveni teknolojiyle birleştiriyoruz</h2>
                    <p class="mt-4 text-lg text-teal-50/85">Deneyimli hekim kadromuz, modern cihazlarımız ve hasta odaklı yaklaşımımızla konforlu bir tedavi deneyimi sunuyoruz.</p>

                    <div class="mt-8 space-y-4">
                        @foreach([
                            ['microscope','Dijital teşhis','İntraoral kameralar ve 3D görüntüleme ile hassas teşhis.'],
                            ['shield','Tam sterilizasyon','Uluslararası standartlarda hijyen ve sterilizasyon protokolleri.'],
                            ['heart','Ağrısız uygulama','Lokal anestezi ve sedasyon ile konforlu tedavi süreçleri.'],
                        ] as [$ic,$t,$d])
                            <div class="flex gap-4">
                                <span class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-white/10 text-white ring-1 ring-white/20"><x-site.icon :name="$ic" class="h-5 w-5" /></span>
                                <div>
                                    <h3 class="font-semibold text-white">{{ $t }}</h3>
                                    <p class="text-sm text-teal-50/75">{{ $d }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Sayaçlar --}}
                <div class="grid grid-cols-2 gap-5">
                    @foreach(site('stats', []) as $stat)
                        <div class="reveal rounded-3xl bg-white/10 p-7 text-center ring-1 ring-white/15 backdrop-blur">
                            <p class="font-display text-4xl font-extrabold text-white sm:text-5xl">
                                <span data-counter="{{ $stat['value'] }}">0</span>{{ $stat['suffix'] }}
                            </p>
                            <p class="mt-2 text-sm font-medium text-teal-50/80">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ===================================================== HEKİMLER --}}
    <section class="container-x py-16 sm:py-24">
        <div class="flex flex-col items-end justify-between gap-6 sm:flex-row">
            <x-site.section-heading align="left"
                eyebrow="Uzman kadromuz"
                title="Hekimlerimizle tanışın"
                subtitle="Alanında uzman, hasta memnuniyetini önceleyen deneyimli diş hekimleri." />
            <a href="{{ route('doctors.index') }}" class="btn-ghost flex-shrink-0">Tüm hekimler</a>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($doctors as $doctor)
                <x-site.doctor-card :doctor="$doctor" />
            @endforeach
        </div>
    </section>

    {{-- ===================================================== YORUMLAR --}}
    @if($testimonials->isNotEmpty())
    <section class="container-x py-16 sm:py-24">
        <x-site.section-heading
            eyebrow="Hasta deneyimleri"
            title="Hastalarımız ne diyor?"
            subtitle="Memnuniyetiniz bizim için en büyük referans." />

        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($testimonials as $testimonial)
                <x-site.testimonial-card :testimonial="$testimonial" />
            @endforeach
        </div>
    </section>
    @endif

    {{-- ===================================================== BLOG --}}
    @if($posts->isNotEmpty())
    <section class="bg-slate-50 py-16 sm:py-24">
        <div class="container-x">
            <div class="flex flex-col items-end justify-between gap-6 sm:flex-row">
                <x-site.section-heading align="left"
                    eyebrow="Sağlık rehberi"
                    title="Blog & makaleler"
                    subtitle="Ağız ve diş sağlığı hakkında uzman içerikleri." />
                <a href="{{ route('blog.index') }}" class="btn-ghost flex-shrink-0">Tüm yazılar</a>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach($posts as $post)
                    <x-site.blog-card :post="$post" />
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-layouts.app>
