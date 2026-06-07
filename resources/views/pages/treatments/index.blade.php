<x-layouts.app
    title="Tedavilerimiz"
    description="İmplanttan ortodontiye, estetik diş hekimliğinden çocuk diş sağlığına kadar tüm diş tedavileri Dentila Diş Polikliniği'nde.">

    <x-site.page-hero
        title="Tedavilerimiz"
        subtitle="Modern teknoloji ve uzman kadromuzla, ağız ve diş sağlığınızın her ihtiyacına yönelik kapsamlı tedaviler sunuyoruz."
        :crumbs="['Tedaviler' => null]" />

    {{-- ===================================================== TEDAVİ LİSTESİ --}}
    <section class="container-x py-16 sm:py-24">
        <x-site.section-heading
            eyebrow="Uzmanlık alanlarımız"
            title="Sunduğumuz tedaviler"
            subtitle="Koruyucu diş hekimliğinden ileri cerrahi uygulamalara kadar, her tedavide konfor ve güveni ön planda tutuyoruz." />

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($treatments as $treatment)
                <x-site.treatment-card :treatment="$treatment" />
            @empty
                <div class="reveal col-span-full rounded-3xl bg-slate-50 px-6 py-16 text-center ring-1 ring-slate-100">
                    <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-teal-100 text-teal-600">
                        <x-site.icon name="tooth" class="h-8 w-8" />
                    </span>
                    <h3 class="mt-5 text-lg font-bold text-slate-900">Tedaviler yakında eklenecek</h3>
                    <p class="mt-2 text-sm text-slate-500">Şu anda listelenecek bir tedavi bulunmuyor. Detaylı bilgi için bizimle iletişime geçebilirsiniz.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ===================================================== CTA BANDI --}}
    <section class="container-x pb-16 sm:pb-24">
        <div class="reveal relative overflow-hidden rounded-4xl bg-gradient-to-br from-teal-600 to-teal-800 px-6 py-14 text-center shadow-2xl shadow-teal-600/25 sm:px-12 sm:py-20">
            <div class="absolute -left-16 -top-16 h-64 w-64 rounded-full bg-teal-400/30 blur-3xl"></div>
            <div class="absolute -bottom-20 -right-10 h-72 w-72 rounded-full bg-coral-400/25 blur-3xl"></div>

            <div class="relative mx-auto max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-teal-50 ring-1 ring-white/20">Randevu</span>
                <h2 class="mt-5 text-3xl font-extrabold text-white sm:text-4xl">Sağlıklı gülüşünüz için ilk adımı atın</h2>
                <p class="mt-4 text-lg text-teal-50/90">Hangi tedaviye ihtiyaç duyduğunuzdan emin değil misiniz? Uzman hekimlerimiz size en uygun planı birlikte oluşturur.</p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('booking') }}" class="btn-accent text-base">
                        <x-site.icon name="clock" class="h-5 w-5" />
                        Online Randevu Al
                    </a>
                    <a href="{{ route('doctors.index') }}" class="btn-outline-white text-base">Hekimlerimizi Tanıyın</a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
