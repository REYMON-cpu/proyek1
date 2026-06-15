<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pet Sitter — GoPet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAF9F6; color: #2D433E; }
        .sidebar-link.active { background-color: #5E887E; color: white; box-shadow: 0 10px 25px -5px rgba(94,136,126,0.3); }
        .sidebar-link.active i { color: white; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(94,136,126,0.2); border-radius: 10px; }
        .modal-overlay { display: none; }
        .modal-overlay.show { display: flex; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
    </style>
</head>
<body class="antialiased flex h-screen overflow-hidden">

  <!-- SIDEBAR -->
  <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white border-r border-[#5E887E]/10 flex flex-col justify-between p-6 h-full z-[60] transform transition-transform duration-300 ease-in-out">
    <div class="space-y-8">

      <!-- Logo -->
    <div class="flex items-center justify-between px-2">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo hijau.svg') }}" alt="Logo" class="h-12 w-auto">
            <div>
                <h2 class="text-xl font-bold text-[#5E887E] tracking-tight">Go<span class="text-[#D9B08C]">Pet</span></h2>
                <span class="text-[10px] font-bold text-[#5E887E] uppercase tracking-widest block -mt-1">Sitter Panel</span>
            </div>
        </div>
        <button onclick="toggleSidebar()" class="w-9 h-9 rounded-xl bg-gray-50 flex items-center justify-center text-[#5E887E] hover:bg-gray-100 lg:hidden">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <!-- Nav -->
      <nav class="space-y-1">
        <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-[#5E887E] px-3 mb-3">Menu Utama</p>

        <button onclick="switchTab('dashboard')" id="btn-tab-dashboard"
          class="sidebar-link active w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-chart-pie text-base w-5 text-center"></i> Dashboard
        </button>

        <button onclick="switchTab('jadwal')" id="btn-tab-jadwal"
          class="sidebar-link text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-calendar-days text-base w-5 text-center"></i> Jadwal Penitipan
        </button>

        <button onclick="switchTab('catatan')" id="btn-tab-catatan"
          class="sidebar-link text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-clipboard-list text-base w-5 text-center"></i> Catatan Harian
        </button>

        <button onclick="switchTab('chat')" id="btn-tab-chat"
          class="sidebar-link text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-comments text-base w-5 text-center"></i> Chat Pemilik
          <span id="badge-chat" class="ml-auto bg-[#5E887E] text-white text-[9px] font-bold px-2 py-0.5 rounded-full">2</span>
        </button>

        <button onclick="switchTab('profil')" id="btn-tab-profil"
          class="sidebar-link text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-circle-user text-base w-5 text-center"></i> Tarif
        </button>
      </nav>
    </div>

    <!-- Profile & Logout -->
    <div class="space-y-3">
      <div class="flex items-center gap-3 px-3 py-3 bg-[#E8F0EE]/40 rounded-2xl">
        <div class="w-10 h-10 rounded-xl bg-[#5E887E] flex items-center justify-center text-white text-sm font-bold">DP</div>
        <div>
          <div class="text-sm font-bold text-[#2D433E]">Dimas Pratama</div>
          <div id="sidebar-status-text" class="text-[10px] text-[#5E887E] font-semibold">● Tersedia</div>
        </div>
      </div>
      <div class="border-t border-[#5E887E]/10 pt-3">
        <button onclick="alert('Fungsi logout aplikasi.')" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-50 font-bold text-sm transition-all">
          <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i> Keluar Aplikasi
        </button>
      </div>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <div id="main-content" class="flex-1 flex flex-col h-full overflow-y-auto lg:pl-72 transition-all duration-300">

    <!-- TOPBAR -->
    <header class="px-6 md:px-10 pt-6 pb-2 flex justify-between items-center sticky top-0 bg-[#FAF9F6]/90 backdrop-blur-sm z-40">
      <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" class="w-11 h-11 bg-white rounded-2xl border border-gray-100 shadow-sm flex items-center justify-center text-gray-500 hover:text-[#5E887E] transition-all">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div>
          <h1 id="page-title" class="text-xl md:text-2xl font-black text-[#2D433E] tracking-tight">Halo, Kak Dimas! 🐾</h1>
          <p id="page-desc" class="text-xs text-[#5E887E] font-medium mt-0.5 hidden sm:block">Ringkasan aktivitas penitipan dan status Anda hari ini.</p>
        </div>
      </div>


      <!-- Status Indicator -->
      <div class="flex items-center gap-3">
        <div id="status-pill" class="flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
          <div id="status-dot" class="w-2 h-2 rounded-full bg-green-600"></div>
          <span id="status-label">Tersedia</span>
        </div>
      </div>
    </header>

    <!-- ===== TAB: DASHBOARD ===== -->
    <div id="tab-dashboard" class="tab-content active">
        <main class="px-6 md:px-10 py-6 space-y-8">

       <!-- Metric Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-[28px] border border-[#5E887E]/5 shadow-sm flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#5E887E]">Penitipan Hari Ini</p>
                    <h3 class="text-2xl font-black text-[#2D433E] mt-1">5 <span class="text-xs font-medium text-[#5E887E]">sesi</span></h3>
                </div>
                <div class="w-12 h-12 bg-[#5E887E]/10 rounded-2xl flex items-center justify-center text-[#5E887E] text-xl"><i class="fa-solid fa-dog"></i></div>
            </div>

            <div class="bg-white p-5 rounded-[28px] border border-[#5E887E]/5 shadow-sm flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#5E887E]">Menunggu Konfirmasi</p>
                    <h3 class="text-2xl font-black text-amber-600 mt-1">3 <span class="text-xs font-medium text-[#5E887E]">booking</span></h3>
                </div>
                <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-600 text-xl"><i class="fa-solid fa-clock"></i></div>
            </div>

            <div class="bg-white p-5 rounded-[28px] border border-[#5E887E]/5 shadow-sm flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#5E887E]">Total Hewan yang telah diasuh</p>
                    <h3 class="text-2xl font-black text-[#2D433E] mt-1">142 <span class="text-xs font-medium text-[#5E887E]">hewan</span></h3>
                </div>
                <div class="w-12 h-12 bg-teal-500/10 rounded-2xl flex items-center justify-center text-teal-600 text-xl"><i class="fa-solid fa-circle-check"></i></div>
            </div>
        </div>

        <!-- Jadwal Hari Ini + Chat Preview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

          <!-- Jadwal Preview -->
          <div class="bg-white rounded-[32px] border border-gray-100 p-6 shadow-sm">
            <div class="flex justify-between items-start mb-5">
              <div>
                <h3 class="text-base font-extrabold text-[#2D433E]">Jadwal Hari Ini</h3>
                <p class="text-xs text-[#5E887E] mt-0.5">Sabtu, 13 Juni 2026</p>
              </div>
              <button onclick="switchTab('jadwal')" class="text-xs font-bold text-[#5E887E] hover:underline">Lihat Semua →</button>
            </div>
            <div class="space-y-3">
              <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#FAF9F6] border border-gray-50">
                <div class="text-center min-w-[44px]">
                  <div class="text-[10px] font-bold text-[#5E887E]">07.30</div>
                </div>
                <div class="w-9 h-9 rounded-xl bg-[#D9B08C]/10 flex items-center justify-center text-[#D9B08C] text-xs font-bold">AP</div>
                <div class="flex-1">
                  <div class="text-xs font-bold text-[#2D433E]">Andi Pratama</div>
                  <div class="text-[10px] text-[#5E887E]">Bruno — Anjing Golden Retriever • Dog Walking</div>
                </div>
                <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold">Selesai</span>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#FAF9F6] border border-gray-50">
                <div class="text-center min-w-[44px]">
                  <div class="text-[10px] font-bold text-[#5E887E]">09.00</div>
                </div>
                <div class="w-9 h-9 rounded-xl bg-blue-400/10 flex items-center justify-center text-blue-500 text-xs font-bold">MS</div>
                <div class="flex-1">
                  <div class="text-xs font-bold text-[#2D433E]">Maya Sari</div>
                  <div class="text-[10px] text-[#5E887E]">Kiki — Kucing Domestik • Pet Hotel (Hari 2/3)</div>
                </div>
                <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold">Berlangsung</span>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#FAF9F6] border border-gray-50">
                <div class="text-center min-w-[44px]">
                  <div class="text-[10px] font-bold text-[#5E887E]">13.00</div>
                </div>
                <div class="w-9 h-9 rounded-xl bg-green-400/10 flex items-center justify-center text-green-600 text-xs font-bold">FN</div>
                <div class="flex-1">
                  <div class="text-xs font-bold text-[#2D433E]">Fajar Nugroho</div>
                  <div class="text-[10px] text-[#5E887E]">Coco — Anjing Pomeranian • Day Care</div>
                </div>
                <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold">Menunggu</span>
              </div>
            </div>
          </div>

          <!-- Chat Preview -->
          <div class="bg-white rounded-[32px] border border-gray-100 p-6 shadow-sm">
            <div class="flex justify-between items-start mb-5">
              <div>
                <h3 class="text-base font-extrabold text-[#2D433E]">Pesan Masuk</h3>
                <p class="text-xs text-[#5E887E] mt-0.5">Chat dari pemilik hewan</p>
              </div>
              <button onclick="switchTab('chat')" class="text-xs font-bold text-[#5E887E] hover:underline">Lihat Semua →</button>
            </div>
            <div class="space-y-3">
              <div class="flex items-center gap-3 p-3 rounded-2xl hover:bg-[#FAF9F6] cursor-pointer transition-all border border-transparent hover:border-gray-50">
                <div class="w-2 h-2 rounded-full bg-[#5E887E] flex-shrink-0"></div>
                <div class="w-9 h-9 rounded-xl bg-[#D9B08C]/10 flex items-center justify-center text-[#D9B08C] text-xs font-bold flex-shrink-0">AP</div>
                <div class="flex-1 min-w-0">
                  <div class="text-xs font-bold text-[#2D433E]">Andi Pratama</div>
                  <div class="text-[10px] text-[#5E887E] truncate">Bruno udah jalan-jalan pagi ini kak?</div>
                </div>
                <div class="text-[10px] text-[#5E887E] font-semibold flex-shrink-0">08.45</div>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-2xl hover:bg-[#FAF9F6] cursor-pointer transition-all border border-transparent hover:border-gray-50">
                <div class="w-2 h-2 rounded-full bg-[#5E887E] flex-shrink-0"></div>
                <div class="w-9 h-9 rounded-xl bg-blue-400/10 flex items-center justify-center text-blue-500 text-xs font-bold flex-shrink-0">MS</div>
                <div class="flex-1 min-w-0">
                  <div class="text-xs font-bold text-[#2D433E]">Maya Sari</div>
                  <div class="text-[10px] text-[#5E887E] truncate">Kiki minta obat jam 3 ya, taruh di tasnya</div>
                </div>
                <div class="text-[10px] text-[#5E887E] font-semibold flex-shrink-0">Kemarin</div>
              </div>
              <div class="flex items-center gap-3 p-3 rounded-2xl hover:bg-[#FAF9F6] cursor-pointer transition-all border border-transparent hover:border-gray-50">
                <div class="w-2 h-2 rounded-full bg-transparent flex-shrink-0"></div>
                <div class="w-9 h-9 rounded-xl bg-green-400/10 flex items-center justify-center text-green-600 text-xs font-bold flex-shrink-0">FN</div>
                <div class="flex-1 min-w-0">
                  <div class="text-xs font-bold text-[#2D433E]">Fajar Nugroho</div>
                  <div class="text-[10px] text-[#5E887E] truncate">Makasih banyak udah jagain Coco kemarin!</div>
                </div>
                <div class="text-[10px] text-[#5E887E] font-semibold flex-shrink-0">Kemarin</div>
              </div>
            </div>
          </div>
        </div>

      </main>
    </div>

    <!-- ===== TAB: JADWAL PENITIPAN ===== -->
    <div id="tab-jadwal" class="tab-content">
      <main class="px-6 md:px-10 py-6">
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
              <h3 class="text-lg font-extrabold text-[#2D433E]">Jadwal Penitipan</h3>
              <p class="text-xs text-[#5E887E] mt-0.5">Kelola sesi penjagaan dan konfirmasi booking harian.</p>
            </div>
            <button onclick="openJadwalModal('create')" class="px-4 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all flex items-center gap-2 shadow-md">
              <i class="fa-solid fa-plus"></i> Tambah Jadwal
            </button>
          </div>

          <div class="space-y-3" id="jadwal-list">
            <!-- Row 1 -->
            <div id="jadwal-row-1" class="flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-gray-50 bg-[#FAF9F6]/60 hover:bg-[#FAF9F6] transition-all">
              <div class="text-xs font-bold text-[#5E887E] w-12">07.30</div>
              <div class="w-10 h-10 rounded-xl bg-[#D9B08C]/10 flex items-center justify-center text-[#D9B08C] text-xs font-bold">AP</div>
              <div class="flex-1 min-w-[120px]">
                <div class="text-sm font-bold text-[#2D433E] cell-j-nama">Andi Pratama</div>
                <div class="text-[10px] text-[#5E887E] cell-j-hewan">Bruno — Anjing Golden Retriever • Dog Walking</div>
              </div>
              <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold cell-j-status">Selesai</span>
              <div class="flex gap-2">
                <button onclick="openJadwalModal('edit', 1)" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                <button onclick="deleteJadwal(1)" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
              </div>
            </div>
            <!-- Row 2 -->
            <div id="jadwal-row-2" class="flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-blue-50 bg-blue-50/30 hover:bg-blue-50/50 transition-all">
              <div class="text-xs font-bold text-[#5E887E] w-12">09.00</div>
              <div class="w-10 h-10 rounded-xl bg-blue-400/10 flex items-center justify-center text-blue-500 text-xs font-bold">MS</div>
              <div class="flex-1 min-w-[120px]">
                <div class="text-sm font-bold text-[#2D433E] cell-j-nama">Maya Sari</div>
                <div class="text-[10px] text-[#5E887E] cell-j-hewan">Kiki — Kucing Domestik • Pet Hotel (Hari 2/3)</div>
              </div>
              <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold cell-j-status">Berlangsung</span>
              <div class="flex gap-2">
                <button onclick="confirmJadwal(2)" class="w-8 h-8 bg-green-50 text-green-600 rounded-lg text-xs flex items-center justify-center hover:bg-green-500 hover:text-white transition-all" title="Tandai Selesai"><i class="fa-solid fa-check"></i></button>
                <button onclick="openJadwalModal('edit', 2)" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                <button onclick="deleteJadwal(2)" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
              </div>
            </div>
            <!-- Row 3 -->
            <div id="jadwal-row-3" class="flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-amber-50 bg-amber-50/30 hover:bg-amber-50/50 transition-all">
              <div class="text-xs font-bold text-[#5E887E] w-12">13.00</div>
              <div class="w-10 h-10 rounded-xl bg-green-400/10 flex items-center justify-center text-green-600 text-xs font-bold">FN</div>
              <div class="flex-1 min-w-[120px]">
                <div class="text-sm font-bold text-[#2D433E] cell-j-nama">Fajar Nugroho</div>
                <div class="text-[10px] text-[#5E887E] cell-j-hewan">Coco — Anjing Pomeranian • Day Care</div>
              </div>
              <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold cell-j-status">Menunggu</span>
              <div class="flex gap-2">
                <button onclick="terimaJadwal(3)" class="w-8 h-8 bg-green-50 text-green-600 rounded-lg text-xs flex items-center justify-center hover:bg-green-500 hover:text-white transition-all" title="Terima"><i class="fa-solid fa-check"></i></button>
                <button onclick="tolakJadwal(3)" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all" title="Tolak"><i class="fa-solid fa-xmark"></i></button>
                <button onclick="openJadwalModal('edit', 3)" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
              </div>
            </div>
            <!-- Row 4 -->
            <div id="jadwal-row-4" class="flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-amber-50 bg-amber-50/30 hover:bg-amber-50/50 transition-all">
              <div class="text-xs font-bold text-[#5E887E] w-12">16.00</div>
              <div class="w-10 h-10 rounded-xl bg-[#5E887E]/10 flex items-center justify-center text-[#5E887E] text-xs font-bold">RW</div>
              <div class="flex-1 min-w-[120px]">
                <div class="text-sm font-bold text-[#2D433E] cell-j-nama">Rini Wulandari</div>
                <div class="text-[10px] text-[#5E887E] cell-j-hewan">Mimi — Kucing Anggora • Home Visit</div>
              </div>
              <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold cell-j-status">Menunggu</span>
              <div class="flex gap-2">
                <button onclick="terimaJadwal(4)" class="w-8 h-8 bg-green-50 text-green-600 rounded-lg text-xs flex items-center justify-center hover:bg-green-500 hover:text-white transition-all" title="Terima"><i class="fa-solid fa-check"></i></button>
                <button onclick="tolakJadwal(4)" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all" title="Tolak"><i class="fa-solid fa-xmark"></i></button>
                <button onclick="openJadwalModal('edit', 4)" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- ===== TAB: CATATAN HARIAN ===== -->
    <div id="tab-catatan" class="tab-content">
      <main class="px-6 md:px-10 py-6">
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
              <h3 class="text-lg font-extrabold text-[#2D433E]">Catatan Perawatan Harian</h3>
              <p class="text-xs text-[#5E887E] mt-0.5">Riwayat aktivitas dan kondisi seluruh hewan yang dititipkan.</p>
            </div>
            <button onclick="openCatatanModal('create')" class="px-4 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all flex items-center gap-2 shadow-md">
              <i class="fa-solid fa-plus"></i> Tambah Catatan
            </button>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="border-b border-gray-100 text-[10px] font-extrabold text-[#5E887E] uppercase tracking-widest">
                  <th class="pb-4 pl-2">Nama Hewan</th>
                  <th class="pb-4">Pemilik</th>
                  <th class="pb-4">Layanan</th>
                  <th class="pb-4">Kondisi & Catatan</th>
                  <th class="pb-4">Tanggal</th>
                  <th class="pb-4 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody id="catatan-table-body" class="divide-y divide-gray-50 text-sm font-medium text-[#2D433E]">
                <tr id="catatan-row-1" class="hover:bg-[#FAF9F6]/50 transition-colors">
                  <td class="py-4 pl-2">
                    <div class="font-bold cell-c-hewan">Bruno</div>
                    <div class="text-[10px] text-[#5E887E] cell-c-jenis">Anjing Golden Retriever</div>
                  </td>
                  <td class="py-4 text-xs cell-c-pemilik">Andi Pratama</td>
                  <td class="py-4">
                    <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-bold cell-c-layanan">Dog Walking</span>
                  </td>
                  <td class="py-4 text-xs cell-c-catatan">Aktif &amp; ceria — jalan pagi 30 menit, makan habis, BAB normal</td>
                  <td class="py-4 text-[10px] text-[#5E887E] cell-c-tanggal">13 Jun 2026</td>
                  <td class="py-4">
                    <div class="flex justify-center gap-2">
                      <button onclick="openCatatanModal('edit', 1)" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                      <button onclick="deleteCatatan(1, 'Bruno')" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr id="catatan-row-2" class="hover:bg-[#FAF9F6]/50 transition-colors">
                  <td class="py-4 pl-2">
                    <div class="font-bold cell-c-hewan">Kiki</div>
                    <div class="text-[10px] text-[#5E887E] cell-c-jenis">Kucing Domestik</div>
                  </td>
                  <td class="py-4 text-xs cell-c-pemilik">Maya Sari</td>
                  <td class="py-4">
                    <span class="px-2 py-1 bg-amber-50 text-amber-700 rounded-full text-[10px] font-bold cell-c-layanan">Pet Hotel (Hari 2/3)</span>
                  </td>
                  <td class="py-4 text-xs cell-c-catatan">Tenang &amp; nyaman — nafsu makan baik, litter box sudah dibersihkan</td>
                  <td class="py-4 text-[10px] text-[#5E887E] cell-c-tanggal">13 Jun 2026</td>
                  <td class="py-4">
                    <div class="flex justify-center gap-2">
                      <button onclick="openCatatanModal('edit', 2)" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                      <button onclick="deleteCatatan(2, 'Kiki')" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr id="catatan-row-3" class="hover:bg-[#FAF9F6]/50 transition-colors">
                  <td class="py-4 pl-2">
                    <div class="font-bold cell-c-hewan">Coco</div>
                    <div class="text-[10px] text-[#5E887E] cell-c-jenis">Anjing Pomeranian</div>
                  </td>
                  <td class="py-4 text-xs cell-c-pemilik">Fajar Nugroho</td>
                  <td class="py-4">
                    <span class="px-2 py-1 bg-green-50 text-green-700 rounded-full text-[10px] font-bold cell-c-layanan">Day Care</span>
                  </td>
                  <td class="py-4 text-xs cell-c-catatan">Sangat aktif — bermain dengan anjing lain, sedikit takut suara petir</td>
                  <td class="py-4 text-[10px] text-[#5E887E] cell-c-tanggal">12 Jun 2026</td>
                  <td class="py-4">
                    <div class="flex justify-center gap-2">
                      <button onclick="openCatatanModal('edit', 3)" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                      <button onclick="deleteCatatan(3, 'Coco')" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>

    <!-- ===== TAB: CHAT ===== -->
    <div id="tab-chat" class="tab-content">
      <main class="px-6 md:px-10 py-6">
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="mb-6">
            <h3 class="text-lg font-extrabold text-[#2D433E]">Chat dengan Pemilik Hewan</h3>
            <p class="text-xs text-[#5E887E] mt-0.5">Update perkembangan dan komunikasi langsung via pesan.</p>
          </div>
          <div class="space-y-3">
            <!-- Chat Item 1 -->
            <div class="flex items-center gap-4 p-4 rounded-2xl border border-[#5E887E]/10 hover:bg-[#FAF9F6] cursor-pointer transition-all" onclick="openChatModal('Andi Pratama', 'AP', 'Bruno — Golden Retriever')">
              <div class="w-2 h-2 rounded-full bg-[#5E887E] flex-shrink-0"></div>
              <div class="w-11 h-11 rounded-xl bg-[#D9B08C]/10 flex items-center justify-center text-[#D9B08C] text-sm font-bold flex-shrink-0">AP</div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                  <div class="text-sm font-bold text-[#2D433E]">Andi Pratama</div>
                  <span class="px-2 py-0.5 bg-[#D9B08C]/10 text-[#D9B08C] rounded-full text-[9px] font-bold">Bruno — Retriever</span>
                </div>
                <div class="text-xs text-[#5E887E] truncate mt-0.5">Pagi kak, Bruno udah jalan-jalan?</div>
              </div>
              <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                <div class="text-[10px] text-[#5E887E] font-semibold">08.45</div>
                <div class="w-5 h-5 rounded-full bg-[#5E887E] flex items-center justify-center text-white text-[9px] font-bold">2</div>
              </div>
            </div>
            <!-- Chat Item 2 -->
            <div class="flex items-center gap-4 p-4 rounded-2xl border border-gray-50 hover:bg-[#FAF9F6] cursor-pointer transition-all" onclick="openChatModal('Maya Sari', 'MS', 'Kiki — Kucing Domestik')">
              <div class="w-2 h-2 rounded-full bg-[#5E887E] flex-shrink-0"></div>
              <div class="w-11 h-11 rounded-xl bg-blue-400/10 flex items-center justify-center text-blue-500 text-sm font-bold flex-shrink-0">MS</div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                  <div class="text-sm font-bold text-[#2D433E]">Maya Sari</div>
                  <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded-full text-[9px] font-bold">Kiki — Domestik</span>
                </div>
                <div class="text-xs text-[#5E887E] truncate mt-0.5">Kiki minta obat jam 3 ya, taruh di tasnya</div>
              </div>
              <div class="text-[10px] text-[#5E887E] font-semibold">Kemarin</div>
            </div>
            <!-- Chat Item 3 -->
            <div class="flex items-center gap-4 p-4 rounded-2xl border border-gray-50 hover:bg-[#FAF9F6] cursor-pointer transition-all" onclick="openChatModal('Fajar Nugroho', 'FN', 'Coco — Anjing Pomeranian')">
              <div class="w-2 h-2 rounded-full bg-transparent flex-shrink-0"></div>
              <div class="w-11 h-11 rounded-xl bg-green-400/10 flex items-center justify-center text-green-600 text-sm font-bold flex-shrink-0">FN</div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                  <div class="text-sm font-bold text-[#2D433E]">Fajar Nugroho</div>
                  <span class="px-2 py-0.5 bg-green-50 text-green-600 rounded-full text-[9px] font-bold">Coco — Pomeranian</span>
                </div>
                <div class="text-xs text-[#5E887E] truncate mt-0.5">Makasih banyak udah jagain Coco kemarin!</div>
              </div>
              <div class="text-[10px] text-[#5E887E] font-semibold">Kemarin</div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- ===== TAB: PROFIL & TARIF ===== -->
    <div id="tab-profil" class="tab-content">
      <main class="px-6 md:px-10 py-6 space-y-6">

        <!-- Status Panel -->
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="mb-5">
            <h3 class="text-lg font-extrabold text-[#2D433E]">Status Ketersediaan</h3>
            <p class="text-xs text-[#5E887E] mt-0.5">Update status real-time Anda agar terlihat pemilik hewan.</p>
          </div>
          <div class="flex flex-wrap gap-3">
            <button onclick="setStatus('tersedia')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-green-200 bg-green-50 text-green-800 hover:border-green-500 transition-all selected-status" data-status="tersedia">
              <i class="fa-solid fa-circle-check mr-1.5"></i> Tersedia
            </button>
            <button onclick="setStatus('perjalanan')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-amber-200 bg-amber-50 text-amber-800 hover:border-amber-500 transition-all" data-status="perjalanan">
              <i class="fa-solid fa-car mr-1.5"></i> Dalam Perjalanan
            </button>
            <button onclick="setStatus('menjaga')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-blue-200 bg-blue-50 text-blue-800 hover:border-blue-500 transition-all" data-status="menjaga">
              <i class="fa-solid fa-paw mr-1.5"></i> Sedang Menjaga
            </button>
            <button onclick="setStatus('off')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-teal-200 bg-teal-50 text-teal-800 hover:border-teal-500 transition-all" data-status="off">
              <i class="fa-solid fa-moon mr-1.5"></i> Tidak Bertugas
            </button>
          </div>
        </div>

        <!-- Profil Form -->
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
        <div class="mb-5">
            <h3 class="text-lg font-extrabold text-[#2D433E]">Pengajuan Kenaikan Tarif Pet Sitter</h3>
            <p class="text-xs text-[#5E887E] mt-0.5">Formulir ini digunakan untuk mengajukan penyesuaian tarif jasa penitipan. Perubahan akan berlaku setelah diverifikasi oleh Admin.</p>
        </div>

        <form onsubmit="submitPengajuanTarif(event)" class="space-y-4" enctype="multipart/form-data">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <!-- Nama Lengkap (Disabled/Read-only karena otomatis dari akun) -->
            <div>
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                <input type="text" value="Dimas Pratama" disabled class="w-full px-4 py-2.5 bg-[#F5F5F3] border border-gray-100 rounded-xl text-xs font-semibold text-[#5E887E] cursor-not-allowed focus:outline-none">
            </div>

            <!-- Layanan (Disabled/Read-only) -->
            <div>
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Layanan</label>
                <input type="text" value="Pet Sitter — Dog Walking & Pet Hotel" disabled class="w-full px-4 py-2.5 bg-[#F5F5F3] border border-gray-100 rounded-xl text-xs font-semibold text-[#5E887E] cursor-not-allowed focus:outline-none">
            </div>

            <!-- Tarif Saat Ini -->
            <div>
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Tarif Saat Ini (Per Hari)</label>
                <input type="text" value="Rp 75.000" disabled class="w-full px-4 py-2.5 bg-[#F5F5F3] border border-gray-100 rounded-xl text-xs font-semibold text-[#5E887E] cursor-not-allowed focus:outline-none">
            </div>

            <!-- Usulan Tarif Baru -->
            <div>
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Usulan Tarif Baru (Rp)</label>
                <input type="number" placeholder="Contoh: 100000" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E] focus:ring-1 focus:ring-[#5E887E]/20">
            </div>

            <!-- Upload Berkas Pendukung -->
            <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Upload Berkas Pendukung (Sertifikat/Pengalaman)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl bg-[#FAF9F6] hover:border-[#5E887E] transition-colors relative">
                <div class="space-y-1 text-center">
                    <i class="fa-solid fa-cloud-arrow-up text-[#5E887E] text-2xl mb-2 block"></i>
                    <div class="flex text-xs text-[#5E887E] justify-center">
                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-bold text-[#5E887E] hover:text-[#4d7168] focus-within:outline-none">
                        <span>Pilih Berkas</span>
                        <input id="file-upload" name="file-upload" type="file" accept=".pdf,.png,.jpg,.jpeg" required class="sr-only">
                    </label>
                    <p class="pl-1 text-[#5E887E] font-medium">atau drag and drop</p>
                    </div>
                    <p class="text-[10px] text-[#5E887E]">PDF, PNG, atau JPG maksimal 5MB</p>
                </div>
                </div>
            </div>

            <!-- Alasan Pengajuan -->
            <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Alasan / Keterangan Pengajuan</label>
                <textarea rows="3" placeholder="Tuliskan alasan penyesuaian tarif di sini..." required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E] focus:ring-1 focus:ring-[#5E887E]/20 resize-none"></textarea>
            </div>
            </div>

            <!-- Tombol Submit -->
            <div class="pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all shadow-md">
                <i class="fa-solid fa-paper-plane mr-1.5"></i> Kirim Pengajuan ke Admin
            </button>
            </div>
        </form>
        </div>

            </main>
            </div>

        </div>

        <!-- ===== MODAL: JADWAL ===== -->
        <div id="jadwalModal" class="modal-overlay fixed inset-0 bg-[#2D433E]/40 backdrop-blur-sm z-[100] items-center justify-center p-4">
            <div class="bg-white rounded-[28px] w-full max-w-md p-6 border border-gray-100 shadow-2xl">
            <div class="flex items-center justify-between mb-5">
                <h4 id="jadwalModalTitle" class="text-base font-black text-[#2D433E]">Tambah Jadwal Baru</h4>
                <button onclick="closeJadwalModal()" class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-[#5E887E] hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="formJadwal" onsubmit="saveJadwal(event)" class="space-y-4">
                <input type="hidden" id="jadwalId">
                <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Nama Pemilik</label>
                    <input type="text" id="inputJNama" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Jam</label>
                    <input type="text" id="inputJJam" required placeholder="cth: 14.00" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Nama Hewan</label>
                    <input type="text" id="inputJHewan" required placeholder="cth: Bruno — Anjing Golden Retriever" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Jenis Layanan</label>
                    <select id="inputJLokasi" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none">
                    <option value="Dog Walking">Dog Walking</option>
                    <option value="Pet Hotel">Pet Hotel</option>
                    <option value="Day Care">Day Care</option>
                    <option value="Home Visit">Home Visit</option>
                    </select>
                </div>
                </div>
                <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeJadwalModal()" class="flex-1 py-2.5 bg-gray-50 text-[#5E887E] rounded-xl text-xs font-bold hover:bg-gray-100">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168]">Simpan</button>
                </div>
            </form>
            </div>
        </div>

  <!-- ===== MODAL: CATATAN HARIAN ===== -->
  <div id="catatanModal" class="modal-overlay fixed inset-0 bg-[#2D433E]/40 backdrop-blur-sm z-[100] items-center justify-center p-4">
    <div class="bg-white rounded-[28px] w-full max-w-md p-6 border border-gray-100 shadow-2xl">
      <div class="flex items-center justify-between mb-5">
        <h4 id="catatanModalTitle" class="text-base font-black text-[#2D433E]">Tambah Catatan Harian</h4>
        <button onclick="closeCatatanModal()" class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-[#5E887E] hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form id="formCatatan" onsubmit="saveCatatan(event)" class="space-y-4">
        <input type="hidden" id="catatanId">
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Nama Hewan</label>
            <input type="text" id="inputCHewan" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Jenis Hewan</label>
            <input type="text" id="inputCJenis" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Nama Pemilik</label>
            <input type="text" id="inputCPemilik" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Tanggal</label>
            <input type="text" id="inputCTanggal" required placeholder="13 Jun 2026" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div class="sm:col-span-2">
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Jenis Layanan</label>
            <select id="inputCLayanan" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none">
              <option value="Dog Walking">Dog Walking</option>
              <option value="Pet Hotel">Pet Hotel</option>
              <option value="Day Care">Day Care</option>
              <option value="Home Visit">Home Visit</option>
            </select>
          </div>
          <div class="col-span-2">
            <label class="block text-[10px] font-bold text-[#5E887E] uppercase tracking-wider mb-1.5">Kondisi & Catatan</label>
            <textarea id="inputCCatatan" rows="3" required placeholder="Tuliskan kondisi, aktivitas, dan catatan penting lainnya..." class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E] focus:ring-1 focus:ring-[#5E887E]/20 resize-none"></textarea>
          </div>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="button" onclick="closeCatatanModal()" class="flex-1 py-2.5 bg-gray-50 text-[#5E887E] rounded-xl text-xs font-bold hover:bg-gray-100">Batal</button>
          <button type="submit" class="flex-1 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168]">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ===== MODAL: CHAT ===== -->
  <div id="chatModal" class="modal-overlay fixed inset-0 bg-[#2D433E]/40 backdrop-blur-sm z-[100] items-center justify-center p-4">
    <div class="bg-white rounded-[28px] w-full max-w-md border border-gray-100 shadow-2xl flex flex-col" style="max-height:90vh">
      <div class="flex items-center justify-between p-5 border-b border-gray-50">
        <div class="flex items-center gap-3">
          <div id="chatAvatar" class="w-10 h-10 rounded-xl bg-[#D9B08C]/10 flex items-center justify-center text-[#D9B08C] text-sm font-bold"></div>
          <div>
            <div id="chatName" class="text-sm font-bold text-[#2D433E]"></div>
            <div id="chatPet" class="text-[10px] text-[#5E887E]"></div>
          </div>
        </div>
        <button onclick="closeChatModal()" class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-[#5E887E] hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div id="chatMessages" class="flex-1 overflow-y-auto p-5 space-y-3" style="min-height:200px;max-height:50vh">
        <!-- Messages -->
      </div>
      <div class="p-4 border-t border-gray-50 flex gap-2">
        <input type="text" id="chatInput" placeholder="Ketik pesan..." class="flex-1 px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
        <button onclick="sendChat()" class="px-4 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all">
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>
    </div>
  </div>

  <script>
    // ========== SIDEBAR & TAB ==========
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('main-content');
      sidebar.classList.toggle('-translate-x-full');
      if (window.innerWidth >= 1024) {
        main.classList.toggle('lg:pl-72');
      }
    }

    const tabMeta = {
      dashboard: ['Halo, Kak Dimas! 🐾', 'Ringkasan aktivitas penitipan dan status Anda hari ini.'],
      jadwal:    ['Jadwal Penitipan 📅', 'Kelola sesi penjagaan dan konfirmasi booking harian.'],
      catatan:   ['Catatan Perawatan Harian 📋', 'Riwayat aktivitas dan kondisi seluruh hewan yang dititipkan.'],
      chat:      ['Chat Pemilik Hewan 💬', 'Update perkembangan dan komunikasi langsung dengan pemilik.'],
      profil:    ['Tarif Saya ⚙️', 'Update informasi, tarif, dan status ketersediaan real-time.'],
    };

    function switchTab(name) {
      document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
      document.getElementById('tab-' + name).classList.add('active');

      ['dashboard','jadwal','catatan','chat','profil'].forEach(t => {
        const btn = document.getElementById('btn-tab-' + t);
        btn.className = t === name
          ? 'sidebar-link active w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300'
          : 'sidebar-link text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300';
      });

      document.getElementById('page-title').innerText = tabMeta[name][0];
      document.getElementById('page-desc').innerText  = tabMeta[name][1];
    }

    // ========== STATUS ==========
    const statusConfig = {
      tersedia:   { label: 'Tersedia',          dot: 'bg-green-600', pill: 'bg-green-100 text-green-800 border-green-200', sidebar: '● Tersedia' },
      perjalanan: { label: 'Dalam Perjalanan',  dot: 'bg-amber-500', pill: 'bg-amber-100 text-amber-800 border-amber-200', sidebar: '● Dalam Perjalanan' },
      menjaga:    { label: 'Sedang Menjaga',    dot: 'bg-blue-500',  pill: 'bg-blue-100 text-blue-800 border-blue-200',   sidebar: '● Sedang Menjaga' },
      off:        { label: 'Tidak Bertugas',    dot: 'bg-teal-600',  pill: 'bg-teal-100 text-teal-800 border-teal-200',   sidebar: '● Tidak Bertugas' },
    };

    function setStatus(key) {
      const cfg = statusConfig[key];
      const pill = document.getElementById('status-pill');
      const dot  = document.getElementById('status-dot');
      document.getElementById('status-label').innerText = cfg.label;
      pill.className = `flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold border ${cfg.pill}`;
      dot.className  = `w-2 h-2 rounded-full ${cfg.dot}`;
      document.getElementById('sidebar-status-text').innerText = cfg.sidebar;

      document.querySelectorAll('.status-opt').forEach(b => {
        b.style.boxShadow = b.dataset.status === key ? '0 0 0 2.5px currentColor' : 'none';
      });
    }

    // ========== JADWAL PENITIPAN ==========
    let jadwalCount = 4;

    function openJadwalModal(mode, id = null) {
      document.getElementById('jadwalModal').classList.add('show');
      if (mode === 'create') {
        document.getElementById('jadwalModalTitle').innerText = 'Tambah Jadwal Baru';
        document.getElementById('formJadwal').reset();
        document.getElementById('jadwalId').value = '';
      } else {
        document.getElementById('jadwalModalTitle').innerText = 'Ubah Jadwal';
        document.getElementById('jadwalId').value = id;
        const row = document.getElementById('jadwal-row-' + id);
        document.getElementById('inputJNama').value  = row.querySelector('.cell-j-nama').innerText;
        const hewanFull = row.querySelector('.cell-j-hewan').innerText;
        const parts = hewanFull.split(' • ');
        document.getElementById('inputJHewan').value  = parts[0] || '';
        document.getElementById('inputJLokasi').value = parts[1] || 'Dog Walking';
        document.getElementById('inputJJam').value   = row.querySelector('.text-xs.font-bold.text-\\[\\#5E887E\\]')?.innerText || '';
      }
    }

    function closeJadwalModal() { document.getElementById('jadwalModal').classList.remove('show'); }

    function saveJadwal(e) {
      e.preventDefault();
      const id     = document.getElementById('jadwalId').value;
      const nama   = document.getElementById('inputJNama').value;
      const jam    = document.getElementById('inputJJam').value;
      const hewan  = document.getElementById('inputJHewan').value;
      const layanan = document.getElementById('inputJLokasi').value;
      const inisial = nama.split(' ').map(n => n[0]).join('').substring(0,2).toUpperCase();

      if (id) {
        const row = document.getElementById('jadwal-row-' + id);
        row.querySelector('.cell-j-nama').innerText  = nama;
        row.querySelector('.cell-j-hewan').innerText = hewan + ' • ' + layanan;
      } else {
        jadwalCount++;
        const list = document.getElementById('jadwal-list');
        const div = document.createElement('div');
        div.id = 'jadwal-row-' + jadwalCount;
        div.className = 'flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-amber-50 bg-amber-50/30 hover:bg-amber-50/50 transition-all';
        div.innerHTML = `
          <div class="text-xs font-bold text-[#5E887E] w-12">${jam}</div>
          <div class="w-10 h-10 rounded-xl bg-[#5E887E]/10 flex items-center justify-center text-[#5E887E] text-xs font-bold">${inisial}</div>
          <div class="flex-1 min-w-[120px]">
            <div class="text-sm font-bold text-[#2D433E] cell-j-nama">${nama}</div>
            <div class="text-[10px] text-[#5E887E] cell-j-hewan">${hewan} • ${layanan}</div>
          </div>
          <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold cell-j-status">Menunggu</span>
          <div class="flex gap-2">
            <button onclick="terimaJadwal(${jadwalCount})" class="w-8 h-8 bg-green-50 text-green-600 rounded-lg text-xs flex items-center justify-center hover:bg-green-500 hover:text-white transition-all"><i class="fa-solid fa-check"></i></button>
            <button onclick="tolakJadwal(${jadwalCount})" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-xmark"></i></button>
            <button onclick="openJadwalModal('edit', ${jadwalCount})" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
            <button onclick="deleteJadwal(${jadwalCount})" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
          </div>`;
        list.appendChild(div);
      }
      closeJadwalModal();
    }

    function terimaJadwal(id) {
      const row = document.getElementById('jadwal-row-' + id);
      if (!row) return;
      const badge = row.querySelector('.cell-j-status');
      badge.className = 'px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold cell-j-status';
      badge.innerText = 'Berlangsung';
      row.className = 'flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-blue-50 bg-blue-50/30 hover:bg-blue-50/50 transition-all';
    }

    function tolakJadwal(id) {
      if (confirm('Yakin menolak jadwal ini?')) document.getElementById('jadwal-row-' + id)?.remove();
    }

    function confirmJadwal(id) {
      const row = document.getElementById('jadwal-row-' + id);
      if (!row) return;
      const badge = row.querySelector('.cell-j-status');
      badge.className = 'px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold cell-j-status';
      badge.innerText = 'Selesai';
      row.className = 'flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-gray-50 bg-[#FAF9F6]/60 hover:bg-[#FAF9F6] transition-all';
    }

    function deleteJadwal(id) {
      if (confirm('Yakin hapus jadwal ini?')) document.getElementById('jadwal-row-' + id)?.remove();
    }

    // ========== CATATAN HARIAN ==========
    let catatanCount = 3;

    function openCatatanModal(mode, id = null) {
      document.getElementById('catatanModal').classList.add('show');
      if (mode === 'create') {
        document.getElementById('catatanModalTitle').innerText = 'Tambah Catatan Harian';
        document.getElementById('formCatatan').reset();
        document.getElementById('catatanId').value = '';
      } else {
        document.getElementById('catatanModalTitle').innerText = 'Ubah Catatan Harian';
        document.getElementById('catatanId').value = id;
        const row = document.getElementById('catatan-row-' + id);
        document.getElementById('inputCHewan').value    = row.querySelector('.cell-c-hewan').innerText;
        document.getElementById('inputCJenis').value    = row.querySelector('.cell-c-jenis').innerText;
        document.getElementById('inputCPemilik').value  = row.querySelector('.cell-c-pemilik').innerText;
        document.getElementById('inputCLayanan').value  = row.querySelector('.cell-c-layanan').innerText;
        document.getElementById('inputCCatatan').value  = row.querySelector('.cell-c-catatan').innerText;
        document.getElementById('inputCTanggal').value  = row.querySelector('.cell-c-tanggal').innerText;
      }
    }

    function closeCatatanModal() { document.getElementById('catatanModal').classList.remove('show'); }

    function saveCatatan(e) {
      e.preventDefault();
      const id       = document.getElementById('catatanId').value;
      const hewan    = document.getElementById('inputCHewan').value;
      const jenis    = document.getElementById('inputCJenis').value;
      const pemilik  = document.getElementById('inputCPemilik').value;
      const layanan  = document.getElementById('inputCLayanan').value;
      const catatan  = document.getElementById('inputCCatatan').value;
      const tanggal  = document.getElementById('inputCTanggal').value;

      if (id) {
        const row = document.getElementById('catatan-row-' + id);
        row.querySelector('.cell-c-hewan').innerText    = hewan;
        row.querySelector('.cell-c-jenis').innerText    = jenis;
        row.querySelector('.cell-c-pemilik').innerText  = pemilik;
        row.querySelector('.cell-c-layanan').innerText  = layanan;
        row.querySelector('.cell-c-catatan').innerText  = catatan;
        row.querySelector('.cell-c-tanggal').innerText  = tanggal;
      } else {
        catatanCount++;
        const tbody = document.getElementById('catatan-table-body');
        const tr = document.createElement('tr');
        tr.id = 'catatan-row-' + catatanCount;
        tr.className = 'hover:bg-[#FAF9F6]/50 transition-colors';
        tr.innerHTML = `
          <td class="py-4 pl-2"><div class="font-bold cell-c-hewan">${hewan}</div><div class="text-[10px] text-[#5E887E] cell-c-jenis">${jenis}</div></td>
          <td class="py-4 text-xs cell-c-pemilik">${pemilik}</td>
          <td class="py-4"><span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-bold cell-c-layanan">${layanan}</span></td>
          <td class="py-4 text-xs cell-c-catatan">${catatan}</td>
          <td class="py-4 text-[10px] text-[#5E887E] cell-c-tanggal">${tanggal}</td>
          <td class="py-4"><div class="flex justify-center gap-2">
            <button onclick="openCatatanModal('edit',${catatanCount})" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
            <button onclick="deleteCatatan(${catatanCount},'${hewan}')" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
          </div></td>`;
        tbody.appendChild(tr);
      }
      closeCatatanModal();
    }

    function deleteCatatan(id, nama) {
      if (confirm(`Yakin hapus catatan harian "${nama}"?`)) document.getElementById('catatan-row-' + id)?.remove();
    }

    // ========== CHAT MODAL ==========
    const chatHistories = {
      'Andi Pratama': [
        { from: 'user', text: 'Pagi kak, Bruno udah jalan-jalan?' },
        { from: 'user', text: 'Kalau belum, jam 8 aja ya jalannya, dia lagi semangat banget hehe' },
      ],
      'Maya Sari': [
        { from: 'sitter', text: 'Kiki tadi makan dengan lahap, sudah saya kasih obat jam 3 ya' },
        { from: 'user', text: 'Siap kak, makasih banyak infonya' },
      ],
      'Fajar Nugroho': [
        { from: 'sitter', text: 'Coco hari ini ceria banget, main bareng anjing lain di Day Care' },
        { from: 'user', text: 'Makasih banyak udah jagain Coco kemarin!' },
      ],
    };

    let currentChatName = '';

    function openChatModal(name, inisial, pet) {
      currentChatName = name;
      document.getElementById('chatAvatar').innerText = inisial;
      document.getElementById('chatName').innerText   = name;
      document.getElementById('chatPet').innerText    = pet;

      const msgs = document.getElementById('chatMessages');
      msgs.innerHTML = '';
      const history = chatHistories[name] || [];
      history.forEach(m => appendChatBubble(m.from, m.text, false));

      document.getElementById('chatModal').classList.add('show');
      msgs.scrollTop = msgs.scrollHeight;
    }

    function closeChatModal() { document.getElementById('chatModal').classList.remove('show'); }

    function appendChatBubble(from, text, scroll = true) {
      const msgs = document.getElementById('chatMessages');
      const div  = document.createElement('div');
      div.className = from === 'sitter' ? 'flex justify-end' : 'flex justify-start';
      div.innerHTML = `<div class="max-w-[75%] px-4 py-2.5 rounded-2xl text-xs font-medium ${from === 'sitter' ? 'bg-[#5E887E] text-white rounded-br-sm' : 'bg-[#FAF9F6] text-[#2D433E] border border-gray-100 rounded-bl-sm'}">${text}</div>`;
      msgs.appendChild(div);
      if (scroll) msgs.scrollTop = msgs.scrollHeight;
    }

    function sendChat() {
      const input = document.getElementById('chatInput');
      const text  = input.value.trim();
      if (!text) return;
      appendChatBubble('sitter', text);
      if (!chatHistories[currentChatName]) chatHistories[currentChatName] = [];
      chatHistories[currentChatName].push({ from: 'sitter', text });
      input.value = '';
    }

    document.getElementById('chatInput').addEventListener('keydown', e => { if (e.key === 'Enter') sendChat(); });

    // ========== PENGAJUAN TARIF ==========
    function submitPengajuanTarif(e) {
      e.preventDefault();
      alert('Pengajuan tarif berhasil dikirim ke Admin!');
      e.target.reset();
    }
  </script>
</body>
</html>
