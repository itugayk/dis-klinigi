<?php

namespace Database\Seeders;

use App\Models\Treatment;
use Illuminate\Database\Seeder;

class TreatmentSeeder extends Seeder
{
    public function run(): void
    {
        $treatments = [
            [
                'name' => 'İmplant Tedavisi', 'icon' => 'implant', 'color' => '#15a3a8',
                'excerpt' => 'Eksik dişlerinize kalıcı, doğal görünümlü çözüm.',
                'price_from' => 8500, 'duration_minutes' => 60, 'featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&w=900&q=80',
                'benefits' => ['Doğal diş görünümü ve hissi', 'Çene kemiği erimesini önler', 'Ömür boyu kullanım', 'Komşu dişlere zarar vermez'],
                'description' => '<p>Dental implant, eksik dişlerin yerine çene kemiğine yerleştirilen titanyum vida üzerine sabitlenen yapay diş köküdür. Doğal dişe en yakın çözüm olan implant tedavisi ile hem estetik hem fonksiyonel kayıplarınızı giderirsiniz.</p><h3>Tedavi süreci</h3><p>Detaylı muayene ve 3D tomografi sonrası planlama yapılır. İmplant yerleştirildikten sonra kemikle kaynaşma (osseointegrasyon) süreci beklenir ve ardından protez tamamlanır.</p><ul><li>Tek diş, çoklu diş ve tam çene uygulamaları</li><li>Lokal anestezi ile ağrısız işlem</li><li>Ortalama 3-6 aylık tedavi süreci</li></ul>',
            ],
            [
                'name' => 'Ortodonti (Diş Teli)', 'icon' => 'ortodonti', 'color' => '#0e8389',
                'excerpt' => 'Çapraşık dişler ve kapanış bozuklukları için modern tedavi.',
                'price_from' => 18000, 'duration_minutes' => 45, 'featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1611690012802-6a1e5c5d5f0e?auto=format&fit=crop&w=900&q=80',
                'benefits' => ['Düzgün ve sağlıklı bir gülüş', 'Metal ve şeffaf plak seçenekleri', 'Çiğneme fonksiyonunda iyileşme', 'Her yaşa uygun planlama'],
                'description' => '<p>Ortodonti, diş ve çene düzensizliklerinin teşhis ve tedavisiyle ilgilenen uzmanlık alanıdır. Çapraşıklık, açıklık ve kapanış bozuklukları metal braketler veya şeffaf plaklar (aligner) ile düzeltilir.</p><h3>Seçenekler</h3><ul><li>Metal ve porselen braketler</li><li>Şeffaf plak (clear aligner) tedavisi</li><li>Çocuk ve yetişkin ortodontisi</li></ul>',
            ],
            [
                'name' => 'Estetik Diş Hekimliği', 'icon' => 'estetik', 'color' => '#ff7a6b',
                'excerpt' => 'Gülüş tasarımı, lamina ve porselen ile kusursuz gülüşler.',
                'price_from' => 4500, 'duration_minutes' => 60, 'featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1581585095144-12c4e1f8d2e6?auto=format&fit=crop&w=900&q=80',
                'benefits' => ['Kişiye özel gülüş tasarımı', 'Minimal müdahale ile maksimum estetik', 'Doğal renk ve form', 'Dijital önizleme'],
                'description' => '<p>Estetik diş hekimliği; gülüş tasarımı, porselen lamina (veneer), zirkonyum kaplama ve bonding uygulamalarıyla gülüşünüzü yeniden şekillendirir. Dijital gülüş tasarımı ile tedavi öncesi sonucu görebilirsiniz.</p><h3>Uygulamalar</h3><ul><li>Porselen lamina (yaprak porselen)</li><li>Zirkonyum kaplama</li><li>Kompozit bonding</li><li>Dijital gülüş tasarımı (DSD)</li></ul>',
            ],
            [
                'name' => 'Diş Beyazlatma', 'icon' => 'beyazlatma', 'color' => '#34cfc9',
                'excerpt' => 'Tek seansta birkaç ton daha beyaz dişler.',
                'price_from' => 2500, 'duration_minutes' => 45,
                'image_url' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=900&q=80',
                'benefits' => ['Tek seansta görünür sonuç', 'Diş minesine zarar vermez', 'Ofis tipi ve ev tipi seçenekler', 'Uzun süreli etki'],
                'description' => '<p>Profesyonel diş beyazlatma ile dişlerinizdeki renklenmeleri güvenli şekilde açarız. Ofis tipi (klinikte) ve ev tipi beyazlatma seçenekleri sunulur.</p><p>İşlem öncesi diş eti ve diş sağlığınız değerlendirilir; mine yapısına zarar vermeyen jeller kullanılır.</p>',
            ],
            [
                'name' => 'Kanal Tedavisi', 'icon' => 'kanal', 'color' => '#11696f',
                'excerpt' => 'Enfekte dişlerin çekilmeden kurtarılması.',
                'price_from' => 2000, 'duration_minutes' => 60,
                'image_url' => 'https://images.unsplash.com/photo-1609840114035-3c981b782dfe?auto=format&fit=crop&w=900&q=80',
                'benefits' => ['Doğal dişin korunması', 'Ağrısız modern teknikler', 'Tek seansta tamamlanabilir', 'Yüksek başarı oranı'],
                'description' => '<p>Kanal tedavisi (endodonti), çürük veya travma nedeniyle iltihaplanan diş sinirinin temizlenip dişin korunmasını sağlar. Modern döner alet sistemleri ve dijital görüntüleme ile konforlu uygulanır.</p>',
            ],
            [
                'name' => 'Çocuk Diş Hekimliği', 'icon' => 'cocuk', 'color' => '#6ee6df',
                'excerpt' => 'Minik hastalarımız için sevgiyle, korkusuz tedavi.',
                'price_from' => 800, 'duration_minutes' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=900&q=80',
                'benefits' => ['Çocuk dostu yaklaşım', 'Koruyucu uygulamalar (fluorid, fissür)', 'Diş hekimi korkusunu önleme', 'Oyunla tanışma seansları'],
                'description' => '<p>Pedodonti (çocuk diş hekimliği), 0-14 yaş arası çocukların ağız ve diş sağlığıyla ilgilenir. Koruyucu uygulamalar, süt dişi tedavileri ve çocuk dostu yaklaşımla diş hekimi korkusunu ortadan kaldırırız.</p>',
            ],
        ];

        foreach ($treatments as $i => $data) {
            Treatment::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($data['name'])],
                array_merge($data, ['sort_order' => $i, 'is_active' => true]),
            );
        }
    }
}
