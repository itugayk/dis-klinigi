<?php

/*
|--------------------------------------------------------------------------
| Klinik varsayılanları
|--------------------------------------------------------------------------
| Bu değerler "settings" tablosundaki aynı anahtarlarla override edilebilir.
| Admin panelden değiştirilen ayarlar her zaman önceliklidir.
*/

return [
    'name'        => 'Mardent Ağız ve Diş Sağlığı Polikliniği',
    'short_name'  => 'MarDent',
    'tagline'     => 'Ücretsiz muayene ve tedavi planlama',
    'description' => 'Dijital ağız içi tarayıcı, implant, estetik gülüş tasarımı ve diş beyazlatmada '
                    .'Mardin\'de güvenilir adresiniz.',

    // İletişim
    'contact_phone'   => '0537 836 87 47',
    'contact_phone_e164' => '+905378368747',
    'whatsapp'        => '+905378368747',
    'contact_email'   => 'info@mardent.com.tr',
    'address'         => 'Okan Apt, Yenişehir, Kültür Cd. No:1, 47060 Artuklu/Mardin',
    'map_embed'       => 'https://www.google.com/maps?q=Mardent%20A%C4%9F%C4%B1z%20ve%20Di%C5%9F%20Sa%C4%9Fl%C4%B1%C4%9F%C4%B1%20Poliklini%C4%9Fi%20Mardin&output=embed',

    // Sosyal medya
    'social' => [
        'instagram' => 'https://instagram.com/mardentdispoliklinigi',
        'facebook'  => null,
        'youtube'   => null,
        'x'         => null,
    ],

    // Randevu slot ayarı (dakika)
    'slot_minutes' => 30,
    // Kaç gün ileriye randevu açılır
    'booking_horizon_days' => 30,

    // Klinik genel çalışma saatleri (vitrin amaçlı; slotlar hekim takvimine göre) — Google İşletme Profili'nden
    'working_hours' => [
        'Pazartesi - Cumartesi' => '09:00 - 20:00',
        'Pazar'                 => 'Kapalı',
    ],

    // Resmi tatil / kapalı günler (slot üretiminde bloklanır) — YYYY-MM-DD
    'holidays' => [],

    // Ana sayfa "neden biz" sayaçları — Google İşletme Profili: 5,0 puan / 162 yorum
    'stats' => [
        ['value' => 5,   'suffix' => '.0', 'label' => 'Google puanı'],
        ['value' => 162, 'suffix' => '+',  'label' => 'Hasta yorumu'],
        ['value' => 4,   'suffix' => '',   'label' => 'Uzman hekim'],
        ['value' => 100, 'suffix' => '%',  'label' => 'Sterilizasyon'],
    ],
];
