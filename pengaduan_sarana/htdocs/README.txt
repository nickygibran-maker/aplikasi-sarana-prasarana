APLIKASI SARANA DAN PRASARANA

Paket ini dapat dijalankan di XAMPP atau disiapkan untuk hosting PHP + MySQL.

MENJALANKAN DI XAMPP
1. Salin folder aplikasi-sarana-prasarana ke C:\xampp\htdocs\
2. Jalankan Apache dan MySQL dari XAMPP.
3. Buka http://localhost/phpmyadmin
4. Buat database bernama sarpras, pilih database itu, lalu jalankan DATABASE/sarpras_final.sql di tab SQL.
5. Periksa MODEL/config.php: host=localhost, username=root, password kosong,
   database=sarpras (sesuaikan bila konfigurasi MySQL lokal berbeda).
6. Buka http://localhost/aplikasi-sarana-prasarana/

MENJALANKAN DI HOSTING GRATIS
Baca PANDUAN_HOSTING_GRATIS.txt. Hosting belum dibuat otomatis; kamu perlu
membuat akun, memilih subdomain gratis, membuat database, mengimpor SQL,
memasukkan detail koneksi di MODEL/config.php, lalu mengunggah file aplikasi.

LOGIN DATA CONTOH (dari DATABASE/sarpras_final.sql)
Admin : admin01 / admin123
Siswa : NIS 2026101 / siswa123

Database sudah pernah dibuat? Jalankan lagi DATABASE/sarpras_final.sql (akan membuat ulang tabel dan data contoh).

Keamanan: ubah password admin dan semua password siswa contoh sebelum website dibagikan ke publik.
Password siswa disimpan dalam bentuk hash (tidak bisa dibaca dari database).
Jangan membagikan file MODEL/config.php karena berisi akses database.
