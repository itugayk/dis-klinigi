<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Talebiniz</title>
</head>
<body style="margin:0;background:#f1f5f9;font-family:Inter,Arial,sans-serif;color:#0f172a;">
    <div style="max-width:560px;margin:0 auto;padding:24px;">
        <div style="background:#15a3a8;color:#fff;border-radius:18px 18px 0 0;padding:28px 28px 22px;">
            <h1 style="margin:0;font-size:20px;font-weight:700;">{{ site('name') }}</h1>
            <p style="margin:6px 0 0;opacity:.9;font-size:14px;">Randevu talebiniz başarıyla alındı 🦷</p>
        </div>
        <div style="background:#fff;border-radius:0 0 18px 18px;padding:28px;box-shadow:0 10px 30px rgba(2,8,23,.06);">
            <p style="margin:0 0 16px;">Sayın <strong>{{ $appointment->patient_name }}</strong>,</p>
            <p style="margin:0 0 20px;line-height:1.6;">
                Randevu talebiniz alınmıştır. Kliniğimiz en kısa sürede sizinle iletişime geçerek
                randevunuzu <strong>onaylayacaktır</strong>. Randevu detaylarınız aşağıdadır:
            </p>

            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <tr><td style="padding:8px 0;color:#64748b;">Randevu No</td><td style="padding:8px 0;text-align:right;font-weight:600;">{{ $appointment->appointment_no }}</td></tr>
                <tr><td style="padding:8px 0;color:#64748b;">Tedavi</td><td style="padding:8px 0;text-align:right;font-weight:600;">{{ $appointment->treatment?->name ?? 'Genel muayene' }}</td></tr>
                <tr><td style="padding:8px 0;color:#64748b;">Hekim</td><td style="padding:8px 0;text-align:right;font-weight:600;">{{ $appointment->doctor->full_name }}</td></tr>
                <tr><td style="padding:8px 0;color:#64748b;">Tarih</td><td style="padding:8px 0;text-align:right;font-weight:600;">{{ $appointment->date->translatedFormat('d F Y, l') }}</td></tr>
                <tr><td style="padding:8px 0;color:#64748b;">Saat</td><td style="padding:8px 0;text-align:right;font-weight:600;">{{ $appointment->time_range }}</td></tr>
            </table>

            <div style="margin:24px 0;padding:14px 16px;background:#fef3f2;border-radius:12px;color:#9f1239;font-size:13px;">
                Randevunuzu iptal veya değiştirmek için
                <strong>{{ site('contact_phone') }}</strong> numarasından bize ulaşabilirsiniz.
            </div>

            <p style="margin:0;color:#64748b;font-size:13px;line-height:1.6;">
                {{ site('address') }}<br>
                {{ site('contact_phone') }} · {{ site('contact_email') }}
            </p>
        </div>
        <p style="text-align:center;color:#94a3b8;font-size:12px;margin:18px 0 0;">
            © {{ date('Y') }} {{ site('name') }}
        </p>
    </div>
</body>
</html>
