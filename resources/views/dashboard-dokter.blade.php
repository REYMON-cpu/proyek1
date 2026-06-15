<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter — GoPet</title>
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
          <div class="w-10 h-10 rounded-xl bg-[#5E887E] flex items-center justify-center">
            <i class="fa-solid fa-paw text-white text-lg"></i>
          </div>
          <div>
            <h2 class="text-xl font-bold text-[#5E887E] tracking-tight">Go<span class="text-[#D9B08C]">Pet</span></h2>
            <span class="text-[10px] font-bold text-[#5E887E] uppercase tracking-widest block -mt-1">Admin Panel</span>
          </div>
        </div>
        <button onclick="toggleSidebar()" class="w-9 h-9 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-100 lg:hidden">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <!-- Nav -->
      <nav class="space-y-1">
        <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-gray-400 px-3 mb-3">Menu Utama</p>

        <button onclick="switchTab('dashboard')" id="btn-tab-dashboard"
          class="sidebar-link active w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-chart-pie text-base w-5 text-center"></i> Dashboard
        </button>

        <button onclick="switchTab('jadwal')" id="btn-tab-jadwal"
          class="sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-calendar-days text-base w-5 text-center"></i> Jadwal Konsultasi
        </button>

        <button onclick="switchTab('pasien')" id="btn-tab-pasien"
          class="sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-notes-medical text-base w-5 text-center"></i> Rekam Medis
        </button>

        <button onclick="switchTab('chat')" id="btn-tab-chat"
          class="sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-comments text-base w-5 text-center"></i> Chat Pemilik
          <span id="badge-chat" class="ml-auto bg-[#5E887E] text-white text-[9px] font-bold px-2 py-0.5 rounded-full">2</span>
        </button>

        <button onclick="switchTab('profil')" id="btn-tab-profil"
          class="sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300">
          <i class="fa-solid fa-circle-user text-base w-5 text-center"></i> Tarif
        </button>
      </nav>
    </div>

    <!-- Profile & Logout -->
    <div class="space-y-3">
      <div class="flex items-center gap-3 px-3 py-3 bg-[#E8F0EE]/40 rounded-2xl">
        <div class="w-10 h-10 rounded-xl bg-[#5E887E] flex items-center justify-center text-white text-sm font-bold">JA</div>
        <div>
          <div class="text-sm font-bold text-[#2D433E]">Jinten Anggraeni</div>
          <div id="sidebar-status-text" class="text-[10px] text-gray-400 font-semibold">● Tersedia</div>
        </div>
      </div>
      <div class="border-t border-[#5E887E]/10 pt-3">
        <!-- Tombol Keluar Langsung Mengarah Ke Landing Page / Welcome -->
        <button onclick="window.location.href='/'" 
                class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-50 font-bold text-sm transition-all">
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
          <h1 id="page-title" class="text-xl md:text-2xl font-black text-[#2D433E] tracking-tight">Selamat Datang, Dokter! 🩺</h1>
          <p id="page-desc" class="text-xs text-gray-400 font-medium mt-0.5 hidden sm:block">Ringkasan aktivitas harian dan status konsultasi Anda.</p>
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
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Konsultasi Hari Ini</p>
        <h3 class="text-2xl font-black text-[#2D433E] mt-1">6 <span class="text-xs font-medium text-gray-400">sesi</span></h3>
        </div>
        <div class="w-12 h-12 bg-[#5E887E]/10 rounded-2xl flex items-center justify-center text-[#5E887E] text-xl"><i class="fa-solid fa-stethoscope"></i></div>
    </div>

    <div class="bg-white p-5 rounded-[28px] border border-[#5E887E]/5 shadow-sm flex justify-between items-center">
        <div>
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Menunggu Konfirmasi</p>
        <h3 class="text-2xl font-black text-amber-600 mt-1">2 <span class="text-xs font-medium text-gray-400">pasien</span></h3>
        </div>
        <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-600 text-xl"><i class="fa-solid fa-clock"></i></div>
    </div>

    <div class="bg-white p-5 rounded-[28px] border border-[#5E887E]/5 shadow-sm flex justify-between items-center">
        <div>
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Hewan yang Telah Ditangani</p>
        <h3 class="text-2xl font-black text-[#2D433E] mt-1">142 <span class="text-xs font-medium text-gray-400">hewan</span></h3>
        </div>
        <div class="w-12 h-12 bg-teal-500/10 rounded-2xl flex items-center justify-center text-teal-600 text-xl"><i class="fa-solid fa-circle-check"></i></div>
    </div>
    </div>

        <!-- Jadwal Hari Ini + Chat Preview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

          <div class="bg-white rounded-[32px] border border-gray-100 p-6 shadow-sm">
            <div class="flex justify-between items-start mb-5">
              <div>
                <h3 class="text-base font-extrabold text-[#2D433E]">Jadwal Hari Ini</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ date('l, d F Y') }}</p>
              </div>
              <button onclick="switchTab('jadwal')" class="text-xs font-bold text-[#5E887E] hover:underline">Lihat Semua →</button>
            </div>
            <div class="space-y-3">
              @forelse($daftar_pesanan as $pesan)
                <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#FAF9F6] border border-gray-50">
                  <div class="text-center min-w-[44px]">
                    <div class="text-[10px] font-bold text-[#5E887E]">{{ \Carbon\Carbon::parse($pesan->jam_kunjungan)->format('H.i') }}</div>
                  </div>
                  <div class="w-9 h-9 rounded-xl bg-[#5E887E]/10 flex items-center justify-center text-[#5E887E] text-xs font-bold">
                    {{ strtoupper(substr($pesan->nama_hewan ?? 'AN', 0, 2)) }}
                  </div>
                  <div class="flex-1">
                    <div class="text-xs font-bold text-[#2D433E]">{{ $pesan->nama_hewan }}</div>
                    <div class="text-[10px] text-gray-400">{{ $pesan->jenis_hewan }} — Umur: {{ $pesan->umur_hewan }}</div>
                  </div>
                  
                  @if($pesan->status === 'Pending' || $pesan->status === 'Pending')
                    <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold">Menunggu</span>
                  @elseif($pesan->status === 'Selesai')
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold">Selesai</span>
                  @else
                    <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold">Berlangsung</span>
                  @endif
                </div>
              @empty
                <div class="text-center py-6 text-gray-400 text-xs">
                  Belum ada pesanan masuk untuk hari ini, Cees!
                </div>
              @endforelse
            </div>
          </div>

          <div class="bg-white rounded-[32px] border border-gray-100 p-6 shadow-sm">
            <div class="flex justify-between items-start mb-5">
              <div>
                <h3 class="text-base font-extrabold text-[#2D433E]">Pesan Masuk</h3>
                <p class="text-xs text-gray-400 mt-0.5">Chat dari pemilik hewan</p>
              </div>
              <button onclick="switchTab('chat')" class="text-xs font-bold text-[#5E887E] hover:underline">Lihat Semua →</button>
            </div>
            <div class="space-y-3">
              @forelse($daftar_chat->take(3) as $chat)
                <!-- Chat Item Dinamis Dashboard Depan -->
                <div onclick="switchTab('chat')" class="flex items-center gap-3 p-3 rounded-2xl hover:bg-[#FAF9F6] cursor-pointer transition-all border border-transparent hover:border-gray-50">
                  <!-- Indikator Hijau -->
                  <div class="w-2 h-2 rounded-full bg-[#5E887E] flex-shrink-0"></div>
                  
                  <!-- Avatar Inisial Otomatis -->
                  <div class="w-9 h-9 rounded-xl bg-[#5E887E]/10 flex items-center justify-center text-[#5E887E] text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr($chat->nama ?? $chat->name ?? $chat->nama_user ?? 'US', 0, 2)) }}
                  </div>
                  
                  <div class="flex-1 min-w-0">
                    <div class="text-xs font-bold text-[#2D433E]">
                      {{ $chat->nama ?? $chat->name ?? $chat->nama_user ?? 'Pengguna GoPet' }}
                    </div>
                    <div class="text-[10px] text-gray-400 truncate mt-0.5">
                      {{ $chat->pesan ?? $chat->isi_pesan ?? $chat->message ?? '(Pesan kosong)' }}
                    </div>
                  </div>
                  
                  <!-- Waktu Masuk -->
                  <div class="text-[10px] text-gray-400 font-semibold flex-shrink-0">
                    {{ isset($chat->created_at) ? \Carbon\Carbon::parse($chat->created_at)->format('H.i') : 'Baru' }}
                  </div>
                </div>
              @empty
                <!-- Jika database kosong -->
                <div class="text-center py-6 text-gray-400 text-xs">
                  Belum ada pesan masuk, Cees!
                </div>
              @endforelse
            </div>
          </div>

      </main>
    </div>

    <div id="tab-jadwal" class="tab-content">
      <main class="px-6 md:px-10 py-6">
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
              <h3 class="text-lg font-extrabold text-[#2D433E]">Jadwal Konsultasi</h3>
              <p class="text-xs text-gray-400 mt-0.5">Kelola sesi kunjungan dan konfirmasi pasien harian.</p>
            </div>
            <button onclick="openJadwalModal('create')" class="px-4 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all flex items-center gap-2 shadow-md">
              <i class="fa-solid fa-plus"></i> Tambah Jadwal
            </button>
          </div>

          <div class="space-y-3" id="jadwal-list">
            @forelse($daftar_pesanan as $pesan)
              <div id="jadwal-row-{{ $pesan->id_pemesanan }}" class="flex flex-wrap items-center gap-3 p-4 rounded-2xl border 
                {{ $pesan->status === 'Pending' ? 'border-amber-50 bg-amber-50/30' : ($pesan->status === 'Selesai' ? 'border-gray-50 bg-[#FAF9F6]/60' : 'border-blue-50 bg-blue-50/30') }} hover:bg-opacity-100 transition-all">
                
                <div class="text-xs font-bold text-[#5E887E] w-12">{{ \Carbon\Carbon::parse($pesan->jam_kunjungan)->format('H.i') }}</div>
                <div class="w-10 h-10 rounded-xl bg-[#5E887E]/10 flex items-center justify-center text-[#5E887E] text-xs font-bold">
                  {{ strtoupper(substr($pesan->nama_hewan ?? 'AN', 0, 2)) }}
                </div>
                <div class="flex-1 min-w-[120px]">
                  <div class="text-sm font-bold text-[#2D433E] cell-j-nama">{{ $pesan->nama_hewan }} ({{ $pesan->jenis_hewan }})</div>
                  <div class="text-[10px] text-gray-400 cell-j-hewan">Alamat: {{ $pesan->alamat }} • Keluhan: {{ $pesan->riwayat_kesehatan ?? '-' }}</div>
                </div>

                @if($pesan->status === 'Pending')
                  <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold cell-j-status">Menunggu</span>
                @elseif($pesan->status === 'Selesai')
                  <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold cell-j-status">Selesai</span>
                @else
                  <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold cell-j-status">Berlangsung</span>
                @endif

                <div class="flex gap-2">
                  @if($pesan->status === 'Pending')
                    <button onclick="alert('Fitur terima dalam pengembangan, Cees!')" class="w-8 h-8 bg-green-50 text-green-600 rounded-lg text-xs flex items-center justify-center hover:bg-green-500 hover:text-white transition-all" title="Terima"><i class="fa-solid fa-check"></i></button>
                  @endif
                  <button onclick="openJadwalModal('edit', {{ $pesan->id_pemesanan }})" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                </div>
              </div>
            @empty
              <div class="text-center py-10 text-gray-400">
                <p class="text-sm">Belum ada antrean jadwal konsultasi di database, Cees!</p>
              </div>
            @endforelse
          </div>
        </div>
      </main>
    </div>

    <!-- ===== TAB: JADWAL KONSULTASI ===== -->
    <div id="tab-jadwal" class="tab-content">
      <main class="px-6 md:px-10 py-6">
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
              <h3 class="text-lg font-extrabold text-[#2D433E]">Jadwal Konsultasi</h3>
              <p class="text-xs text-gray-400 mt-0.5">Kelola sesi kunjungan dan konfirmasi pasien harian.</p>
            </div>
          </div>

          <div class="space-y-3" id="jadwal-list">
            <!-- Row 1 -->
            <div id="jadwal-row-1" class="flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-gray-50 bg-[#FAF9F6]/60 hover:bg-[#FAF9F6] transition-all">
              <div class="text-xs font-bold text-[#5E887E] w-12">09.00</div>
              <div class="w-10 h-10 rounded-xl bg-[#5E887E]/10 flex items-center justify-center text-[#5E887E] text-xs font-bold">BL</div>
              <div class="flex-1 min-w-[120px]">
                <div class="text-sm font-bold text-[#2D433E] cell-j-nama">Bunga Lestari</div>
                <div class="text-[10px] text-gray-400 cell-j-hewan">Mochi — Kucing Persia • Home Visit</div>
              </div>
              <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold cell-j-status">Selesai</span>
              <div class="flex gap-2">
                <button onclick="openJadwalModal('edit', 1)" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                <button onclick="deleteJadwal(1)" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
              </div>
            </div>
            <!-- Row 2 -->
            <div id="jadwal-row-2" class="flex flex-wrap items-center gap-3 p-4 rounded-2xl border border-blue-50 bg-blue-50/30 hover:bg-blue-50/50 transition-all">
              <div class="text-xs font-bold text-[#5E887E] w-12">10.30</div>
              <div class="w-10 h-10 rounded-xl bg-[#D9B08C]/10 flex items-center justify-center text-[#D9B08C] text-xs font-bold">RK</div>
              <div class="flex-1 min-w-[120px]">
                <div class="text-sm font-bold text-[#2D433E] cell-j-nama">Rizal Kurniawan</div>
                <div class="text-[10px] text-gray-400 cell-j-hewan">Max — Anjing Shiba • Home Visit</div>
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
              <div class="w-10 h-10 rounded-xl bg-blue-400/10 flex items-center justify-center text-blue-500 text-xs font-bold">SA</div>
              <div class="flex-1 min-w-[120px]">
                <div class="text-sm font-bold text-[#2D433E] cell-j-nama">Siti Aminah</div>
                <div class="text-[10px] text-gray-400 cell-j-hewan">Luna — Kucing Anggora • Klinik</div>
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
              <div class="text-xs font-bold text-[#5E887E] w-12">15.00</div>
              <div class="w-10 h-10 rounded-xl bg-green-400/10 flex items-center justify-center text-green-600 text-xs font-bold">DM</div>
              <div class="flex-1 min-w-[120px]">
                <div class="text-sm font-bold text-[#2D433E] cell-j-nama">Dita Maharani</div>
                <div class="text-[10px] text-gray-400 cell-j-hewan">Koko — Kelinci • Home Visit</div>
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

    <!-- ===== TAB: REKAM MEDIS ===== -->
    <div id="tab-pasien" class="tab-content">
      <main class="px-6 md:px-10 py-6">
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
              <h3 class="text-lg font-extrabold text-[#2D433E]">Rekam Medis Pasien</h3>
              <p class="text-xs text-gray-400 mt-0.5">Riwayat diagnosis dan tindakan medis seluruh pasien.</p>
            </div>
            <button onclick="openRekamModal('create')" class="px-4 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all flex items-center gap-2 shadow-md">
              <i class="fa-solid fa-plus"></i> Tambah Rekam
            </button>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="border-b border-gray-100 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">
                  <th class="pb-4 pl-2">Nama Hewan</th>
                  <th class="pb-4">Jenis Hewan</th>
                  <th class="pb-4">Diagnosis (Keluhan)</th>
                  <th class="pb-4">Catatan Medis</th>
                  <th class="pb-4">Tanggal Periksa</th>
                  <th class="pb-4 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody id="rekam-table-body" class="divide-y divide-gray-50 text-sm font-medium text-[#2D433E]">
                @forelse($rekam_medis as $rm)
                  <tr id="rekam-row-{{ $rm->id_pemesanan }}" class="hover:bg-[#FAF9F6]/50 transition-colors">
                    <td class="py-4 pl-2">
                      <div class="font-bold cell-r-hewan">{{ $rm->nama_hewan }}</div>
                      <div class="text-[10px] text-gray-400">Umur: {{ $rm->umur_hewan }}</div>
                    </td>
                    <td class="py-4 text-xs text-gray-600">{{ $rm->jenis_hewan }}</td>
                    <td class="py-4">
                      <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-bold cell-r-diagnosis">
                        {{ $rm->riwayat_kesehatan ?? 'Pemeriksaan Rutin' }}
                      </span>
                    </td>
                    <td class="py-4 text-xs text-gray-500 cell-r-tindakan">
                      {{ $rm->catatan ?? 'Tidak ada catatan tindakan tambahan' }}
                    </td>
                    <td class="py-4 text-[10px] text-gray-400 cell-r-tanggal">
                      {{ \Carbon\Carbon::parse($rm->tanggal_kunjungan)->format('d M Y') }}
                    </td>
                    <td class="py-4">
                      <div class="flex justify-center gap-2">
                        <button onclick="openRekamModal('edit', {{ $rm->id_pemesanan }})" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button onclick="alert('Fitur hapus rekam medis dalam pengembangan, Cees!')" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400 text-xs">
                      Belum ada riwayat rekam medis dari pasien yang berstatus Selesai, Cees!
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>

    <!-- ===== TAB: CHAT ===== -->
    <div class="space-y-3">
            @forelse($daftar_chat as $chat)
              <!-- Chat Item Dinamis -->
              <div class="flex items-center gap-4 p-4 rounded-2xl border border-[#5E887E]/10 hover:bg-[#FAF9F6] cursor-pointer transition-all" 
                   onclick="openChatModal('{{ $chat->nama ?? $chat->name ?? $chat->nama_user ?? 'Pengguna GoPet' }}', '{{ strtoupper(substr($chat->nama ?? $chat->name ?? $chat->nama_user ?? 'US', 0, 2)) }}', 'Hubungi: {{ $chat->email ?? $chat->no_hp ?? $chat->telepon ?? '-' }}')">
                
                <!-- Indikator Pesan Baru -->
                <div class="w-2 h-2 rounded-full bg-[#5E887E] flex-shrink-0"></div>
                
                <!-- Avatar Inisial Otomatis -->
                <div class="w-11 h-11 rounded-xl bg-[#5E887E]/10 flex items-center justify-center text-[#5E887E] text-sm font-bold flex-shrink-0">
                  {{ strtoupper(substr($chat->nama ?? $chat->name ?? $chat->nama_user ?? 'US', 0, 2)) }}
                </div>
                
                <div class="flex-1 min-w-0">
                  <div class="flex items-center gap-2">
                    <div class="text-sm font-bold text-[#2D433E]">
                      {{ $chat->nama ?? $chat->name ?? $chat->nama_user ?? 'Pengguna GoPet' }}
                    </div>
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-[9px] font-bold">Klien GoPet</span>
                  </div>
                  <!-- Isi Pesan Asli -->
                  <div class="text-xs text-gray-400 truncate mt-0.5">
                    {{ $chat->pesan ?? $chat->isi_pesan ?? $chat->message ?? '(Pesan kosong)' }}
                  </div>
                </div>
                
                <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                  <div class="text-[10px] text-gray-400 font-semibold">
                    {{ isset($chat->created_at) ? \Carbon\Carbon::parse($chat->created_at)->format('H.i') : 'Baru' }}
                  </div>
                </div>
              </div>
            @empty
              <!-- Tampilan Jika Tidak Ada Chat -->
              <div class="text-center py-12 text-gray-400 text-xs">
                <i class="fa-regular fa-comments text-2xl block mb-2 text-gray-300"></i>
                Belum ada pesan masuk dari pemilik hewan di database, Cees!
              </div>
            @endforelse
          </div>
          <div class="space-y-3">
            <div class="flex items-center gap-4 p-4 rounded-2xl border border-[#5E887E]/10 hover:bg-[#FAF9F6] cursor-pointer transition-all" onclick="openChatModal('Rizal Kurniawan', 'RK', 'Max — Anjing Shiba')">
              <div class="w-2 h-2 rounded-full bg-[#5E887E] flex-shrink-0"></div>
              <div class="w-11 h-11 rounded-xl bg-[#D9B08C]/10 flex items-center justify-center text-[#D9B08C] text-sm font-bold flex-shrink-0">RK</div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                  <div class="text-sm font-bold text-[#2D433E]">Rizal Kurniawan</div>
                  <span class="px-2 py-0.5 bg-[#D9B08C]/10 text-[#D9B08C] rounded-full text-[9px] font-bold">Max — Shiba</span>
                </div>
                <div class="text-xs text-gray-400 truncate mt-0.5">Dok, Max masih belum mau makan sejak kemarin malam...</div>
              </div>
              <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                <div class="text-[10px] text-gray-400 font-semibold">08.45</div>
                <div class="w-5 h-5 rounded-full bg-[#5E887E] flex items-center justify-center text-white text-[9px] font-bold">2</div>
              </div>
            </div>
            <div class="flex items-center gap-4 p-4 rounded-2xl border border-gray-50 hover:bg-[#FAF9F6] cursor-pointer transition-all" onclick="openChatModal('Siti Aminah', 'SA', 'Luna — Kucing Anggora')">
              <div class="w-2 h-2 rounded-full bg-[#5E887E] flex-shrink-0"></div>
              <div class="w-11 h-11 rounded-xl bg-blue-400/10 flex items-center justify-center text-blue-500 text-sm font-bold flex-shrink-0">SA</div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                  <div class="text-sm font-bold text-[#2D433E]">Siti Aminah</div>
                  <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded-full text-[9px] font-bold">Luna — Anggora</span>
                </div>
                <div class="text-xs text-gray-400 truncate mt-0.5">Dok, bisa reschedule besok ya?</div>
              </div>
              <div class="text-[10px] text-gray-400 font-semibold">Kemarin</div>
            </div>
            <div class="flex items-center gap-4 p-4 rounded-2xl border border-gray-50 hover:bg-[#FAF9F6] cursor-pointer transition-all" onclick="openChatModal('Bunga Lestari', 'BL', 'Mochi — Kucing Persia')">
              <div class="w-2 h-2 rounded-full bg-transparent flex-shrink-0"></div>
              <div class="w-11 h-11 rounded-xl bg-[#5E887E]/10 flex items-center justify-center text-[#5E887E] text-sm font-bold flex-shrink-0">BL</div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                  <div class="text-sm font-bold text-[#2D433E]">Bunga Lestari</div>
                  <span class="px-2 py-0.5 bg-[#E8F0EE] text-[#5E887E] rounded-full text-[9px] font-bold">Mochi — Persia</span>
                </div>
                <div class="text-xs text-gray-400 truncate mt-0.5">Terima kasih dok, Mochi sudah membaik!</div>
              </div>
              <div class="text-[10px] text-gray-400 font-semibold">Kemarin</div>
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
            <p class="text-xs text-gray-400 mt-0.5">Update status real-time Anda agar terlihat pemilik hewan.</p>
          </div>
          <div class="flex flex-wrap gap-3">
            <button onclick="setStatus('tersedia')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-green-200 bg-green-50 text-green-800 hover:border-green-500 transition-all" data-status="tersedia">
              <i class="fa-solid fa-circle-check mr-1.5"></i> Tersedia
            </button>
            <button onclick="setStatus('perjalanan')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-amber-200 bg-amber-50 text-amber-800 hover:border-amber-500 transition-all" data-status="perjalanan">
              <i class="fa-solid fa-car mr-1.5"></i> Dalam Perjalanan
            </button>
            <button onclick="setStatus('memeriksa')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-blue-200 bg-blue-50 text-blue-800 hover:border-blue-500 transition-all" data-status="memeriksa">
              <i class="fa-solid fa-stethoscope mr-1.5"></i> Sedang Memeriksa
            </button>
            <button onclick="setStatus('selesai')" class="status-opt px-5 py-2.5 rounded-full text-xs font-bold border-2 border-teal-200 bg-teal-50 text-teal-800 hover:border-teal-500 transition-all" data-status="selesai">
              <i class="fa-solid fa-flag-checkered mr-1.5"></i> Sesi Selesai
            </button>
          </div>
        </div>

        <!-- Pengajuan Tarif -->
        <div class="bg-white rounded-[32px] border border-gray-100 p-6 md:p-8 shadow-sm">
          <div class="mb-5">
            <h3 class="text-lg font-extrabold text-[#2D433E]">Pengajuan Kenaikan Tarif Dokter</h3>
            <p class="text-xs text-gray-400 mt-0.5">Formulir ini digunakan untuk mengajukan penyesuaian tarif. Perubahan akan berlaku setelah diverifikasi oleh Admin.</p>
          </div>
          <form onsubmit="submitPengajuanGaji(event)" class="space-y-4" enctype="multipart/form-data">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Lengkap & Gelar</label>
                <input type="text" value="drh. Jinten Anggraeni" disabled class="w-full px-4 py-2.5 bg-[#F5F5F3] border border-gray-100 rounded-xl text-xs font-semibold text-gray-500 cursor-not-allowed focus:outline-none">
              </div>
              <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Spesialisasi</label>
                <input type="text" value="Spesialis Kucing & Anjing" disabled class="w-full px-4 py-2.5 bg-[#F5F5F3] border border-gray-100 rounded-xl text-xs font-semibold text-gray-500 cursor-not-allowed focus:outline-none">
              </div>
              <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tarif Saat Ini (Per Kunjungan)</label>
                <input type="text" value="Rp 150.000" disabled class="w-full px-4 py-2.5 bg-[#F5F5F3] border border-gray-100 rounded-xl text-xs font-semibold text-gray-500 cursor-not-allowed focus:outline-none">
              </div>
              <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Usulan Tarif Baru (Rp)</label>
                <input type="number" placeholder="Contoh: 180000" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E] focus:ring-1 focus:ring-[#5E887E]/20">
              </div>
              <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Upload Surat Persetujuan Atasan Klinik</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl bg-[#FAF9F6] hover:border-[#5E887E] transition-colors relative">
                  <div class="space-y-1 text-center">
                    <i class="fa-solid fa-cloud-arrow-up text-gray-400 text-2xl mb-2 block"></i>
                    <div class="flex text-xs text-gray-600 justify-center">
                      <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-bold text-[#5E887E] hover:text-[#4d7168]">
                        <span>Pilih Berkas</span>
                        <input id="file-upload" name="file-upload" type="file" accept=".pdf,.png,.jpg,.jpeg" required class="sr-only">
                      </label>
                      <p class="pl-1 text-gray-400 font-medium">atau drag and drop</p>
                    </div>
                    <p class="text-[10px] text-gray-400">PDF, PNG, atau JPG maksimal 5MB (Harus bertandatangan resmi)</p>
                  </div>
                </div>
              </div>
              <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Alasan / Keterangan Pengajuan</label>
                <textarea rows="3" placeholder="Tuliskan alasan penyesuaian tarif di sini..." required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E] focus:ring-1 focus:ring-[#5E887E]/20 resize-none"></textarea>
              </div>
            </div>
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
        <button onclick="closeJadwalModal()" class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form id="formJadwal" onsubmit="saveJadwal(event)" class="space-y-4">
        <input type="hidden" id="jadwalId">
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Pemilik</label>
            <input type="text" id="inputJNama" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Jam</label>
            <input type="text" id="inputJJam" required placeholder="cth: 14.00" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Hewan</label>
            <input type="text" id="inputJHewan" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Lokasi</label>
            <select id="inputJLokasi" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none">
              <option value="Home Visit">Home Visit</option>
              <option value="Klinik">Klinik</option>
            </select>
          </div>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="button" onclick="closeJadwalModal()" class="flex-1 py-2.5 bg-gray-50 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-100">Batal</button>
          <button type="submit" class="flex-1 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168]">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ===== MODAL: REKAM MEDIS ===== -->
  <div id="rekamModal" class="modal-overlay fixed inset-0 bg-[#2D433E]/40 backdrop-blur-sm z-[100] items-center justify-center p-4">
    <div class="bg-white rounded-[28px] w-full max-w-md p-6 border border-gray-100 shadow-2xl">
      <div class="flex items-center justify-between mb-5">
        <h4 id="rekamModalTitle" class="text-base font-black text-[#2D433E]">Tambah Rekam Medis</h4>
        <button onclick="closeRekamModal()" class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form id="formRekam" onsubmit="saveRekam(event)" class="space-y-4">
        <input type="hidden" id="rekamId">
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Hewan</label>
            <input type="text" id="inputRHewan" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Jenis Hewan</label>
            <input type="text" id="inputRJenis" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Pemilik</label>
            <input type="text" id="inputRPemilik" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tanggal</label>
            <input type="text" id="inputRTanggal" required placeholder="07 Jun 2026" class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Diagnosis</label>
            <input type="text" id="inputRDiagnosis" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tindakan</label>
            <input type="text" id="inputRTindakan" required class="w-full px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
          </div>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="button" onclick="closeRekamModal()" class="flex-1 py-2.5 bg-gray-50 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-100">Batal</button>
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
            <div id="chatPet" class="text-[10px] text-gray-400"></div>
          </div>
        </div>
        <button onclick="closeChatModal()" class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div id="chatMessages" class="flex-1 overflow-y-auto p-5 space-y-3" style="min-height:200px;max-height:50vh"></div>
      <div class="p-4 border-t border-gray-50 flex gap-2">
        <input type="text" id="chatInput" placeholder="Ketik pesan..." class="flex-1 px-4 py-2.5 bg-[#FAF9F6] border border-gray-100 rounded-xl text-xs font-semibold focus:outline-none focus:border-[#5E887E]">
        <button onclick="sendChat()" class="px-4 py-2.5 bg-[#5E887E] text-white rounded-xl text-xs font-bold hover:bg-[#4d7168] transition-all">
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('main-content');
      if (sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.remove('-translate-x-full');
        mainContent.classList.add('lg:pl-72');
      } else {
        sidebar.classList.add('-translate-x-full');
        mainContent.classList.remove('lg:pl-72');
      }
    }

    // ========== TAB ==========
    const tabMeta = {
      dashboard: ['Selamat Datang, Dokter! 🩺', 'Ringkasan aktivitas harian dan status konsultasi Anda.'],
      jadwal:    ['Jadwal Konsultasi 📅', 'Kelola sesi kunjungan dan konfirmasi pasien harian.'],
      pasien:    ['Rekam Medis Pasien 📋', 'Riwayat diagnosis dan tindakan medis seluruh pasien.'],
      chat:      ['Chat Pemilik Hewan 💬', 'Komunikasi langsung dengan pemilik hewan peliharaan.'],
      profil:    ['Tarif Saya ⚙️', 'Update informasi, tarif, dan status ketersediaan real-time.'],
    };

    function switchTab(name) {
      document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
      document.getElementById('tab-' + name).classList.add('active');

      ['dashboard','jadwal','pasien','chat','profil'].forEach(t => {
        const btn = document.getElementById('btn-tab-' + t);
        btn.className = t === name
          ? 'sidebar-link active w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300'
          : 'sidebar-link text-gray-400 hover:text-[#5E887E] hover:bg-[#E8F0EE]/50 w-full text-left flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300';
      });

      document.getElementById('page-title').innerText = tabMeta[name][0];
      document.getElementById('page-desc').innerText  = tabMeta[name][1];
    }

    // ========== STATUS ==========
    const statusConfig = {
      tersedia:   { label: 'Tersedia',         dot: 'bg-green-600', pill: 'bg-green-100 text-green-800 border-green-200',  sidebar: '● Tersedia' },
      perjalanan: { label: 'Dalam Perjalanan', dot: 'bg-amber-500', pill: 'bg-amber-100 text-amber-800 border-amber-200',  sidebar: '● Dalam Perjalanan' },
      memeriksa:  { label: 'Sedang Memeriksa', dot: 'bg-blue-500',  pill: 'bg-blue-100 text-blue-800 border-blue-200',    sidebar: '● Sedang Memeriksa' },
      selesai:    { label: 'Sesi Selesai',      dot: 'bg-teal-600',  pill: 'bg-teal-100 text-teal-800 border-teal-200',    sidebar: '● Sesi Selesai' },
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

    // ========== JADWAL ==========
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
        document.getElementById('inputJLokasi').value = parts[1] || 'Home Visit';
        document.getElementById('inputJJam').value   = row.querySelector('.text-xs.font-bold').innerText || '';
      }
    }

    function closeJadwalModal() { document.getElementById('jadwalModal').classList.remove('show'); }

    function saveJadwal(e) {
      e.preventDefault();
      const id     = document.getElementById('jadwalId').value;
      const nama   = document.getElementById('inputJNama').value;
      const jam    = document.getElementById('inputJJam').value;
      const hewan  = document.getElementById('inputJHewan').value;
      const lokasi = document.getElementById('inputJLokasi').value;
      const inisial = nama.split(' ').map(n => n[0]).join('').substring(0,2).toUpperCase();

      if (id) {
        const row = document.getElementById('jadwal-row-' + id);
        row.querySelector('.cell-j-nama').innerText  = nama;
        row.querySelector('.cell-j-hewan').innerText = hewan + ' • ' + lokasi;
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
            <div class="text-[10px] text-gray-400 cell-j-hewan">${hewan} • ${lokasi}</div>
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

    // ========== REKAM MEDIS ==========
    let rekamCount = 3;

    function openRekamModal(mode, id = null) {
      document.getElementById('rekamModal').classList.add('show');
      if (mode === 'create') {
        document.getElementById('rekamModalTitle').innerText = 'Tambah Rekam Medis';
        document.getElementById('formRekam').reset();
        document.getElementById('rekamId').value = '';
      } else {
        document.getElementById('rekamModalTitle').innerText = 'Ubah Rekam Medis';
        document.getElementById('rekamId').value = id;
        const row = document.getElementById('rekam-row-' + id);
        document.getElementById('inputRHewan').value    = row.querySelector('.cell-r-hewan').innerText;
        document.getElementById('inputRJenis').value    = row.querySelector('.cell-r-jenis').innerText;
        document.getElementById('inputRPemilik').value  = row.querySelector('.cell-r-pemilik').innerText;
        document.getElementById('inputRDiagnosis').value= row.querySelector('.cell-r-diagnosis').innerText;
        document.getElementById('inputRTindakan').value = row.querySelector('.cell-r-tindakan').innerText;
        document.getElementById('inputRTanggal').value  = row.querySelector('.cell-r-tanggal').innerText;
      }
    }

    function closeRekamModal() { document.getElementById('rekamModal').classList.remove('show'); }

    function saveRekam(e) {
      e.preventDefault();
      const id       = document.getElementById('rekamId').value;
      const hewan    = document.getElementById('inputRHewan').value;
      const jenis    = document.getElementById('inputRJenis').value;
      const pemilik  = document.getElementById('inputRPemilik').value;
      const diag     = document.getElementById('inputRDiagnosis').value;
      const tindakan = document.getElementById('inputRTindakan').value;
      const tanggal  = document.getElementById('inputRTanggal').value;

      if (id) {
        const row = document.getElementById('rekam-row-' + id);
        row.querySelector('.cell-r-hewan').innerText    = hewan;
        row.querySelector('.cell-r-jenis').innerText    = jenis;
        row.querySelector('.cell-r-pemilik').innerText  = pemilik;
        row.querySelector('.cell-r-diagnosis').innerText= diag;
        row.querySelector('.cell-r-tindakan').innerText = tindakan;
        row.querySelector('.cell-r-tanggal').innerText  = tanggal;
      } else {
        rekamCount++;
        const tbody = document.getElementById('rekam-table-body');
        const tr = document.createElement('tr');
        tr.id = 'rekam-row-' + rekamCount;
        tr.className = 'hover:bg-[#FAF9F6]/50 transition-colors';
        tr.innerHTML = `
          <td class="py-4 pl-2"><div class="font-bold cell-r-hewan">${hewan}</div><div class="text-[10px] text-gray-400 cell-r-jenis">${jenis}</div></td>
          <td class="py-4 text-xs cell-r-pemilik">${pemilik}</td>
          <td class="py-4"><span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-bold cell-r-diagnosis">${diag}</span></td>
          <td class="py-4 text-xs cell-r-tindakan">${tindakan}</td>
          <td class="py-4 text-[10px] text-gray-400 cell-r-tanggal">${tanggal}</td>
          <td class="py-4"><div class="flex justify-center gap-2">
            <button onclick="openRekamModal('edit',${rekamCount})" class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg text-xs flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all"><i class="fa-solid fa-pen-to-square"></i></button>
            <button onclick="deleteRekam(${rekamCount},'${hewan}')" class="w-8 h-8 bg-red-50 text-red-400 rounded-lg text-xs flex items-center justify-center hover:bg-red-500 hover:text-white transition-all"><i class="fa-solid fa-trash"></i></button>
          </div></td>`;
        tbody.appendChild(tr);
      }
      closeRekamModal();
    }

    function deleteRekam(id, nama) {
      if (confirm(`Yakin hapus rekam medis "${nama}"?`)) document.getElementById('rekam-row-' + id)?.remove();
    }

    // ========== CHAT MODAL ==========
    const chatHistories = {
      'Rizal Kurniawan': [
        { from: 'user', text: 'Dok, Max masih belum mau makan sejak kemarin malam...' },
        { from: 'user', text: 'Saya khawatir dok, badannya juga terasa lebih panas dari biasanya.' },
      ],
      'Siti Aminah': [
        { from: 'dokter', text: 'Luna sehat ya bu, tinggal minum vitamin saja.' },
        { from: 'user', text: 'Dok, bisa reschedule besok ya?' },
      ],
      'Bunga Lestari': [
        { from: 'dokter', text: 'Obatnya sudah diminum bu?' },
        { from: 'user', text: 'Terima kasih dok, Mochi sudah membaik!' },
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
      (chatHistories[name] || []).forEach(m => appendChatBubble(m.from, m.text, false));
      document.getElementById('chatModal').classList.add('show');
      msgs.scrollTop = msgs.scrollHeight;
    }

    function closeChatModal() { document.getElementById('chatModal').classList.remove('show'); }

    function appendChatBubble(from, text, scroll = true) {
      const msgs = document.getElementById('chatMessages');
      const div  = document.createElement('div');
      div.className = from === 'dokter' ? 'flex justify-end' : 'flex justify-start';
      div.innerHTML = `<div class="max-w-[75%] px-4 py-2.5 rounded-2xl text-xs font-medium ${from === 'dokter' ? 'bg-[#5E887E] text-white rounded-br-sm' : 'bg-[#FAF9F6] text-[#2D433E] border border-gray-100 rounded-bl-sm'}">${text}</div>`;
      msgs.appendChild(div);
      if (scroll) msgs.scrollTop = msgs.scrollHeight;
    }

    function sendChat() {
      const input = document.getElementById('chatInput');
      const text  = input.value.trim();
      if (!text) return;
      appendChatBubble('dokter', text);
      if (!chatHistories[currentChatName]) chatHistories[currentChatName] = [];
      chatHistories[currentChatName].push({ from: 'dokter', text });
      input.value = '';
    }

    document.getElementById('chatInput').addEventListener('keydown', e => { if (e.key === 'Enter') sendChat(); });

    function submitPengajuanGaji(e) {
      e.preventDefault();
      alert('Pengajuan tarif berhasil dikirim ke Admin!');
    }
  </script>
</body>
</html>
