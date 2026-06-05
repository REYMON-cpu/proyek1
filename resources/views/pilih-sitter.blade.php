<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Pet Sitter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#F4F7F6] text-[#2D433E] min-h-screen flex flex-col justify-between">

    <nav class="w-full bg-white border-b border-[#5E887E]/10 py-4 sticky top-0 z-50 backdrop-blur-md bg-white/80 px-6 md:px-12 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <a href="/dashboard" class="mr-3 text-gray-400 hover:text-[#5E887E] hover:scale-110 transition-all duration-200 text-lg" title="Kembali ke Dashboard">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <img src="{{ asset('images/logo hijau.svg') }}" alt="Logo" class="h-12 w-auto">
            <span class="text-xl font-bold text-[#5E887E]">Go<span class="text-[#D9B08C]">Pet</span></span>
        </div>

        <div class="relative w-full sm:w-80">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400 text-sm"></i>
            <input type="text" placeholder="Cari nama pet sitter..." class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-gray-100 text-sm focus:outline-none focus:border-[#5E887E] focus:ring-2 focus:ring-[#5E887E] bg-[#F8FBF0] transition-all">
        </div>
    </nav>

    <main class="w-full px-6 md:px-12 py-10 flex-grow">
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold tracking-tight">Pilih Pet Sitter</h1>
            <p class="text-[#5E887E] font-medium text-sm mt-1">Sitter kami telah diverifikasi identitasnya lewat KTP, SKCK, dan sertifikat keahlian mendasar.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 w-full">

            <div class="bg-white rounded-[35px] p-6 border border-white shadow-sm flex flex-col justify-between hover:-translate-y-1 transition-all duration-300">
                <div>
                    <div class="relative w-24 h-24 mx-auto mb-4">
                        <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=sitter1" alt="Pet Sitter" class="w-full h-full rounded-2xl bg-[#F8FBF0] object-cover border border-gray-100">
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 bg-[#D9B08C] border-2 border-white rounded-full flex items-center justify-center" title="Identitas Aman">
                            <i class="fa-solid fa-shield text-white text-[10px]"></i>
                        </span>
                    </div>

                    <div class="text-center mb-4">
                        <h3 class="font-bold text-lg text-[#2D433E]">Aurellia Ledy</h3>
                        <p class="text-xs font-semibold text-[#5E887E] bg-[#F4F7F6] px-3 py-1 rounded-full inline-block mt-1">Cat Lovers</p>
                    </div>

                    <p class="text-xs text-gray-400 text-center line-clamp-2 px-2 mb-4 italic">
                        "Berpengalaman merawat kucing galak dan anjing aktif. Siap menemani anabul bermain di rumah Anda."
                    </p>

                    <div class="border-t border-b border-gray-100 py-3 my-4 space-y-2 text-sm text-[#2D433E]">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5"><i class="fa-solid fa-briefcase w-4 text-[#5E887E]"></i> Pengalaman:</span>
                            <span class="font-bold text-xs">3 Tahun</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5"><i class="fa-solid fa-id-card w-4 text-[#D9B08C]"></i> Dokumen SKCK:</span>
                            <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-md flex items-center gap-1">Terverifikasi</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5"><i class="fa-solid fa-award text-w-4 text-blue-400"></i> Sertifikat:</span>
                            <span class="font-bold text-xs text-gray-500">Pet Handling 101</span>
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="flex items-baseline justify-between mb-3 px-1">
                        <span class="text-xs text-gray-400">Tarif Jasa:</span>
                        <span class="text-lg font-extrabold text-[#5E887E]">Rp 75.000<span class="text-[10px] font-normal text-gray-400">/hari</span></span>
                    </div>

                    <div class="flex gap-2">
                        <a href="/chat" class="w-12 h-12 bg-[#F8FBF0] hover:bg-[#5E887E]/10 border border-[#5E887E]/20 text-[#5E887E] rounded-2xl flex items-center justify-center transition-all shadow-sm active:scale-95" title="Hubungi Sitter via Chat">
                            <i class="fa-solid fa-comment-dots text-lg"></i>
                        </a>
                        <a href="/pesan-layanan/4" class="flex-1 bg-[#2D433E] hover:bg-[#5E887E] text-white font-bold py-3 rounded-2xl text-sm transition-all shadow-md active:scale-95 text-center flex items-center justify-center">
                            Pesan Sitter
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[35px] p-6 border border-white shadow-sm flex flex-col justify-between hover:-translate-y-1 transition-all duration-300">
                <div>
                    <div class="relative w-24 h-24 mx-auto mb-4">
                        <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=sitter2" alt="Pet Sitter" class="w-full h-full rounded-2xl bg-[#F8FBF0] object-cover border border-gray-100">
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 bg-[#D9B08C] border-2 border-white rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-shield text-white text-[10px]"></i>
                        </span>
                    </div>

                    <div class="text-center mb-4">
                        <h3 class="font-bold text-lg text-[#2D433E]">Silviana Novita</h3>
                        <p class="text-xs font-semibold text-[#5E887E] bg-[#F4F7F6] px-3 py-1 rounded-full inline-block mt-1">Cat Lover Sitter</p>
                    </div>

                    <p class="text-xs text-gray-400 text-center line-clamp-2 px-2 mb-4 italic">
                        "Spesialis mendampingi kucing pasca-steril atau kucing senior yang butuh perhatian ekstra lembut."
                    </p>

                    <div class="border-t border-b border-gray-100 py-3 my-4 space-y-2 text-sm text-gray-600">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5"><i class="fa-solid fa-briefcase w-4 text-[#5E887E]"></i> Pengalaman:</span>
                            <span class="font-bold text-xs">1 Tahun</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5"><i class="fa-solid fa-id-card w-4 text-[#D9B08C]"></i> Dokumen SKCK:</span>
                            <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-md flex items-center gap-1">Terverifikasi</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs flex items-center gap-1.5"><i class="fa-solid fa-award text-w-4 text-blue-400"></i> Sertifikat:</span>
                            <span class="font-bold text-xs text-gray-500">Tidak ada</span>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-baseline justify-between mb-3 px-1">
                        <span class="text-xs text-gray-400">Tarif Jasa:</span>
                        <span class="text-lg font-extrabold text-[#5E887E]">Rp 60.000<span class="text-[10px] font-normal text-gray-400">/hari</span></span>
                    </div>

                    <div class="flex gap-2">
                        <a href="/chat" class="w-12 h-12 bg-[#F8FBF0] hover:bg-[#5E887E]/10 border border-[#5E887E]/20 text-[#5E887E] rounded-2xl flex items-center justify-center transition-all shadow-sm active:scale-95" title="Hubungi Sitter via Chat">
                            <i class="fa-solid fa-comment-dots text-lg"></i>
                        </a>
                        <a href="/pesan-layanan/5" class="flex-1 bg-[#2D433E] hover:bg-[#5E887E] text-white font-bold py-3 rounded-2xl text-sm transition-all shadow-md active:scale-95 text-center flex items-center justify-center">
                            Pesan Sitter
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="w-full bg-white border-t border-gray-100 py-6 text-center text-xs text-gray-400">
        <p>&copy; 2026 Go Team. All rights reserved.</p>
    </footer>

</body>
</html>