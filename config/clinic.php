<?php

/*
|--------------------------------------------------------------------------
| Klinik varsayılanları
|--------------------------------------------------------------------------
| Bu değerler "settings" tablosundaki aynı anahtarlarla override edilebilir.
| Admin panelden değiştirilen ayarlar her zaman önceliklidir.
*/

return [
    'name'        => 'Dentila Ağız ve Diş Sağlığı Polikliniği',
    'short_name'  => 'Dentila',
    'tagline'     => 'Gülüşünüze değer katıyoruz',
    'description' => 'İmplant, ortodonti, estetik diş hekimliği ve genel tedavide '
                    .'modern teknoloji ve ağrısız uygulamalarla yanınızdayız.',

    // İletişim
    'contact_phone'   => '+90 212 555 0 100',
    'contact_phone_e164' => '+902125550100',
    'whatsapp'        => '+905555550100',
    'contact_email'   => 'randevu@dentila.com',
    'address'         => 'Bağdat Caddesi No:184, Kadıköy / İstanbul',
    'map_embed'       => 'https://www.google.com/maps?q=Kad%C4%B1k%C3%B6y%20%C4%B0stanbul&output=embed',

    // Sosyal medya
    'social' => [
        'instagram' => 'https://instagram.com/dentila',
        'facebook'  => 'https://facebook.com/dentila',
        'youtube'   => 'https://youtube.com/@dentila',
        'x'         => 'https://x.com/dentila',
    ],

    // Randevu slot ayarı (dakika)
    'slot_minutes' => 30,
    // Kaç gün ileriye randevu açılır
    'booking_horizon_days' => 30,

    // Klinik genel çalışma saatleri (vitrin amaçlı; slotlar hekim takvimine göre)
    'working_hours' => [
        'Pazartesi - Cuma' => '09:00 - 19:00',
        'Cumartesi'        => '09:00 - 16:00',
        'Pazar'            => 'Kapalı',
    ],

    // Resmi tatil / kapalı günler (slot üretiminde bloklanır) — YYYY-MM-DD
    'holidays' => [],

    // Ana sayfa "neden biz" sayaçları
    'stats' => [
        ['value' => 18,    'suffix' => '+', 'label' => 'Yıllık deneyim'],
        ['value' => 24500, 'suffix' => '+', 'label' => 'Mutlu hasta'],
        ['value' => 6,     'suffix' => '',  'label' => 'Uzman hekim'],
        ['value' => 100,   'suffix' => '%', 'label' => 'Sterilizasyon'],
    ],
];
