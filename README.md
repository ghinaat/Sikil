## Tentang Siklis

SIKLIS merupakan suatu sistem informasi yang digunakan untuk mengelola data pegawai dan layanan internal organisasi SEAQIL. Sistem ini memudahkan bagi staf SEAQIL dalam mengelola data administrasi kepegawaian dan data layanan yang disediakan oleh masing-masing divisi untuk meningkatkan layanan internal. SIKLIS dapat diakses melalui browser baik dari PC, Laptop, maupun perangkat mobile (smartphone).

## Teknologi

-   php 8.x
-   [Laravel 10.x](https://laravel.com)
-   [Admin-LTE](https://github.com/jeroennoten/Laravel-AdminLTE)

## Pengunaan

Berikut adalah tahap-tahap untuk mengunakan dan menjalankan aplikasi ini

1. Fork repo ini
2. Clone repo milikmu

```bash
git clone https://github.com/[USERNAME]/Sikil.git
```

3. Install dependesi composer

```bash
composer install
```

4. Siapkan environment variable

```bash
cp .env.example .env
php artisan key:generate
```

5. Migrasi dan Seed

```bash
php artisan migrate --seed
```

6. Jalankan aplikasi

```bash
php artisan serve
```

## Kontribusi

Berikut adalah tahap-tahap untuk mengembakan fitur terbaru dan berktrbusi dalam proyek ini.

1. Fork repo ini
2. Clone milikmu fork
3. Lakukan beberapa pekerjaan
4. Bersihkan pekerjaan kalian dengan lint

```
./vendor/bin/pint
```

5. Checkout branch baru

```bash
git branch YOUR-NEW-FEATURE
git checkout YOUR-NEW-FEATURE
```

6. Commit

```bash
git init
git add .
git commit -m "[Your message] -yourname"
```

7. Push branch milikmu ke fork milikmu

```bash
git push -u origin --set-upstream YOUR-NEW-FEATURE
```

8. Pergi ke github UI dan buat a PR dari fork milikmu dan branch, dan merge dengan MAIN upstream kita
