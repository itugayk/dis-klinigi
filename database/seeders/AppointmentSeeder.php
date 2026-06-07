<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = Doctor::with('treatments')->get()->keyBy('slug');
        $treatments = Treatment::pluck('id', 'name');

        $patients = [
            'Hasan Yılmaz', 'Emine Çelik', 'Murat Arslan', 'Hülya Doğan', 'Kemal Aksoy',
            'Sibel Korkmaz', 'Tolga Eren', 'Pınar Şen', 'Okan Güneş', 'Derya Yalçın',
            'Volkan Acar', 'Gül Taş', 'Serkan Polat', 'Aslı Kurt', 'Barış Yıldırım',
        ];

        // [doctorSlug, treatmentName, gün ofseti, saat, durum]
        $plan = [
            ['elif-demir',    'İmplant Tedavisi',       -7, '10:00', AppointmentStatus::Completed],
            ['zeynep-yildiz', 'Diş Beyazlatma',         -5, '14:00', AppointmentStatus::Completed],
            ['ahmet-sahin',   'Kanal Tedavisi',         -3, '11:00', AppointmentStatus::Completed],
            ['mehmet-kaya',   'Ortodonti (Diş Teli)',   -2, '09:30', AppointmentStatus::Cancelled],
            ['elif-demir',    'İmplant Tedavisi',        0, '09:00', AppointmentStatus::Confirmed],
            ['zeynep-yildiz', 'Estetik Diş Hekimliği',   0, '11:00', AppointmentStatus::Confirmed],
            ['selin-aydin',   'Çocuk Diş Hekimliği',     0, '14:30', AppointmentStatus::Pending],
            ['ahmet-sahin',   'Kanal Tedavisi',          1, '10:00', AppointmentStatus::Confirmed],
            ['elif-demir',    'İmplant Tedavisi',        1, '15:00', AppointmentStatus::Pending],
            ['zeynep-yildiz', 'Diş Beyazlatma',          2, '13:30', AppointmentStatus::Pending],
            ['mehmet-kaya',   'Ortodonti (Diş Teli)',    2, '09:00', AppointmentStatus::Confirmed],
            ['selin-aydin',   'Çocuk Diş Hekimliği',     3, '10:30', AppointmentStatus::Pending],
            ['ahmet-sahin',   'Çocuk Diş Hekimliği',     4, '11:30', AppointmentStatus::Confirmed],
            ['elif-demir',    'Kanal Tedavisi',          5, '14:00', AppointmentStatus::Pending],
        ];

        foreach ($plan as $i => [$slug, $treatmentName, $offset, $time, $status]) {
            $doctor = $doctors->get($slug);
            if (! $doctor) {
                continue;
            }

            // Hafta sonuna denk gelirse bir sonraki Pazartesi'ye kaydır
            $date = Carbon::today()->addDays($offset);
            if ($date->isSaturday()) {
                $date->addDays(2);
            } elseif ($date->isSunday()) {
                $date->addDay();
            }

            $treatmentId = $treatments[$treatmentName] ?? null;
            $duration = Treatment::find($treatmentId)?->duration_minutes ?? 45;
            $end = Carbon::parse($time)->addMinutes($duration)->format('H:i');

            Appointment::updateOrCreate(
                [
                    'doctor_id'  => $doctor->id,
                    'date'       => $date->toDateString(),
                    'start_time' => $time,
                ],
                [
                    'appointment_no' => 'RND-'.$date->format('ymd').'-'.str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                    'treatment_id'   => $treatmentId,
                    'patient_name'   => $patients[$i % count($patients)],
                    'patient_phone'  => '05'.str_pad((string) random_int(300000000, 599999999), 9, '0', STR_PAD_LEFT),
                    'patient_email'  => null,
                    'end_time'       => $end,
                    'status'         => $status,
                    'notes'          => null,
                ],
            );
        }
    }
}
