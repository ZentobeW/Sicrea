@php
    $userName = $user->name ?? 'Sahabat Kreasi Hangat';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Email</title>
</head>
<body style="font-family: Arial, sans-serif; background:#fff7f3; padding:24px;">
    <table width="100%" cellspacing="0" cellpadding="0" style="max-width:640px; margin:auto; background:#ffffff; border:1px solid #f7c8b8; border-radius:12px;">
        <tr>
            <td style="padding:28px;">
                <h2 style="color:#7c3a2d; margin:0 0 12px;">Halo, {{ $userName }} </h2>
                <p style="color:#7c3a2d; line-height:1.6; margin:0 0 16px;">
                    Berikut kode OTP 6-digit untuk memverifikasi email kamu di Kreasi Hangat.
                </p>
                <p style="font-size:28px; letter-spacing:12px; font-weight:bold; color:#d97862; margin:0 0 12px;">
                    {{ $code }}
                </p>
                <p style="color:#9a5a46; margin:0 0 8px;">Kode berlaku selama 15 menit.</p>
                <p style="color:#9a5a46; margin:0;">Jika kamu tidak meminta kode ini, abaikan email ini.</p>
            </td>
        </tr>
    </table>
</body>
</html>
