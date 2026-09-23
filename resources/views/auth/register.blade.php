<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MiniSoccer Book</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f8f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 650px;
            background: white;
            padding: 35px 45px;
            border-radius: 22px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .logo {
            text-align: center;
            margin-bottom: 18px;
        }

        .logo h2 {
            color: #172b24;
            font-size: 30px;
        }

        .logo span {
            color: #10b981;
        }

        .welcome {
            text-align: center;
            margin-bottom: 25px;
        }

        .welcome h1 {
            font-size: 25px;
            color: #172b24;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #888;
            font-size: 14px;
        }

        /* Membuat form menjadi 2 kolom */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: #26352f;
            margin-bottom: 7px;
        }

        .form-group input {
            width: 100%;
            height: 48px;
            padding: 0 14px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #13b981;
            box-shadow: 0 0 0 3px rgba(19, 185, 129, 0.1);
        }

        .register-button {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 10px;
            background: #13b981;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 5px;
            transition: 0.2s;
        }

        .register-button:hover {
            background: #0fa574;
        }

        .login {
            text-align: center;
            margin-top: 18px;
            color: #888;
            font-size: 14px;
        }

        .login a {
            color: #13b981;
            font-weight: bold;
            text-decoration: none;
        }

        .error {
            background: #ffe8e8;
            color: #d33;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        /* HP */
        @media (max-width: 600px) {
            .register-container {
                padding: 30px 25px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .form-group.full {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

    <div class="register-container">

        <div class="logo">
            <h2>
                <i class="fas fa-futbol" style="color:#10b981;"></i>
                MiniSoccer<span>Book</span>
            </h2>
        </div>

        <div class="welcome">
            <h1>Create Account</h1>
            <p>Daftar akun untuk melakukan booking lapangan dengan tim kesayanganmu.</p>
        </div>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-row">

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" placeholder="Nama lengkap" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Contoh:nama@email.com" required>
                </div>

                <div class="form-group">
                    <label for="no_telepon">No. Telepon</label>
                    <input type="tel" id="no_telepon" name="no_telepon" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" placeholder="Alamat lengkap" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Ulangi password" required>
                </div>

            </div>

            <button type="submit" class="register-button">
                Daftar
            </button>

        </form>

        <div class="login">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login di sini</a>
        </div>

    </div>

</body>

</html>
