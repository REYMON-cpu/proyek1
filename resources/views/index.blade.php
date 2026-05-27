<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GoPet</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #f4f7f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            background: #ffffff;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(26, 54, 43, 0.05);
            text-align: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .logo-section h2 {
            color: #1a362b; /* Hijau Ciri Khas GoPet */
            font-size: 28px;
            font-weight: 700;
        }

        .login-header h3 {
            color: #2d3748;
            font-size: 22px;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #a0aec0;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 14px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            font-size: 15px;
            color: #2d3748;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #1a362b;
            box-shadow: 0 0 0 4px rgba(26, 54, 43, 0.1);
        }

        .alert-error {
            background-color: #fed7d7;
            color: #c53030;
            padding: 12px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: left;
        }

        .btn-login {
            width: 100%;
            background-color: #1a362b; /* Hijau Tombol Dashboard */
            color: white;
            border: none;
            padding: 16px;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(26, 54, 43, 0.2);
        }

        .btn-login:hover {
            background-color: #11241d;
        }

        .footer-text {
            margin-top: 25px;
            font-size: 14px;
            color: #718096;
        }

        .footer-text a {
            color: #1a362b;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="logo-section">
        <img src="/images/logo hijau.svg" alt="GoPet Logo" style="height: 35px; onerror="this.style.display='none'">
        <h2>GoPet</h2>
    </div>

    <div class="login-header">
        <h3>Selamat Datang, Cees!</h3>
        <p>Silakan masuk untuk mengelola anabul kesayanganmu.</p>
    </div>

    @if(session('error'))
        <div class="alert-error">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login.proses') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>

        <div class="form-group">
            <label for="role">Masuk Sebagai</label>
            <select id="role" name="role">
                <option value="customer">Pemilik Hewan</option>
                <option value="dokter">Dokter Hewan</option>
                <option value="sitter">Pet Sitter</option>
            </select>
        </div>

        <button type="submit" class="btn-login">Masuk</button>
    </form>

    <div class="footer-text">
        Belum punya akun? <a href="#">Daftar Sekarang</a>
    </div>
</div>

</body>
</html>