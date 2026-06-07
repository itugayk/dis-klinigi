<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Yönetici kullanıcı (Filament /admin girişi)
        User::updateOrCreate(
            ['email' => 'admin@dentila.com'],
            [
                'name'     => 'Dentila Admin',
                'password' => bcrypt('password'),
            ],
        );

        $this->call([
            SettingSeeder::class,
            TreatmentSeeder::class,
            DoctorSeeder::class,
            ContentSeeder::class,
            AppointmentSeeder::class,
        ]);
    }
}
