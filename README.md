## Tentang Siklis

SIKLIS merupakan suatu sistem informasi yang digunakan untuk mengelola data pegawai dan layanan internal organisasi SEAQIL. Sistem ini memudahkan bagi staf SEAQIL dalam mengelola data administrasi kepegawaian dan data layanan yang disediakan oleh masing-masing divisi untuk meningkatkan layanan internal. SIKLIS dapat diakses melalui browser baik dari PC, Laptop, maupun perangkat mobile (smartphone).

## Teknologi

-   php 8.x
-   Laravel 10.x
-   [Admin-LTE](https://github.com/jeroennoten/Laravel-AdminLTE)

## Pengunaan

1. Clone repo ini

```bash
git clone https://github.com/ghinaat/Sikil.git
```

2. Install dependesi composer

```bash
composer install
```

3. Siapkan environment variable

```bash
cp .env.example .env
php artisan key:generate
```

4. Migrasi dan Seed

```bash
php artisan migrate --seed
```

5. Jalankan aplikasi

```bash
php artisan serve
```
