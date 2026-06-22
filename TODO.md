# TODO - Dashboard Sitter (sesuaikan database)

## Step 1
- Update `app/Http/Controllers/SitterController.php` agar:
  - metric (Penitipan Hari Ini, Menunggu Konfirmasi, Total Hewan Diasuh) tetap dari DB
  - `jadwal` diambil pakai JOIN dari tabel: `pemesanan` + `user` + `hewan` + `layanan`
  - pilih kolom yang dibutuhkan view (nama pemilik, nama hewan, nama layanan, jam/tanggal, status)

## Step 2
- Update `resources/views/dashboard-sitter.blade.php` agar:
  - hardcode metric diganti dengan variabel dari controller
  - hardcode daftar jadwal diganti loop `@foreach($jadwal as ...)`

## Step 3
- Jalankan testing:
  - `php artisan config:clear`
  - Buka `/dashboard-sitter`
  - Pastikan tidak ada error nama kolom/relasi.

