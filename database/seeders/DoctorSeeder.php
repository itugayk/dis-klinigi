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

        // Not: isimler hasta yorumlarında geçen gerçek hekimlerdir; soyadı bilinmeyenler
        // ve uzmanlık/deneyim detayları admin panelden tamamlanmalıdır. Fotoğraflar
        // geçici olarak AI ile üretilmiş portrelerdir, gerçek fotoğraflar ile değiştirilmelidir.
        $doctors = [
            [
                'title' => 'Dt.', 'name' => 'Güler Kalkan', 'specialty' => 'İmplantoloji & Genel Diş Tedavisi',
                'specialties' => ['İmplant', 'Genel diş tedavisi'],
                'experience_years' => null,
                'photo_url' => '/images/doctors/guler-kalkan.jpg',
                'bio' => 'Hasta yorumlarında özenli, sabırlı ve ağrısız implant tedavisi süreciyle öne çıkıyor.',
                'treatments' => ['İmplant Tedavisi'],
                'saturday' => true,
            ],
            [
                'title' => 'Dt.', 'name' => 'Tacettin', 'specialty' => 'Endodonti (Kanal Tedavisi)',
                'specialties' => ['Kanal tedavisi', 'Dolgu'],
                'experience_years' => null,
                'photo_url' => '/images/doctors/tacettin.jpg',
                'bio' => 'Kanal tedavisinde ilgi ve profesyonelliğiyle hastalarından yüksek memnuniyet alıyor.',
                'treatments' => ['Kanal Tedavisi'],
                'saturday' => false,
            ],
            [
                'title' => 'Dt.', 'name' => 'Selçuk İlhan', 'specialty' => 'Estetik Diş Hekimliği',
                'specialties' => ['Gülüş tasarımı', 'Zirkonyum kaplama'],
                'experience_years' => null,
                'photo_url' => '/images/doctors/selcuk-ilhan.jpg',
                'bio' => 'Gülüş tasarımı ve zirkonyum kaplama uygulamalarıyla hasta yorumlarında en çok övülen isimlerden.',
                'treatments' => ['Estetik Diş Hekimliği'],
                'saturday' => true,
            ],
            [
                'title' => '', 'name' => 'İbrahim Babayiğit', 'specialty' => 'Estetik Diş Hekimliği',
                'specialties' => ['Gülüş tasarımı', 'Zirkonyum kaplama'],
                'experience_years' => null,
                'photo_url' => '/images/doctors/ibrahim-babayigit.jpg',
                'bio' => 'Estetik diş tedavilerinde ekip içindeki katkısı hasta yorumlarında sıkça teşekkürle anılıyor.',
                'treatments' => ['Estetik Diş Hekimliği'],
                'saturday' => false,
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
    }
}
