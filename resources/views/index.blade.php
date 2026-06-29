<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login GoPet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; overflow-x: hidden; }

        @keyframes kartuMasuk {
            from { opacity: 0; transform: scale(0.9) translateY(30px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes slideDariKiri {
            from { opacity: 0; transform: translateX(-100px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes zoomGemas {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }

        .anim-kartu {
            animation: kartuMasuk 1s ease-out forwards;
        }
        .anim-teks {
            opacity: 0;
            animation: slideDariKiri 0.8s ease-out 0.6s forwards;
        }
        .anim-foto {
            opacity: 0;
            animation: zoomGemas 1.2s cubic-bezier(0.34, 1.56, 0.64, 1) 1s forwards;
        }
        .anim-form {
            opacity: 0;
            animation: kartuMasuk 0.8s ease-out 1.3s forwards;
        }
    </style>
</head>

<body class="bg-[#FDF5E6] flex items-center justify-center min-h-screen p-4">

    <div class="anim-kartu bg-white rounded-[30px] shadow-2xl overflow-hidden max-w-[930px] w-full flex flex-col md:flex-row">

        <div class="md:w-1/2 bg-[#5E887E] p-10 flex flex-col justify-between text-white">
            <div class="anim-teks">
                <div class="flex items-center gap-2 mb-8">
                    <img src="{{ asset('images/logo putih.svg') }}" alt="Logo" class="h-11 w-auto">
                    <h2 class="text-3xl font-bold tracking-tight text-white">Go<span class="text-[#D9B08C]">Pet</span></h2>
                </div>

                <h1 class="text-3xl lg:text-4xl font-bold leading-tight mb-5">
                    Bikin anabul makin happy dan terawat.
                </h1>
                <p class="text-base opacity-90 leading-relaxed mb-6">
                    Booking jasa pet care gak pakai ribet. Mulai dari pet sitting sampai konsultasi ahli, semua ada di GoPet!
                </p>
            </div>

            <div class="w-full anim-foto">
                <img src="{{ asset('images/gopet form.jpeg') }}"
                     alt="Anabul"
                     class="w-full h-52 lg:h-56 object-cover rounded-[20px] shadow-md border-2 border-white/20 transition-transform duration-500 hover:scale-105">
            </div>
        </div>

        <div class="md:w-1/2 p-10 flex flex-col justify-center bg-white anim-form">
            <h2 class="text-3xl font-bold text-[#4A4A4A] mb-1">Buat Akun</h2>
            <p class="text-sm text-gray-500 mb-6">Lengkapi data di bawah untuk bergabung dengan komunitas GoPet.</p>

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4 text-center font-bold text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-[#5E887E] mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:border-[#5E887E] focus:bg-white outline-none transition-all duration-300" placeholder="contoh@gmail.com">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#5E887E] mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:border-[#5E887E] focus:bg-white outline-none" placeholder="••••••••">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#5E887E] mb-1">Masuk Sebagai</label>
                    <div class="relative">
                        <select id="role" name="role" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:border-[#5E887E] focus:bg-white outline-none transition-all duration-300 appearance-none">
                            <option value="Pemilik Hewan">Pemilik Hewan</option>
                            <option value="Penyedia Jasa">Penyedia Jasa</option>
                            <option value="Admin">Admin</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full bg-[#5E887E] hover:bg-[#4a6b63] text-white font-bold py-3.5 rounded-xl shadow-lg transition-all duration-300 active:scale-95">
                        Masuk
                    </button>
                </div>
            </form>

            <p class="mt-5 text-center text-sm text-gray-500">
                Belum punya akun? <a href="{{ url('/register') }}" class="text-[#5E887E] font-bold">Daftar di sini</a>
            </p>
        </div>

    </div>

</body>
</html>
