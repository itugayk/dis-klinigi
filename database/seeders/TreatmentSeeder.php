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
                'excerpt' => 'Eksik dişlerinize kalıcı, doğal görünümlü ve fonksiyonel çözüm sunan implant tedavisi ile hem estetiğinizi hem çiğneme kalitenizi geri kazanın.',
                'price_from' => null, 'duration_minutes' => 60, 'featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&w=900&q=80',
                'benefits' => [
                    'Doğal diş görünümü ve hissi',
                    'Çene kemiği erimesini önler',
                    'Ömür boyu kullanım imkânı',
                    'Komşu dişlere zarar vermez',
                    'Sabit veya hareketli protez desteği',
                    'Yüksek başarı oranı (%95+)',
                ],
                'description' => '<h2>İmplant Tedavisi Nedir?</h2>
<p>Dental implant, eksik dişlerin yerine çene kemiğine yerleştirilen titanyum vida üzerine sabitlenen yapay diş köküdür. Doğal dişe en yakın çözüm olan implant tedavisi ile hem estetik hem fonksiyonel kayıplarınızı giderirsiniz. Titanyum vida, vücutla biyolojik uyum sağlayarak kemikle doğal şekilde bütünleşir (osseointegrasyon).</p>

<h2>Kimler İçin Uygundur?</h2>
<p>İmplant tedavisi; tek diş eksikliği, çoklu diş kaybı veya tam dişsizlik durumlarında uygulanabilir. Genel sağlık durumu uygun olan, yeterli kemik hacmine sahip veya kemik augmentasyonu yapılabilecek yetişkin hastalarda başarılı sonuçlar elde edilir.</p>
<ul>
    <li>Tek diş, köprü veya tam çene protez destekli implantlar</li>
    <li>Kemik yetersizliğinde sinüs lifting ve kemik greftleme</li>
    <li>Diyabet, tansiyon gibi sistemik hastalığı olanlarda özel protokoller</li>
</ul>

<h3>Tedavi Süreci</h3>
<p>Detaylı muayene ve 3D tomografi (CBCT) ile dijital planlama yapılır. İmplant, lokal anestezi altında ağrısız olarak çene kemiğine yerleştirilir. Ardından osseointegrasyon süreci beklenir (ortalama 2-4 ay). Son aşamada daimi protez veya kaplama monte edilir.</p>
<ol>
    <li><strong>Teşhis ve planlama:</strong> Panoramik röntgen, 3D tomografi, dijital ölçü</li>
    <li><strong>Cerrahi aşama:</strong> İmplant vidasının çene kemiğine yerleştirilmesi</li>
    <li><strong>İyileşme dönemi:</strong> 2-4 ay kemik kaynaşma süreci</li>
    <li><strong>Protez aşaması:</strong> Abutment ve kalıcı diş protezinin takılması</li>
</ol>

