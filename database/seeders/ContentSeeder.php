<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\GalleryCase;
use App\Models\Testimonial;
use App\Models\Treatment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        /* ---------------------------------------------------- Blog */
        $cats = collect(['Ağız & Diş Sağlığı', 'Estetik Diş Hekimliği', 'Çocuk Diş Sağlığı'])
            ->mapWithKeys(fn ($n) => [$n => BlogCategory::updateOrCreate(['slug' => Str::slug($n)], ['name' => $n])->id]);

        $posts = [
            [
                'title' => 'Diş İmplantı Hakkında Merak Edilen 7 Soru',
                'category' => 'Ağız & Diş Sağlığı',
                'author' => 'Doç. Dr. Elif Demir',
                'cover_url' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=900&q=80',
                'excerpt' => 'İmplant tedavisi ağrılı mı? Ne kadar sürer? İmplantlar ömür boyu dayanır mı? En sık sorulan soruları yanıtladık.',
                'body' => '<p>Diş implantı, eksik dişlerin yerine konulan en konforlu ve kalıcı çözümlerden biridir. Bu yazıda hastalarımızın en çok merak ettiği soruları yanıtlıyoruz.</p><h2>1. İmplant tedavisi ağrılı mı?</h2><p>İşlem lokal anestezi altında yapıldığı için ağrı hissedilmez. Sonrasında hafif bir hassasiyet olabilir, bu da ağrı kesicilerle kolayca kontrol edilir.</p><h2>2. Tedavi ne kadar sürer?</h2><p>İmplantın kemikle kaynaşması ortalama 3 ay sürer. Toplam süreç diş yapısına göre 3-6 ay arasında değişir.</p><h2>3. İmplant ömrü ne kadardır?</h2><p>Doğru bakım ve düzenli kontrollerle implantlar ömür boyu kullanılabilir.</p>',
            ],
            [
                'title' => 'Gülüş Tasarımı Nedir, Kimlere Uygulanır?',
                'category' => 'Estetik Diş Hekimliği',
                'author' => 'Dt. Zeynep Yıldız',
                'cover_url' => 'https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?auto=format&fit=crop&w=900&q=80',
                'excerpt' => 'Dijital gülüş tasarımı ile tedaviye başlamadan önce yeni gülüşünüzü görebilirsiniz. Detaylar yazımızda.',
                'body' => '<p>Gülüş tasarımı (Smile Design), kişinin yüz hatları, dudak yapısı ve beklentileri doğrultusunda dişlerin yeniden şekillendirilmesidir.</p><h2>Kimlere uygulanır?</h2><ul><li>Diş renginden memnun olmayanlar</li><li>Dişlerinde şekil bozukluğu olanlar</li><li>Diş eti görünürlüğü fazla olanlar</li></ul><p>Dijital gülüş tasarımı (DSD) sayesinde tedaviye başlamadan sonucu önizleyebilirsiniz.</p>',
            ],
            [
                'title' => 'Çocuklarda Diş Fırçalama Alışkanlığı Nasıl Kazandırılır?',
                'category' => 'Çocuk Diş Sağlığı',
                'author' => 'Uzm. Dt. Selin Aydın',
                'cover_url' => 'https://images.unsplash.com/photo-1559691307-3b1d05d6e2c0?auto=format&fit=crop&w=900&q=80',
                'excerpt' => 'Çocuğunuza diş fırçalamayı sevdirmenin pratik yolları ve doğru fırçalama teknikleri.',
                'body' => '<p>Çocuklarda ağız ve diş sağlığının temeli, küçük yaşta kazanılan doğru alışkanlıklara dayanır.</p><h2>İpuçları</h2><ul><li>Fırçalamayı oyuna dönüştürün</li><li>Renkli, sevimli fırçalar tercih edin</li><li>Birlikte fırçalayarak örnek olun</li><li>6 ayda bir diş hekimi kontrolünü ihmal etmeyin</li></ul>',
            ],
            [
                'title' => 'Diş Beyazlatma Güvenli mi? Bilmeniz Gerekenler',
                'category' => 'Estetik Diş Hekimliği',
                'author' => 'Dt. Zeynep Yıldız',
                'cover_url' => 'https://images.unsplash.com/photo-1606265752439-1f18756aa8ed?auto=format&fit=crop&w=900&q=80',
                'excerpt' => 'Profesyonel diş beyazlatma diş minesine zarar verir mi? Klinik ve ev tipi beyazlatma arasındaki farklar.',
                'body' => '<p>Profesyonel diş beyazlatma, diş hekimi kontrolünde uygulandığında güvenli bir işlemdir.</p><h2>Klinik tipi beyazlatma</h2><p>Tek seansta görünür sonuç sağlar. Diş eti korunarak yüksek konsantrasyonlu jel uygulanır.</p><h2>Ev tipi beyazlatma</h2><p>Kişiye özel hazırlanan plaklarla evde uygulanır, sonuç birkaç gün içinde görülür.</p>',
            ],
            [
                'title' => 'Diş Eti Kanaması: Nedenleri ve Çözümleri',
                'category' => 'Ağız & Diş Sağlığı',
                'author' => 'Dt. Ahmet Şahin',
                'cover_url' => 'https://images.unsplash.com/photo-1588776813677-77aaf5595b83?auto=format&fit=crop&w=900&q=80',
                'excerpt' => 'Diş fırçalarken kanama oluyorsa dikkat! Diş eti hastalıklarının erken belirtileri.',
                'body' => '<p>Diş eti kanaması çoğunlukla diş eti iltihabının (gingivitis) ilk belirtisidir ve göz ardı edilmemelidir.</p><h2>Başlıca nedenler</h2><ul><li>Yetersiz ağız hijyeni</li><li>Diş taşı birikimi</li><li>Yanlış fırçalama tekniği</li></ul><p>Düzenli diş taşı temizliği ve doğru bakım ile sorun kolayca çözülür.</p>',
            ],
        ];

        foreach ($posts as $i => $p) {
            BlogPost::updateOrCreate(
                ['slug' => Str::slug($p['title'])],
                [
                    'title'        => $p['title'],
                    'blog_category_id' => $cats[$p['category']] ?? null,
                    'author'       => $p['author'],
                    'cover_url'    => $p['cover_url'],
                    'excerpt'      => $p['excerpt'],
                    'body'         => $p['body'],
                    'is_published' => true,
                    'published_at' => now()->subDays(($i + 1) * 4),
                ],
            );
        }

        /* ---------------------------------------------------- Yorumlar */
        $testimonials = [
            ['patient_name' => 'Ayşe K.', 'treatment_label' => 'İmplant Tedavisi', 'rating' => 5, 'is_featured' => true,
             'body' => 'Yıllardır eksik olan azı dişim için implant yaptırdım. Süreç boyunca her şey detaylıca anlatıldı, hiç ağrı çekmedim. Sonuçtan çok memnunum, teşekkürler Dentila!'],
            ['patient_name' => 'Burak T.', 'treatment_label' => 'Ortodonti', 'rating' => 5, 'is_featured' => true,
             'body' => 'Şeffaf plak tedavisiyle dişlerim 10 ayda düzeldi. Kimse fark etmeden tedavi oldum. Mehmet hocaya çok teşekkür ederim.'],
            ['patient_name' => 'Selin D.', 'treatment_label' => 'Gülüş Tasarımı', 'rating' => 5, 'is_featured' => true,
             'body' => 'Gülüş tasarımı yaptırdım ve sonuç inanılmaz doğal oldu. Artık gülerken çekinmiyorum. Klinik tertemiz, ekip çok ilgili.'],
            ['patient_name' => 'Mert Y.', 'treatment_label' => 'Diş Beyazlatma', 'rating' => 4,
             'body' => 'Tek seansta dişlerim belirgin şekilde beyazladı. İşlem hızlı ve konforluydu.'],
            ['patient_name' => 'Fatma A.', 'treatment_label' => 'Çocuk Diş Hekimliği', 'rating' => 5,
             'body' => 'Oğlum diş hekiminden çok korkardı, Selin hanım sayesinde artık severek geliyor. Çocuklara yaklaşımı harika.'],
            ['patient_name' => 'Cem Ö.', 'treatment_label' => 'Kanal Tedavisi', 'rating' => 5,
             'body' => 'Çekilir dediler ama Dentila dişimi kanal tedavisiyle kurtardı. Ağrısız ve profesyonel bir deneyimdi.'],
            // Onay bekleyen (moderasyon demosu)
            ['patient_name' => 'Deniz P.', 'treatment_label' => 'İmplant', 'rating' => 5, 'is_approved' => false,
             'body' => 'Henüz onaylanmamış örnek bir yorum — admin panelden moderasyon yapılabilir.'],
        ];

        foreach ($testimonials as $i => $t) {
            Testimonial::updateOrCreate(
                ['patient_name' => $t['patient_name'], 'body' => $t['body']],
                array_merge([
                    'is_approved' => true,
                    'is_featured' => false,
                    'sort_order'  => $i,
                ], $t),
            );
        }

        /* ---------------------------------------------------- Galeri */
        $byName = Treatment::pluck('id', 'name');
        $cases = [
            ['title' => 'Üst çene implant + zirkonyum', 'Estetik Diş Hekimliği',
             'before' => 'https://images.unsplash.com/photo-1601283773519-fbf3b09b4c8a?auto=format&fit=crop&w=700&q=80',
             'after'  => 'https://images.unsplash.com/photo-1581585095144-12c4e1f8d2e6?auto=format&fit=crop&w=700&q=80'],
            ['title' => 'Ortodonti ile çapraşıklık tedavisi', 'Ortodonti (Diş Teli)',
             'before' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=700&q=80',
             'after'  => 'https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?auto=format&fit=crop&w=700&q=80'],
            ['title' => 'Gülüş tasarımı — porselen lamina', 'Estetik Diş Hekimliği',
             'before' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&w=700&q=80',
             'after'  => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=700&q=80'],
            ['title' => 'Diş beyazlatma sonucu', 'Diş Beyazlatma',
             'before' => 'https://images.unsplash.com/photo-1609840114035-3c981b782dfe?auto=format&fit=crop&w=700&q=80',
             'after'  => 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&w=700&q=80'],
            ['title' => 'Tek diş implant uygulaması', 'İmplant Tedavisi',
             'before' => 'https://images.unsplash.com/photo-1620916297397-a4a5402a3c6c?auto=format&fit=crop&w=700&q=80',
             'after'  => 'https://images.unsplash.com/photo-1581585095144-12c4e1f8d2e6?auto=format&fit=crop&w=700&q=80'],
            ['title' => 'Estetik kompozit bonding', 'Estetik Diş Hekimliği',
             'before' => 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&w=700&q=80',
             'after'  => 'https://images.unsplash.com/photo-1606265752439-1f18756aa8ed?auto=format&fit=crop&w=700&q=80'],
        ];

        foreach ($cases as $i => $c) {
            GalleryCase::updateOrCreate(
                ['title' => $c['title']],
                [
                    'treatment_id' => $byName[$c[0] ?? null] ?? $byName[$c[1] ?? ''] ?? null,
                    'before_url'   => $c['before'],
                    'after_url'    => $c['after'],
                    'is_published' => true,
                    'sort_order'   => $i,
                ],
            );
        }
    }
}
