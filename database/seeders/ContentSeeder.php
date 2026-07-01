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
                'author' => 'Dt. Güler Kalkan',
                'cover_url' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=900&q=80',
                'excerpt' => 'İmplant tedavisi ağrılı mı? Ne kadar sürer? İmplantlar ömür boyu dayanır mı? En sık sorulan soruları yanıtladık.',
                'body' => '<p>Diş implantı, eksik dişlerin yerine konulan en konforlu ve kalıcı çözümlerden biridir. Bu yazıda hastalarımızın en çok merak ettiği soruları yanıtlıyoruz.</p><h2>1. İmplant tedavisi ağrılı mı?</h2><p>İşlem lokal anestezi altında yapıldığı için ağrı hissedilmez. Sonrasında hafif bir hassasiyet olabilir, bu da ağrı kesicilerle kolayca kontrol edilir.</p><h2>2. Tedavi ne kadar sürer?</h2><p>İmplantın kemikle kaynaşması ortalama 3 ay sürer. Toplam süreç diş yapısına göre 3-6 ay arasında değişir.</p><h2>3. İmplant ömrü ne kadardır?</h2><p>Doğru bakım ve düzenli kontrollerle implantlar ömür boyu kullanılabilir.</p>',
            ],
            [
                'title' => 'Gülüş Tasarımı Nedir, Kimlere Uygulanır?',
                'category' => 'Estetik Diş Hekimliği',
                'author' => 'Dt. Selçuk İlhan',
                'cover_url' => 'https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?auto=format&fit=crop&w=900&q=80',
                'excerpt' => 'Dijital gülüş tasarımı ile tedaviye başlamadan önce yeni gülüşünüzü görebilirsiniz. Detaylar yazımızda.',
                'body' => '<p>Gülüş tasarımı (Smile Design), kişinin yüz hatları, dudak yapısı ve beklentileri doğrultusunda dişlerin yeniden şekillendirilmesidir.</p><h2>Kimlere uygulanır?</h2><ul><li>Diş renginden memnun olmayanlar</li><li>Dişlerinde şekil bozukluğu olanlar</li><li>Diş eti görünürlüğü fazla olanlar</li></ul><p>Dijital gülüş tasarımı (DSD) sayesinde tedaviye başlamadan sonucu önizleyebilirsiniz.</p>',
            ],
            [
                'title' => 'Çocuklarda Diş Fırçalama Alışkanlığı Nasıl Kazandırılır?',
                'category' => 'Çocuk Diş Sağlığı',
                'author' => 'Mardent Diş Hekimi Ekibi',
                'cover_url' => 'https://images.unsplash.com/photo-1559691307-3b1d05d6e2c0?auto=format&fit=crop&w=900&q=80',
                'excerpt' => 'Çocuğunuza diş fırçalamayı sevdirmenin pratik yolları ve doğru fırçalama teknikleri.',
                'body' => '<p>Çocuklarda ağız ve diş sağlığının temeli, küçük yaşta kazanılan doğru alışkanlıklara dayanır.</p><h2>İpuçları</h2><ul><li>Fırçalamayı oyuna dönüştürün</li><li>Renkli, sevimli fırçalar tercih edin</li><li>Birlikte fırçalayarak örnek olun</li><li>6 ayda bir diş hekimi kontrolünü ihmal etmeyin</li></ul>',
            ],
            [
                'title' => 'Diş Beyazlatma Güvenli mi? Bilmeniz Gerekenler',
                'category' => 'Estetik Diş Hekimliği',
                'author' => 'Dt. Selçuk İlhan',
                'cover_url' => 'https://images.unsplash.com/photo-1606265752439-1f18756aa8ed?auto=format&fit=crop&w=900&q=80',
                'excerpt' => 'Profesyonel diş beyazlatma diş minesine zarar verir mi? Klinik ve ev tipi beyazlatma arasındaki farklar.',
                'body' => '<p>Profesyonel diş beyazlatma, diş hekimi kontrolünde uygulandığında güvenli bir işlemdir.</p><h2>Klinik tipi beyazlatma</h2><p>Tek seansta görünür sonuç sağlar. Diş eti korunarak yüksek konsantrasyonlu jel uygulanır.</p><h2>Ev tipi beyazlatma</h2><p>Kişiye özel hazırlanan plaklarla evde uygulanır, sonuç birkaç gün içinde görülür.</p>',
            ],
            [
                'title' => 'Diş Eti Kanaması: Nedenleri ve Çözümleri',
                'category' => 'Ağız & Diş Sağlığı',
                'author' => 'Dt. Tacettin',
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

        /* ---------------------------------------------------- Yorumlar (Google İşletme Profili'nden — 5,0 / 162 yorum) */
        $testimonials = [
            ['patient_name' => 'Elif Y.', 'treatment_label' => 'Estetik Diş Tedavisi', 'rating' => 5, 'is_featured' => true,
             'body' => 'Dişlerimle özenle ve titizlikle ilgilenen Güler hocama teşekkür ediyorum, özgüvenim tekrar yerine geldi. Artık dişlerimi göstermek için gülüyorum. Kaliteli ve hijyenik bir yer, gözünüz kapalı güvenle Mardent\'e gidebilirsiniz.'],
            ['patient_name' => 'Şerif H.', 'treatment_label' => 'İmplant Tedavisi', 'rating' => 5, 'is_featured' => true,
             'body' => 'Uzun zamandır dişçiden korkan biri olarak, bu korkumu yenmemde büyük emeği olan değerli doktorum Güler Hanıma çok teşekkür ederim. İmplant sürecimi büyük bir özen, sabır ve profesyonellikle tamamladı.'],
            ['patient_name' => 'Yağmur E.', 'treatment_label' => 'Gülüş Tasarımı', 'rating' => 5, 'is_featured' => true,
             'body' => 'Mardin\'in en nezih, en temiz, en samimi kliniği. Özellikle Selçuk bey ne kadar övülse az, dişlerimi güvenle emanet ettiğim tek yer. Gülüş tasarımı deyince akla ilk gelen klinik olmalı.'],
            ['patient_name' => 'Apo K.', 'treatment_label' => 'Kanal Tedavisi', 'rating' => 5,
             'body' => 'Öncelikle Dr. Tacettin hocama çok teşekkür ediyorum, ilgi ve alakasından çok memnun kaldım. Kanal tedavisi yapıldı, gerçekten profesyonel biriydi. Bir diş probleminiz olursa hiç kaçırmayın derim.'],
            ['patient_name' => 'Nebil E.', 'treatment_label' => 'Zirkonyum Kaplama', 'rating' => 5,
             'body' => 'Ön dişlerime kaplama yaptırmak için gittim, gerçekten özenli, temiz ve çok iyi çalışıyorlar. Kaplama dişler çok güzel oldu, boyutu ve rengi kusursuz. Özellikle Dr. Selçuk Bey\'e ve İbrahim Bey\'e teşekkür ederim.'],
            ['patient_name' => 'Tuğba A.', 'treatment_label' => 'Genel Muayene', 'rating' => 5,
             'body' => 'Hem işletme sahiplerinin ilgisi olsun, hem personel titizliği olsun hem de doktorların profesyonelliği olsun çok memnun kaldım. Bütün işlemlerimi bu klinikte gönül rahatlığıyla yapıyorum, çokça tavsiyemdir.'],
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

        /* ---------------------------------------------------- Galeri (gerçek hasta fotoğrafları — Instagram @mardentdispoliklinigi) */
        $byName = Treatment::pluck('id', 'name');
        $cases = [
            ['title' => 'Zirkonyum kaplama ile gülüş yenileme', 'Estetik Diş Hekimliği',
             'before' => '/storage/uploads/mardent/gallery/case1_before.jpg',
             'after'  => '/storage/uploads/mardent/gallery/case1_after.jpg'],
            ['title' => 'Ağır çürük vakasında tam ağız rehabilitasyonu', 'Estetik Diş Hekimliği',
             'before' => '/storage/uploads/mardent/gallery/case2_before.jpg',
             'after'  => '/storage/uploads/mardent/gallery/case2_after.jpg'],
            ['title' => 'Ön diş kaplama ile estetik gülüş', 'Estetik Diş Hekimliği',
             'before' => '/storage/uploads/mardent/gallery/case3_before.jpg',
             'after'  => '/storage/uploads/mardent/gallery/case3_after.jpg'],
            ['title' => 'Diş çürüğü sonrası zirkonyum kaplama', 'Estetik Diş Hekimliği',
             'before' => '/storage/uploads/mardent/gallery/case4_before.jpg',
             'after'  => '/storage/uploads/mardent/gallery/case4_after.jpg'],
            ['title' => 'Tam ağız restorasyonu', 'Estetik Diş Hekimliği',
             'before' => '/storage/uploads/mardent/gallery/case5_before.jpg',
             'after'  => '/storage/uploads/mardent/gallery/case5_after.jpg'],
            ['title' => 'Gülüş tasarımı ile diş boşluğu kapatma', 'Estetik Diş Hekimliği',
             'before' => '/storage/uploads/mardent/gallery/case6_before.jpg',
             'after'  => '/storage/uploads/mardent/gallery/case6_after.jpg'],
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
