<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // config/clinic.php varsayılanlarını DB'ye yazar; admin panelden düzenlenebilir.
        Setting::putMany([
            'name'                 => config('clinic.name'),
            'short_name'           => config('clinic.short_name'),
            'tagline'              => config('clinic.tagline'),
            'description'          => config('clinic.description'),
            'contact_phone'        => config('clinic.contact_phone'),
            'contact_phone_e164'   => config('clinic.contact_phone_e164'),
            'whatsapp'             => config('clinic.whatsapp'),
            'contact_email'        => config('clinic.contact_email'),
            'address'              => config('clinic.address'),
            'map_embed'            => config('clinic.map_embed'),
            'social'               => config('clinic.social'),
            'working_hours'        => config('clinic.working_hours'),
            'holidays'             => [
                now()->addWeeks(2)->next(\Carbon\Carbon::MONDAY)->toDateString(), // örnek tatil
            ],
            'slot_minutes'         => config('clinic.slot_minutes'),
            'booking_horizon_days' => config('clinic.booking_horizon_days'),
        ]);
    }
}
