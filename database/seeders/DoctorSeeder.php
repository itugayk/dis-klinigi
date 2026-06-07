<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Treatment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $byName = Treatment::pluck('id', 'name');

        $doctors = [
            [
                'title' => 'Doç. Dr. Dt.', 'name' => 'Elif Demir', 'specialty' => 'İmplantoloji & Cerrahi',
                'specialties' => ['İmplant', 'Çene cerrahisi', 'Kemik greftleme'],
                'experience_years' => 16,
                'photo_url' => 'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=600&q=80',
                'bio' => "İstanbul Üniversitesi Diş Hekimliği Fakültesi mezunu olan Doç. Dr. Elif Demir, 16 yılı aşkın süredir implantoloji ve ağız-çene cerrahisi alanında çalışmaktadır.\n\nYurt içi ve yurt dışında çok sayıda eğitim ve kongreye katılmış olup, ileri implant cerrahisi konusunda uzmandır.",
                'treatments' => ['İmplant Tedavisi', 'Kanal Tedavisi'],
                'saturday' => true,
            ],
            [
                'title' => 'Uzm. Dt.', 'name' => 'Mehmet Kaya', 'specialty' => 'Ortodonti',
                'specialties' => ['Şeffaf plak', 'Metal braket', 'Çocuk ortodontisi'],
                'experience_years' => 12,
                'photo_url' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=600&q=80',
                'bio' => "Ortodonti uzmanı Dt. Mehmet Kaya, şeffaf plak (clear aligner) ve klasik braket tedavilerinde geniş deneyime sahiptir.\n\nHer yaştan hastaya kişiye özel tedavi planları sunmaktadır.",
                'treatments' => ['Ortodonti (Diş Teli)'],
                'saturday' => false,
            ],
            [
                'title' => 'Dt.', 'name' => 'Zeynep Yıldız', 'specialty' => 'Estetik Diş Hekimliği',
                'specialties' => ['Gülüş tasarımı', 'Lamina', 'Zirkonyum', 'Beyazlatma'],
                'experience_years' => 9,
                'photo_url' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80',
                'bio' => "Estetik diş hekimliği ve gülüş tasarımı alanında çalışan Dt. Zeynep Yıldız, dijital gülüş tasarımı (DSD) ve porselen lamina uygulamalarında uzmandır.\n\nMinimal müdahale ile doğal sonuçlar elde etmeyi ilke edinmiştir.",
                'treatments' => ['Estetik Diş Hekimliği', 'Diş Beyazlatma'],
                'saturday' => true,
            ],
            [
                'title' => 'Dt.', 'name' => 'Ahmet Şahin', 'specialty' => 'Genel Diş Hekimliği & Endodonti',
                'specialties' => ['Kanal tedavisi', 'Dolgu', 'Genel muayene'],
                'experience_years' => 7,
                'photo_url' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=600&q=80',
                'bio' => "Dt. Ahmet Şahin, genel diş hekimliği ve kanal tedavisi (endodonti) alanında hizmet vermektedir.\n\nHasta konforunu önceleyen, ağrısız tedavi tekniklerini benimser.",
                'treatments' => ['Kanal Tedavisi', 'Diş Beyazlatma', 'Çocuk Diş Hekimliği'],
                'saturday' => false,
            ],
            [
                'title' => 'Uzm. Dt.', 'name' => 'Selin Aydın', 'specialty' => 'Pedodonti (Çocuk)',
                'specialties' => ['Çocuk diş sağlığı', 'Koruyucu hekimlik', 'Fissür örtücü'],
                'experience_years' => 10,
                'photo_url' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80',
                'bio' => "Çocuk diş hekimliği uzmanı Dt. Selin Aydın, minik hastaların diş hekimi korkusunu yenmelerine yardımcı olan sıcak yaklaşımıyla tanınır.\n\nKoruyucu uygulamalar ve süt dişi tedavilerinde deneyimlidir.",
                'treatments' => ['Çocuk Diş Hekimliği'],
                'saturday' => true,
            ],
        ];

        foreach ($doctors as $i => $data) {
            $treatmentNames = $data['treatments'];
            $saturday = $data['saturday'];
            unset($data['treatments'], $data['saturday']);

            $doctor = Doctor::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                array_merge($data, ['sort_order' => $i, 'is_active' => true, 'accepts_appointments' => true]),
            );

            // Tedavi ilişkileri
            $ids = collect($treatmentNames)->map(fn ($n) => $byName[$n] ?? null)->filter()->all();
            $doctor->treatments()->sync($ids);

            // Haftalık çalışma takvimi
            $doctor->schedules()->delete();
            $weekdays = [1, 2, 3, 4, 5]; // Pzt-Cuma
            foreach ($weekdays as $day) {
                $doctor->schedules()->create([
                    'day_of_week' => $day,
                    'start_time'  => '09:00',
                    'end_time'    => '18:00',
                    'break_start' => '12:30',
                    'break_end'   => '13:30',
                    'is_active'   => true,
                ]);
            }
            if ($saturday) {
                $doctor->schedules()->create([
                    'day_of_week' => 6, 'start_time' => '09:00', 'end_time' => '14:00', 'is_active' => true,
                ]);
            }
        }

        // Örnek izin: Dr. Mehmet Kaya gelecek hafta 2 gün izinli
        if ($mehmet = Doctor::where('slug', 'mehmet-kaya')->first()) {
            $mehmet->timeOff()->delete();
            $mehmet->timeOff()->create([
                'start_date' => now()->next(\Carbon\Carbon::WEDNESDAY)->toDateString(),
                'end_date'   => now()->next(\Carbon\Carbon::THURSDAY)->toDateString(),
                'reason'     => 'Ortodonti kongresi',
            ]);
        }
    }
}
