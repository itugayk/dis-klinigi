<x-layouts.app
    title="Hekimlerimiz"
    description="Dentila Diş Polikliniği'nin alanında uzman, deneyimli diş hekimi kadrosuyla tanışın.">

    <x-site.page-hero
        title="Hekimlerimiz"
        subtitle="Hasta memnuniyetini önceleyen, alanında uzman ve deneyimli diş hekimi kadromuzla yanınızdayız."
        :crumbs="['Hekimler' => null]" />

    {{-- ===================================================== HEKİM LİSTESİ --}}
    <section class="container-x py-16 sm:py-24">
        <x-site.section-heading
            eyebrow="Uzman kadromuz"
            title="Hekimlerimizle tanışın"
            subtitle="Her biri kendi alanında uzmanlaşmış hekimlerimiz, modern tedavi yöntemleriyle güvenli ve konforlu bir deneyim sunar." />

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($doctors as $doctor)
                <x-site.doctor-card :doctor="$doctor" />
            @empty
                <div class="reveal col-span-full rounded-3xl bg-slate-50 px-6 py-16 text-center ring-1 ring-slate-100">
                    <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-teal-100 text-teal-600">
                        <x-site.icon name="heart" class="h-8 w-8" />
                    </span>
                    <h3 class="mt-5 text-lg font-bold text-slate-900">Hekim bilgileri yakında eklenecek</h3>
                    <p class="mt-2 text-sm text-slate-500">Şu anda listelenecek bir hekim bulunmuyor. Detaylı bilgi için bizimle iletişime geçebilirsiniz.</p>
                </div>
            @endforelse
        </div>
    </section>
</x-layouts.app>
