<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - LOKALKITA</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f1f8f2;
            color: #222;
        }

        .register-container {
            width: 100%;
            max-width: 440px;
            padding: 32px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .logo {
            text-align: center;
            font-size: 27px;
            font-weight: bold;
            color: #28733a;
            margin-bottom: 10px;
        }

        h1 {
            text-align: center;
            font-size: 25px;
            margin: 15px 0 8px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 17px;
        }

        label {
            display: block;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 7px;
        }

        input {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #28733a;
            box-shadow: 0 0 0 3px rgba(40, 115, 58, 0.1);
        }

        .register-button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #28733a;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 5px;
        }

        .register-button:hover {
            background: #205d2e;
        }

        .error-box {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 8px;
            background: #fdecec;
            color: #a32121;
            font-size: 14px;
        }

        .success-box {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 8px;
            background: #e8f7e9;
            color: #216e2d;
            font-size: 14px;
        }

        .login-link {
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
            color: #666;
        }

        .login-link a {
            color: #28733a;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 24px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="register-container">

        <div class="logo">🌿 LOKALKITA</div>

        <h1>Buat Akun Baru</h1>

        <p class="subtitle">
            Bergabung dan dukung produk UMKM lokal.
        </p>

        @if (session('success'))
            <div class="success-box">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-box">
                <strong>Pendaftaran gagal:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    maxlength="255"
                    autocomplete="name"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Alamat email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    maxlength="255"
                    autocomplete="email"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Kata sandi</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    Konfirmasi kata sandi
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi kata sandi"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >
            </div>

            <button type="submit" class="register-button">
                Daftar Sekarang
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun?
            <a href="{{ route('login') }}">Masuk di sini</a>
        </div>

    </div>

</body>
</html>