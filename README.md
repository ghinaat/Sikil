## Tentang Siklis

SIKLIS merupakan suatu sistem informasi yang digunakan untuk mengelola data pegawai dan layanan internal organisasi SEAQIL. Sistem ini memudahkan bagi staf SEAQIL dalam mengelola data administrasi kepegawaian dan data layanan yang disediakan oleh masing-masing divisi untuk meningkatkan layanan internal. SIKLIS dapat diakses melalui browser baik dari PC, Laptop, maupun perangkat mobile (smartphone).

## Teknologi

### Produksi
-   [php 8.x](https://www.php.net/)
-   [MySQL](https://www.mysql.com/)
-   [Laravel 10.x](https://laravel.com)
-   [Admin-LTE](https://github.com/jeroennoten/Laravel-AdminLTE)
-   [Excel](https://laravel-excel.com/)
-   [simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode)
-   [Bootstrap 4.x - 5,x](https://getbootstrap.com/)
-   [sweetalert2](https://sweetalert2.github.io/)
-   [jQuery](https://jquery.com/)
-   [Datatables](https://datatables.net/)
-   [Brezee](https://laravel.com/docs/10.x/starter-kits)
-   Simple Mail Tranfer Protocol / SMTP Gmail

### Pengembangan
-   [Git](https://git-scm.com/)
-   [Github](https://github.com/)


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

## Saran Produksi
1. Perhatikan versi, libary, extension dalam produksi
    - Lihat php info lokal dan produksi
    ```php
        <?php
            phpinfo();
        ?>
    ```
    - Perhatikan extension php yang dibutuhkan
    ```
    # contoh menimpa data extension
    <IfModule mod_php8.c>
        php_value display_errors on 
        php_value display_startup_errors on
        php_value memory_limit 512M
    </IfModule>

    ```
    - Perhatikan versi php
    ```
    # contoh menimpa php yang digunakan di runtime
    <IfModule mime_module>
        AddHandler application/x-httpd-alt-php81___lsphp .php .php8 phtml
    </IfModule>

    ```

2. Yang jangan dilupakan
    - Mengubah index.php di root (public)
    ```php
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // menjadi seperti ini

    $app = require_once __DIR__.'/laravel/bootstrap/app.php';
    ```

    - Mengubah .env
    ```
    # contoh
    APP_NAME=siklis
    APP_ENV=local
    APP_URL=https://contohurl.com/
    
    DB_DATABASE=contohurl_siklis
    DB_USERNAME=root_siklis
    DB_PASSWORD=password

    ```

    - Membuat Smylink
    ``` bash
     ln -s smylink /home/contohurl/public_html/siklis/laravel/storage/app/public/uploads /home/contohurl/public_html/siklis/storage
    ```

    - Contoh sintak cron job
    ``` bash
    /usr/local/bin/php /home/contohurl/public_html/siklis/laravel/artisan schedule:run >> /home/contohurl/public_html/siklis/laravel/storage logs/laravel.log 2>&1
    ```

    - Memperhatikan port SMTP\
    port yang biasa digunakan 25, 465, 587, 2525.
    ```
    telnet contohurl.com 587
    ```

    - Menganti default SMTP mail di /email-configuration\
    jika mengunakan email gmail pastikan untuk mengunakan app password sebagai password\
    username dan password adalah email gmail

## Kontibutor
<a href="https://github.com/ghinaat/Sikil/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=ghinaat/Sikil" />
</a>

