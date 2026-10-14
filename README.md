# Portal Layanan Akademik — Akademika

Aplikasi pembelajaran berbasis PHP, MySQL, HTML semantik, dan CSS responsif. Dibuat untuk studi kasus **Responsive & Accessible Web Client** dan dikembangkan dengan halaman login, registrasi, dashboard pengguna, serta panel administrator.

## Teknologi
- PHP 8.1+ (disarankan PHP 8.2+)
- MySQL/MariaDB melalui XAMPP
- HTML5 semantik dan CSS3 mobile-first
- PDO prepared statements
- Tidak memerlukan JavaScript untuk alur utama

## Struktur proyek
```text
portal_layanan_akademik/
├── admin/
│   ├── index.php
│   ├── login.php
│   ├── requests.php
│   ├── services.php
│   ├── user_detail.php
│   └── users.php
├── assets/css/styles.css
├── includes/
│   ├── footer.php
│   ├── functions.php
│   └── header.php
├── config.php
├── database.sql
├── dashboard.php
├── index.php
├── login.php
├── logout.php
├── register.php
└── request.php
```

## Cara menjalankan di Windows + XAMPP
1. Ekstrak folder proyek ke `C:\xampp\htdocs\portal_layanan_akademik`.
2. Buka XAMPP Control Panel lalu jalankan **Apache** dan **MySQL**.
3. Buka `http://localhost/phpmyadmin`.
4. Pilih menu **Import**, pilih file `database.sql` dari folder proyek, lalu klik **Import/Go**. File SQL akan membuat database `portal_akademik` dan tabelnya.
5. Buka `config.php`. Default XAMPP biasanya menggunakan host `127.0.0.1`, user `root`, dan password kosong. Sesuaikan bila konfigurasi lokalmu berbeda.
6. Buka `http://localhost/portal_layanan_akademik/`.
7. Daftarkan akun pengguna lewat **Daftar akun**.
8. Untuk membuat admin, ikuti bagian “Membuat akun admin” di bawah.
9. Buka `http://localhost/portal_layanan_akademik/login.php`. Akun admin juga masuk dari form ini; setelah autentikasi, sistem mengarahkannya ke panel admin.

## Membuat akun admin dengan aman
Jangan memberi role admin melalui formulir registrasi publik. Daftarkan akun biasa terlebih dahulu, lalu jalankan langkah ini hanya di database lokal yang kamu kendalikan:

1. Masuk melalui halaman **Daftar akun** dengan email yang ingin dijadikan admin.
2. Buka phpMyAdmin → database `portal_akademik` → tab SQL.
3. Jalankan query berikut dengan email yang benar-benar kamu daftarkan:

```sql
UPDATE users SET role = 'admin' WHERE email = 'admin@kampus.ac.id';
```

4. Ganti email contoh di query dengan email akunmu. Keluar dari sesi, kemudian masuk kembali.
5. Admin dapat membuka `http://localhost/portal_layanan_akademik/admin/`.

Gunakan password kuat dan jangan mempublikasikan kredensial. Untuk server produksi, siapkan pembuatan admin melalui proses provisioning yang dikontrol, HTTPS, pembatasan percobaan login, audit log, dan konfigurasi rahasia di luar source code.

## Fitur pengguna
- Registrasi akun dengan nama, email, NIM, fakultas, program studi, dan password.
- Login dan logout.
- Dashboard ringkasan permohonan.
- Form permohonan dengan validasi HTML/server-side.
- Riwayat permohonan dan statusnya.

## Fitur administrator
- Dashboard statistik.
- Melihat dan mencari pengguna berdasarkan nama, email, atau NIM.
- Membuka detail profil pengguna dan riwayat permohonan.
- Melihat semua permohonan dan memperbarui status.
- Mengaktifkan/nonaktifkan layanan.

## Pengujian responsif dan aksesibilitas (wajib didokumentasikan)
Aplikasi ini disiapkan dengan breakpoint mobile-first, layout Grid/Flexbox, `meta viewport`, tautan “Lewati ke konten utama”, label form, elemen semantik, fokus keyboard terlihat, dan dukungan `prefers-reduced-motion`. **Lakukan pengujian nyata pada browser yang kamu gunakan dan simpan screenshot sebagai bukti; README ini bukan bukti bahwa pengujian sudah dilakukan.**

### Checklist Browser DevTools
1. Buka `http://localhost/portal_layanan_akademik/`.
2. Tekan `F12` atau `Ctrl+Shift+I` untuk membuka DevTools.
3. **Responsive Design Mode / Device Toolbar** (`Ctrl+Shift+M`): uji viewport 360 px, 768 px, dan 1280 px. Periksa bahwa konten tetap terbaca dan tidak ada horizontal scroll halaman.
4. **Elements / Inspector**: periksa struktur `header`, `nav`, `main`, `section`, `article`, `form`, dan `footer`; pastikan heading berurutan.
5. **Keyboard**: tekan `Tab` berulang kali; fokus harus terlihat dan urutan navigasi masuk akal. Uji tautan “Lewati ke konten utama”.
6. **Form**: coba kirim registrasi tanpa nama/email/password; browser seharusnya menunjukkan validasi. Uji email tidak valid dan kata sandi kurang dari 8 karakter. Coba kirim permohonan tanpa memilih layanan.
7. **Network**: aktifkan “Disable cache”, reload halaman, dan pastikan file CSS serta dokumen PHP berhasil dimuat. Periksa apakah ada request gagal. Google Fonts memerlukan internet; font fallback tetap tersedia jika offline.
8. **Accessibility**: jika tersedia, gunakan panel Accessibility/Inspector atau Lighthouse. Catat temuan dan perbaikan; jangan menyatakan skor yang belum benar-benar dijalankan.
9. Ulangi tes pada halaman login, dashboard user, dan panel admin.

### Bukti yang disarankan
Simpan screenshot buatan sendiri dalam folder `evidence/`:
- `01-home-360px.png`
- `02-home-768px.png`
- `03-home-1280px.png`
- `04-form-validation.png`
- `05-devtools-elements.png`
- `06-devtools-network.png`
- `07-accessibility-keyboard.png`
- `08-user-dashboard.png`
- `09-admin-dashboard.png`

Catat juga hasil aktual: ukuran viewport, browser, ada/tidaknya overflow, hasil validasi form, error di Console/Network, serta perbaikan yang dilakukan.

## Catatan
- Ini adalah prototipe pembelajaran, bukan sistem akademik produksi.
- Status dan layanan adalah alur demo. Keputusan akademik sebenarnya tetap perlu proses resmi institusi.
- Password disimpan menggunakan `password_hash()`; login menggunakan `password_verify()`.
- Query menggunakan prepared statements dan output HTML di-escape.
- Sebelum deploy, aktifkan HTTPS, atur cookie sesi yang aman, tambahkan pembatasan percobaan login, logging, backup, kebijakan privasi, dan review keamanan.
