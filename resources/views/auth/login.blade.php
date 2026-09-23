<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MiniSoccer Book</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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
        }

        .login-container {
            width: 100%;
            max-width: 490px;
            background: white;
            padding: 45px;
            border-radius: 22px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo h2 {
            color: #172b24;
            font-size: 25px;
        }

        .logo span {
            color: #13b981;
        }

        .welcome {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome h1 {
            font-size: 25px;
            color: #172b24;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #888;
            font-size: 14px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: #26352f;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            height: 52px;
            padding: 0 16px;
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

        .login-button {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 10px;
            background: #13b981;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.2s;
        }

        .login-button:hover {
            background: #0fa574;
        }

        .register {
            text-align: center;
            margin-top: 20px;
            color: #888;
            font-size: 14px;
        }

        .register a {
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

        @media (max-width: 600px) {
            .login-container {
                margin: 20px;
                padding: 30px 25px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div style="text-align: center; margin-bottom: 10px;">
            <h2 style="color: #172b24; font-size: 30px;">
                <i class="fas fa-futbol" style="color: #10b981;"></i>
                MiniSoccer<span style="color: #10b981;">Book</span>
            </h2>
        </div>

        <div class="welcome">
            <h1>Welcome Back!</h1>
            <p>
                Login akun MiniSoccer Book dan amankan jadwal
                tanding tim kesayanganmu.
            </p>
        </div>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukan email Anda" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
            </div>
            <button type="submit" class="login-button">
                Login
            </button>
        </form>

        <div class="register">
            Belum punya akun?
            <a class="small" href="{{ route('register') }}" style="color:#10b981;">
                Daftar di sini
            </a>
        </div>

    </div>

</body>

</html>
