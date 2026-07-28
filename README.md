# Website Ucapan Ulang Tahun (PHP Native MVC)

Undangan ulang tahun online bergaya scrapbook: foto-foto ditempel seperti
polaroid di corkboard, ada ucapan utama, galeri kilas balik, dan dinding
ucapan (guestbook) tempat tamu bisa menempelkan ucapan mereka sendiri.

Dibangun murni dengan **PHP native** (tanpa framework/Composer), pola **MVC**.

## Struktur folder

```
ucapan-ultah/
├── app/
│   ├── Core/
│   │   ├── Router.php         # routing GET/POST sederhana
│   │   └── Controller.php     # base controller + render()
│   ├── Controllers/
│   │   └── HomeController.php # halaman utama + simpan ucapan
│   ├── Models/
│   │   └── UcapanModel.php    # baca/tulis storage/ucapan.json
│   ├── Views/
│   │   ├── layout/
│   │   │   ├── header.php
│   │   │   └── footer.php
│   │   └── home/
│   │       └── index.php      # markup halaman undangan
│   └── config.php             # ⭐ EDIT DI SINI: nama, usia, tanggal, foto
├── public/                    # ⭐ document root (arahkan Apache/Nginx ke sini)
│   ├── index.php              # front controller
│   ├── .htaccess              # rewrite semua request ke index.php
│   ├── css/style.css
│   ├── js/main.js
│   └── img/                   # taruh file foto asli kamu di sini
└── storage/
    └── ucapan.json            # penyimpanan ucapan tamu (auto dibuat)
```

## Cara menjalankan (lokal)

Butuh PHP 8+ terpasang, tidak perlu database.

```bash
cd ucapan-ultah/public
php -S localhost:8000
```

Buka `http://localhost:8000` di browser.

## Cara pakai / kustomisasi

1. **Ganti isi undangan** → edit `app/config.php`:
   nama penerima, usia, tanggal acara, ucapan utama, dan daftar foto.
2. **Ganti foto** → taruh file foto asli (jpg/png) di `public/img/`, lalu
   sesuaikan nama file di `foto.src` pada `config.php`. Selama file belum ada,
   otomatis muncul kotak warna sebagai placeholder (tidak akan tampil ikon
   gambar rusak).
3. **Ucapan tamu** tersimpan otomatis di `storage/ucapan.json` — tidak perlu
   setup database. Kalau nanti butuh skala lebih besar, tinggal ganti isi
   `UcapanModel.php` dengan query PDO ke MySQL, controller & view tidak perlu
   diubah.

## Deploy ke hosting (Apache)

1. Upload seluruh folder `ucapan-ultah` ke server.
2. Arahkan **document root** domain/subdomain ke folder `public/` (bukan ke
   root project) — ini penting supaya folder `app/` dan `storage/` tidak bisa
   diakses langsung dari browser.
3. Pastikan `mod_rewrite` aktif (dipakai oleh `.htaccess`).
4. Beri izin tulis (`chmod 775` atau sesuai kebijakan hosting) ke folder
   `storage/` supaya ucapan tamu bisa disimpan.

## Ringkasan alur MVC

- `public/index.php` (front controller) → bikin `Router`, daftar 2 route:
  `GET /` dan `POST /kirim-ucapan` → lempar ke `HomeController`.
- `HomeController` ambil data dari `config.php` + `UcapanModel`, lalu panggil
  `render()` dari `Controller` untuk merender view di dalam layout.
- `UcapanModel` adalah satu-satunya tempat yang menyentuh penyimpanan data —
  kalau mau pindah dari JSON ke database, cukup edit file ini saja.
