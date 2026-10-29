<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - LOKALKITA</title>
    <link rel="stylesheet" href="{{ asset('css/lokalkita.css') }}">
</head>
<body class="auth-page">

    <main class="auth-container">
        <section class="auth-banner">
            <h2>🌿 LOKALKITA</h2>
            <p>Bersama UMKM, Maju Bersama</p>

            <div class="auth-product-image">
                <img
                    src="{{ asset('images/products/produk-umkm.png') }}"
                    alt="Produk UMKM lokal"
                >
            </div>
        </section>

        <section class="auth-form-panel">
            <div class="auth-tabs">
                <a href="{{ route('login') }}" class="active">Masuk</a>
                <a href="{{ route('register') }}">Daftar</a>
            </div>

            <h2>Masuk ke Akun Anda</h2>
            <p class="auth-description">
                Silakan masuk untuk melanjutkan
            </p>

            @if ($errors->any())
                <div class="auth-error">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="auth-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                >

                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >

                <div class="auth-options">
                    <label class="remember-option">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >
                        Ingat saya
                    </label>

                    <a href="#" class="forgot-link">
                        Lupa password?
                    </a>
                </div>

                <button type="submit" class="auth-submit">
                    Masuk
                </button>
            </form>

            <div class="auth-divider">atau</div>

            <button type="button" class="social-login">
                <span>🌐</span> Login dengan Google
            </button>

            <button type="button" class="social-login">
                <span>📘</span> Login dengan Facebook
            </button>

            <p class="auth-switch">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </p>
        </section>
    </main>

</body>
</html>
