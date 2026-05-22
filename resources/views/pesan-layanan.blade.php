<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Layanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .form-load {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .form-loaded {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-[#F4F7F6] text-[#2D433E]">
    <div id="konten-pemesanan" class="container mx-auto px-6 py-12 max-w-4xl form-load">

        <div class="flex justify-between items-center mb-10">
            <a href="javascript:history.back()" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#2D433E] shadow-sm hover:bg-[#5E887E] hover:text-white transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="text-right">
                <h1 class="text-3xl font-extrabold tracking-tight">Detail Pesanan</h1>
                <p class="text-[#5E887E] font-medium text-sm">Layanan Home-Visit Bandung</p>
            </div>
        </div>

        <form action="/proses-pemesanan" method="POST" class="space-y-8">
            @csrf

            <div class="bg-[#5E887E] p-6 rounded-[35px] text-white flex items-center gap-5 shadow-lg shadow-[#5E887E]/20">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-2xl">
                    <i class="fas fa-user-md"></i>
                </div>
                <div>
                    <p class="text-xs opacity-80 font-bold uppercase tracking-widest">Anda Memesan Layanan:</p>
                    <h3 class="text-xl font-bold italic">drh. Jinten Anggraeni</h3>
                    <p class="text-xs bg-white/20 px-2 py-0.5 rounded-md inline-block mt-1">Biaya Kunjungan: Rp 150.000</p>
                </div>
                <input type="hidden" name="id_mitra" value="123">
            </div>

            <div class="bg-white p-10 rounded-[45px] shadow-sm border border-white">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 bg-[#5E887E]/10 text-[#5E887E] rounded-2xl flex items-center justify-center text-xl">
                        <i class="fas fa-paw"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Data Hewan</h2>
                        <p class="text-sm text-gray-400">Informasi hewan yang akan dirawat</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Nama Hewan</label>
                        <input type="text" name="nama_hewan" required placeholder="Misal: Abdul" class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-2 border-transparent focus:border-[#5E887E] focus:bg-white outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Jenis Hewan</label>
                        <select name="jenis_hewan" required class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-2 border-transparent focus:border-[#5E887E] focus:bg-white outline-none transition-all">
                            <option value="">Pilih Jenis</option>
                            <option value="kucing">Kucing</option>
                            <option value="anjing">Anjing</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Umur</label>
                        <input type="text" name="umur_hewan" placeholder="Misal: 2 Tahun" class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-2 border-transparent focus:border-[#5E887E] focus:bg-white outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Riwayat Kesehatan (Opsional)</label>
                        <input type="text" name="riwayat_kesehatan" placeholder="Alergi obat, dll" class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-2 border-transparent focus:border-[#5E887E] focus:bg-white outline-none transition-all">
                    </div>
                </div>
            </div>

            <div class="bg-white p-10 rounded-[45px] shadow-sm border border-white">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 bg-[#D9B08C]/10 text-[#D9B08C] rounded-2xl flex items-center justify-center text-xl">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Jadwal & Lokasi</h2>
                        <p class="text-sm text-gray-400">Tentukan kapan kami harus datang</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" required class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-2 border-transparent focus:border-[#D9B08C] focus:bg-white outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 ml-2">Jam Kedatangan</label>
                        <input type="time" name="jam_kunjungan" required class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-2 border-transparent focus:border-[#D9B08C] focus:bg-white outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase text-gray-400 ml-2">Alamat Lengkap (Bandung)</label>
                    <textarea name="alamat" required placeholder="Nama jalan, nomor rumah, atau patokan lokasi..." class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-2 border-transparent focus:border-[#D9B08C] focus:bg-white outline-none transition-all h-32"></textarea>
                </div>
            </div>

            <div class="bg-white p-10 rounded-[45px] shadow-sm border border-white">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 bg-[#2D433E]/10 text-[#2D433E] rounded-2xl flex items-center justify-center text-xl">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h2 class="text-xl font-bold">Catatan Untuk Petugas</h2>
                </div>
                <textarea name="catatan" placeholder="Jelaskan keluhan hewan (untuk Dokter) atau instruksi khusus (untuk Sitter)..." class="w-full p-4 rounded-2xl bg-[#F8FBF0] border-2 border-transparent focus:border-[#2D433E] focus:bg-white outline-none transition-all h-24"></textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-6 bg-[#2D433E] text-white rounded-[30px] font-extrabold text-xl hover:bg-[#5E887E] transition-all shadow-xl flex items-center justify-center gap-3">
                    Konfirmasi Pemesanan <i class="fas fa-chevron-right text-sm"></i>
                </button>
                <p class="text-center text-gray-400 text-xs mt-6">Dengan menekan tombol, Anda menyetujui syarat & ketentuan Pawrawat.</p>
            </div>
        </form>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                document.getElementById('konten-pemesanan').classList.add('form-loaded');
            }, 50);
        });
    </script>
</body>
</html>
