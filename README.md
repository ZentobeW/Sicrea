# Sicrea

Sicrea adalah web app untuk membantu client Event Organizer Kreasi Hangat dalam memperkenalkan produk mereka sekaligus mengelola operasional EO.

![Sicrea Hero](docs/images/hero.png)

## Fitur utama

- Halaman publik: home, event, portfolio, partnership, about
- Katalog event dan detail event
- Registrasi workshop, unggah bukti pembayaran, dan pengajuan refund
- Autentikasi: login/registrasi, verifikasi email via OTP, reset password, Google OAuth
- Profil pengguna dan pengaturan akun
- Admin: dashboard, manajemen event, registrasi, portfolio, verifikasi pembayaran, refund, laporan
- SMTP test route untuk pengecekan email

## Tangkapan layar

Letakkan gambar di `docs/images/` lalu ganti path di bawah ini sesuai kebutuhan:

- `docs/images/hero.png` (landing)
- `docs/images/events.png` (daftar event)
- `docs/images/admin-dashboard.png` (admin)

## Tech stack

- Laravel 12 (PHP 8.2)
- MySQL
- Vite + Tailwind CSS v4
- Laravel Socialite (Google OAuth)
- no-captcha (Google reCAPTCHA)
- Queue dan cache berbasis database

## Prasyarat

- PHP 8.2+
- Composer
- Node.js + npm
- MySQL/MariaDB

## Instalasi cepat

```bash
composer run setup
```

Atau langkah manual:

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

Jalankan aplikasi:

```bash
php artisan serve
```

Untuk development full (server, queue, logs, vite):

```bash
composer run dev
```

## Konfigurasi env

Minimal yang perlu diisi di `.env`:

- `APP_NAME`, `APP_URL`
- `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`
- `MAIL_ADMIN_ADDRESS`, `MAIL_TEST_RECIPIENT`
- `NOCAPTCHA_SITEKEY`, `NOCAPTCHA_SECRET`
- `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URL`

Opsional untuk storage:

```bash
php artisan storage:link
```

## Perintah penting

```bash
composer run test
php artisan queue:listen
```

## Catatan

- Jika mengaktifkan Google OAuth, pastikan redirect URL sama dengan `GOOGLE_REDIRECT_URL`.
- Route test SMTP tersedia di `/test-email?to=email@domain.test` untuk verifikasi email saat development.