<h3>Sıkça Sorulan Sorular</h3>
<p><strong>İmplant ağrılı mıdır?</strong> İşlem lokal anestezi ile yapıldığından ağrı hissedilmez. Sonrasında hafif bir hassasiyet olabilir, bu reçeteli ağrı kesicilerle kolayca kontrol edilir.</p>
<p><strong>İmplant ömrü ne kadardır?</strong> Doğru bakım ve düzenli diş hekimi kontrolleri ile implantlar ömür boyu kullanılabilir.</p>
<p><strong>Hemen diş takılır mı?</strong> Uygun vakalarda aynı gün geçici diş takılabilir (immediate loading). Kesin değerlendirme klinik muayeneden sonra yapılır.</p>',
            ],
            [
                'name' => 'Ortodonti (Diş Teli)', 'icon' => 'ortodonti', 'color' => '#0e8389',
                'excerpt' => 'Çapraşık dişler, diş aralıkları ve kapanış bozuklukları için metal braketlerden şeffaf plaklara kadar modern tedavi seçenekleri.',
                'price_from' => null, 'duration_minutes' => 45, 'featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1611690012802-6a1e5c5d5f0e?auto=format&fit=crop&w=900&q=80',
                'benefits' => [
                    'Düzgün ve sağlıklı bir gülüş',
                    'Metal ve şeffaf plak seçenekleri',
                    'Çiğneme fonksiyonunda belirgin iyileşme',
                    'Her yaşa uygun tedavi planlaması',
                    'Çene eklem sorunlarının önlenmesi',
                    'Dijital tedavi simülasyonu ile önceden sonuç görme',
                ],
                'description' => '<h2>Ortodonti Nedir?</h2>
<p>Ortodonti, diş ve çene düzensizliklerinin teşhis, önleme ve tedavisiyle ilgilenen diş hekimliği uzmanlık alanıdır. Çapraşık dizilim, dişler arası boşluklar, üst-alt çene uyumsuzlukları ve kapanış bozuklukları ortodontik tedavi ile düzeltilir.</p>

<h2>Tedavi Seçenekleri</h2>
<h3>Metal Braketler</h3>
<p>Geleneksel ve en etkili yöntemlerden biri olan metal braketler, karmaşık vakalarda bile güvenilir sonuçlar sunar. Modern mini braketler sayesinde konfor artırılmış, estetik görünüm iyileştirilmiştir.</p>

<h3>Seramik (Porselen) Braketler</h3>
<p>Diş rengine yakın, şeffaf braketler estetik kaygı taşıyan yetişkin hastalar için idealdir. Metal braketlerle aynı etkinliği sunarken görünürlüğü minimuma indirir.</p>

<h3>Şeffaf Plak (Clear Aligner) Tedavisi</h3>
<p>Çıkarılabilir, şeffaf plaklar ile dişler kademeli olarak hareket ettirilir. Yemeğe ve fırçalamaya engel olmaz. Hafif-orta vakalarda tercih edilen konforlu bir alternatiftir.</p>

<h3>Lingual Ortodonti</h3>
<p>Braketler dişlerin iç yüzeyine yerleştirilir, dışarıdan hiç görünmez. Estetiğe en üst düzeyde önem veren hastalar için uygundur.</p>

<h2>Tedavi Süreci</h2>
<ul>
    <li>Detaylı dijital tarama ve sefalometrik analiz</li>
    <li>Kişiye özel tedavi planı oluşturulması</li>
    <li>Ortalama 12-24 ay aktif tedavi süresi</li>
    <li>Tedavi sonrası pekiştirme (retainer) uygulaması</li>
</ul>

<p><strong>Çocuk ve Yetişkin Ortodontisi:</strong> Ortodontik tedaviye herhangi bir yaşta başlanabilir. Çocuklarda koruyucu ortodonti ile erken müdahale mümkün olup, yetişkinlerde ise modern tekniklerle etkili sonuçlar elde edilmektedir.</p>',
            ],
            [
                'name' => 'Estetik Diş Hekimliği', 'icon' => 'estetik', 'color' => '#ff7a6b',
                'excerpt' => 'Gülüş tasarımı, porselen lamina veneer, zirkonyum kaplama ve kompozit bonding ile hayalinizdeki kusursuz gülüşe kavuşun.',
                'price_from' => null, 'duration_minutes' => 60, 'featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1581585095144-12c4e1f8d2e6?auto=format&fit=crop&w=900&q=80',
                'benefits' => [
                    'Kişiye özel dijital gülüş tasarımı (DSD)',
                    'Minimal müdahale ile maksimum estetik',
                    'Doğal renk ve anatomik form',
                    'Tedavi öncesi dijital önizleme imkânı',
                    'Uzun ömürlü ve dayanıklı materyaller',
                    'Tek seansta tamamlanabilen seçenekler',
                ],
                'description' => '<h2>Estetik Diş Hekimliği Nedir?</h2>
<p>Estetik diş hekimliği, dişlerin renk, şekil, boyut ve dizilim açısından ideal görünüme kavuşturulmasını hedefleyen tedavi dalıdır. Gülüş tasarımı, porselen lamina veneer, zirkonyum kaplama, kompozit bonding ve diş beyazlatma gibi uygulamaları kapsar.</p>

<h2>Gülüş Tasarımı (Smile Design)</h2>
<p>Dijital Gülüş Tasarımı (DSD - Digital Smile Design), kişinin yüz hatları, dudak yapısı, diş eti seviyesi ve beklentileri doğrultusunda dişlerin yeniden şekillendirilmesidir. Tedaviye başlamadan önce dijital ortamda yeni gülüşünüzü görebilirsiniz.</p>

<h3>Porselen Lamina Veneer</h3>
<p>Yaprak porselen olarak da bilinen lamina veneerler, dişin ön yüzeyine yapıştırılan ince porselen tabakalarıdır. Minimum diş aşındırması ile uygulanır. Dişlerdeki renk, şekil ve boyut düzensizliklerini doğal görünümle düzeltir.</p>
<ul>
    <li>0.3-0.5 mm kalınlığında ultra ince porselenler</li>
    <li>Dişin doğal yapısının korunması</li>
    <li>10-15 yıl ve üzeri kullanım ömrü</li>
</ul>

<h3>Zirkonyum Kaplama</h3>
<p>Yüksek dayanıklılığa sahip zirkonyum altyapılı seramik kaplamalar, hem ön hem arka dişlerde uygulanabilir. Metal desteksiz yapısı sayesinde doğal ışık geçirgenliği sağlar ve diş eti çizgisinde koyu renk oluşumunu önler.</p>

<h3>Kompozit Bonding</h3>
<p>Diş renginde kompozit dolgu materyali ile dişlerdeki küçük kırıklar, boşluklar ve şekil bozuklukları tek seansta onarılır. Minimal müdahale gerektiren, hızlı ve ekonomik bir çözümdür.</p>

<h2>Dijital Önizleme</h2>
<p>İntraoral tarayıcı ile ağız içi dijital ölçü alınır, bilgisayar ortamında yeni gülüşünüzün simülasyonu oluşturulur. Mock-up (maket diş) uygulaması ile ağız içinde deneyerek onay verirsiniz.</p>',
            ],
            [
                'name' => 'Diş Beyazlatma', 'icon' => 'beyazlatma', 'color' => '#34cfc9',
                'excerpt' => 'Tek seansta birkaç ton daha beyaz dişler. Profesyonel ofis tipi ve ev tipi beyazlatma seçenekleri ile güvenli ve kalıcı sonuçlar.',
                'price_from' => null, 'duration_minutes' => 45,
                'image_url' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=900&q=80',
                'benefits' => [
                    'Tek seansta görünür sonuç',
                    'Diş minesine zarar vermeyen güvenli formüller',
                    'Ofis tipi ve ev tipi seçenekler',
                    'Uzun süreli beyazlık etkisi',
                    'Hassasiyet kontrolü ile konforlu uygulama',
                    'Kişiye özel plak ile ev uygulaması',
                ],
                'description' => '<h2>Diş Beyazlatma Nedir?</h2>
<p>Profesyonel diş beyazlatma, dişlerdeki renklenme ve sararmayı güvenli kimyasal ajanlarla açma işlemidir. Çay, kahve, sigara, şarap gibi alışkanlıklar veya yaşlanma nedeniyle oluşan renk değişikliklerinde etkili sonuç verir.</p>

<h2>Beyazlatma Yöntemleri</h2>
<h3>Ofis Tipi Beyazlatma (Klinikte)</h3>
<p>Yüksek konsantrasyonlu beyazlatma jeli, diş eti korunarak dişlere uygulanır. LED veya lazer ışık aktivasyonu ile etki hızlandırılır. Tek seansta 3-8 ton beyazlama sağlanabilir. İşlem süresi yaklaşık 45-60 dakikadır.</p>

<h3>Ev Tipi Beyazlatma</h3>
<p>Kişiye özel hazırlanan şeffaf plaklar ile düşük konsantrasyonlu jel evde uygulanır. Günde 1-2 saat veya gece boyunca kullanılır, sonuç 7-14 günde belirginleşir.</p>

<h3>Kombine Beyazlatma</h3>
<p>En etkili sonuç için klinikte başlayıp evde devam eden kombine tedavi önerilir. Hem anında fark görülür hem de uzun süreli etki sağlanır.</p>

<h2>Beyazlatma Öncesi</h2>
<p>İşlem öncesinde diş ve diş eti sağlığınız muayene edilir, gerekli görülürse diş taşı temizliği yapılır. Çürük veya dolgu olan dişlerde önce bu tedaviler tamamlanır. Mine yapısına zarar vermeyen, klinik olarak test edilmiş ürünler kullanılır.</p>

<p><strong>Beyazlık ne kadar sürer?</strong> Beslenme alışkanlıklarına ve ağız bakımına bağlı olarak 1-3 yıl beyaz kalır. Düzenli bakımla kalıcılığı artırılabilir.</p>',
            ],
            [
                'name' => 'Kanal Tedavisi', 'icon' => 'kanal', 'color' => '#11696f',
                'excerpt' => 'Enfekte veya hasar görmüş dişlerin çekilmeden kurtarılması. Modern döner alet sistemleri ve dijital görüntüleme ile ağrısız tedavi.',
                'price_from' => null, 'duration_minutes' => 60,
                'image_url' => 'https://images.unsplash.com/photo-1609840114035-3c981b782dfe?auto=format&fit=crop&w=900&q=80',
                'benefits' => [
                    'Doğal dişin korunması ve diş çekiminin önlenmesi',
                    'Modern tekniklerle ağrısız ve konforlu uygulama',
                    'Tek veya iki seansta tamamlanabilir',
                    '%95 üzeri yüksek başarı oranı',
                    'Dijital röntgen ile hassas tedavi',
                    'Tedavi sonrası diş, yıllarca fonksiyonel kalır',
                ],
                'description' => '<h2>Kanal Tedavisi (Endodonti) Nedir?</h2>
<p>Kanal tedavisi, dişin iç kısmındaki sinir ve damar dokusunun (pulpa) çürük, travma veya kırık nedeniyle enfekte olması durumunda uygulanan tedavidir. Amaç, enfekte dokuyu temizleyerek dişi çekmeden korumaktır.</p>

<h2>Hangi Durumlarda Kanal Tedavisi Gerekir?</h2>
<ul>
    <li>Derin çürüklerde sinir dokusuna ulaşan enfeksiyon</li>
    <li>Dişte oluşan kırık veya çatlak</li>
    <li>Şiddetli ve uzun süren diş ağrısı</li>
    <li>Sıcak-soğuğa karşı aşırı hassasiyet</li>
    <li>Diş kökü ucunda apse (iltihap) oluşumu</li>
    <li>Renk değişikliği gösteren dişler</li>
</ul>

<h3>Tedavi Süreci</h3>
<ol>
    <li><strong>Teşhis:</strong> Dijital röntgen ile enfeksiyon seviyesi ve kanal anatomisi değerlendirilir.</li>
    <li><strong>Anestezi:</strong> Lokal anestezi ile diş ve çevresi tamamen uyuşturulur, ağrı hissedilmez.</li>
    <li><strong>Temizleme:</strong> Enfekte pulpa dokusu özel döner aletlerle (NiTi eğeleri) temizlenir. Kanallar antiseptik solüsyonlarla yıkanır.</li>
    <li><strong>Şekillendirme:</strong> Kanallar standart forma getirilir ve kurutulur.</li>
    <li><strong>Doldurma:</strong> Kanallar biyouyumlu dolgu materyali (gutta percha) ile sızdırmaz şekilde doldurulur.</li>
    <li><strong>Restorasyon:</strong> Dişin üst kısmı dolgu veya kaplama ile restore edilir.</li>
</ol>

<p><strong>Kanal tedavisi ağrılı mıdır?</strong> Modern anestezi yöntemleri sayesinde işlem sırasında ağrı hissedilmez. Tedavi sonrası birkaç gün hafif hassasiyet olabilir, bu ağrı kesicilerle kontrol edilir.</p>

<p><strong>Tedavi süresi:</strong> Çoğu vaka tek seansta (60-90 dakika) tamamlanır. Karmaşık vakalarda 2. seans gerekebilir.</p>',
            ],
            [
                'name' => 'Çocuk Diş Hekimliği', 'icon' => 'cocuk', 'color' => '#6ee6df',
                'excerpt' => 'Minik hastalarımız için sevgi dolu, korkusuz tedavi ortamı. Koruyucu uygulamalar, süt dişi tedavileri ve alışkanlık kazandırma.',
                'price_from' => null, 'duration_minutes' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=900&q=80',
                'benefits' => [
                    'Çocuk dostu, eğlenceli tedavi ortamı',
                    'Flor (fluorid) ve fissür örtücü koruyucu uygulamalar',
                    'Diş hekimi korkusunu önleme',
                    'Oyunla tanışma (desensitizasyon) seansları',
                    'Süt dişi tedavi ve kanal tedavisi',
                    'Yer tutucu uygulamalar',
                ],
                'description' => '<h2>Çocuk Diş Hekimliği (Pedodonti) Nedir?</h2>
<p>Pedodonti, 0-14 yaş arası çocukların ağız, diş ve çene sağlığıyla ilgilenen uzmanlık alanıdır. Çocuk diş hekimliğinde amaç yalnızca tedavi değil; doğru alışkanlıklar kazandırma, koruyucu uygulamalar yapma ve çocukta diş hekimi korkusu oluşmasını önlemektir.</p>

<h2>Koruyucu Uygulamalar</h2>
<h3>Flor (Fluorid) Uygulaması</h3>
<p>Diş minesini güçlendiren ve çürüğe karşı koruma sağlayan profesyonel flor uygulaması, 6 aylık periyotlarla önerilir. İşlem ağrısızdır ve birkaç dakika sürer.</p>

<h3>Fissür Örtücü</h3>
<p>Dişlerin çiğneme yüzeylerindeki oluk ve çukurlara (fissürlere) uygulanan ince koruyucu tabaka, bakteri ve yiyecek artıklarının birikmesini önler. Özellikle yeni süren daimi azı dişlerine önerilir.</p>

<h2>Tedavi Uygulamaları</h2>
<ul>
    <li><strong>Süt dişi dolgular:</strong> Çürümüş süt dişlerinin cam iyonomer veya kompozit dolgu ile onarımı</li>
    <li><strong>Süt dişi kanal tedavisi (pulpotomi/pulpektomi):</strong> Enfekte süt dişi sinirinin tedavisi</li>
    <li><strong>Süt dişi çekimi:</strong> Tedavi edilemeyecek durumda olan veya zamanında düşmeyen süt dişlerinin çekimi</li>
    <li><strong>Yer tutucu:</strong> Erken kaybedilen süt dişinin yerini korumak için uygulanan aparey</li>
</ul>

<h2>Diş Hekimi Korkusunu Önleme</h2>
<p>İlk ziyaret genellikle "tanışma seansı" olarak planlanır. Çocuk kliniğe alışır, aletleri tanır ve güven ortamı oluşur. Tedavi aşamalarında "anlat-göster-uygula" tekniği ile çocuğun rahatlaması sağlanır.</p>

<p><strong>İlk diş hekimi kontrolü ne zaman olmalı?</strong> İlk süt dişi sürdüğünde veya en geç 1 yaşında ilk diş hekimi kontrolü yapılmalıdır.</p>
<p><strong>Süt dişleri neden önemlidir?</strong> Süt dişleri çiğneme fonksiyonu, konuşma gelişimi ve altlarında bekleyen daimi dişlerin doğru konumda sürmesi için kritik öneme sahiptir.</p>',
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
