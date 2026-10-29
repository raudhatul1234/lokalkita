<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'LOKALKITA - Produk UMKM Lokal')</title>

    <meta name="description" content="Temukan produk UMKM lokal Indonesia di LOKALKITA.">

    <link rel="stylesheet" href="{{ asset('css/lokalkita.css') }}">
</head>
<body>

    <!-- NAVBAR -->
    <header class="topbar">

        <!-- LOGO -->
        <a href="{{ route('home') }}" class="brand">
            🌿 LOKALKITA
        </a>

        <!-- MENU NAVIGASI -->
        <nav class="nav-links">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('products.index') }}">Produk</a>
            <a href="{{ route('about') }}">Tentang</a>
            <a href="#kontak">Kontak</a>
        </nav>

        <!-- PENCARIAN PRODUK -->
        <form class="search" action="{{ route('home') }}" method="GET">
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari produk..."
                aria-label="Cari produk"
            >

            <button type="submit" aria-label="Cari">
                🔍
            </button>
        </form>

        <!-- TOMBOL PROFIL, KERANJANG, DAN KELUAR -->
        <div class="navbar-actions">

            @auth
                <!-- PROFIL / DASHBOARD -->
                @if (auth()->user()->role === 'admin')
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="navbar-profile"
                        title="Dashboard Admin"
                        aria-label="Dashboard Admin"
                    >
                        👤
                    </a>
                @else
                    <a
                        href="{{ route('home') }}"
                        class="navbar-profile"
                        title="Akun Saya"
                        aria-label="Akun Saya"
                    >
                        👤
                    </a>
                @endif

                <!-- KERANJANG BELANJA -->
                <a
                    href="{{ route('cart.index') }}"
                    class="navbar-cart"
                    title="Keranjang Belanja"
                    aria-label="Keranjang Belanja"
                >
                    🛒
                </a>

                <!-- TOMBOL KELUAR -->
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="logout-form"
                    onsubmit="return confirm('Apakah kamu yakin ingin keluar?')"
                >
                    @csrf

                    <button
                        type="submit"
                        class="navbar-logout"
                        title="Keluar dari akun"
                        aria-label="Keluar dari akun"
                    >
                        🚪 <span>Keluar</span>
                    </button>
                </form>

            @else
                <!-- JIKA BELUM LOGIN -->
                <a
                    href="{{ route('login') }}"
                    class="navbar-profile"
                    title="Masuk"
                    aria-label="Masuk ke akun"
                >
                    👤
                </a>

                <a
                    href="{{ route('register') }}"
                    class="navbar-register"
                >
                    Daftar
                </a>
            @endauth

        </div>

    </header>

    <!-- PESAN SUKSES -->
    @if (session('success'))
        <div class="alert-success" role="status">
            {{ session('success') }}
        </div>
    @endif

    <!-- PESAN ERROR VALIDASI -->
    @if ($errors->any())
        <div class="alert-error" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- KONTEN HALAMAN -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer" id="kontak">
        <h3>🌿 LOKALKITA</h3>

        <p>Mendukung UMKM lokal, memajukan ekonomi Indonesia.</p>

        <p>&copy; {{ date('Y') }} LOKALKITA. Semua hak dilindungi.</p>
    </footer>

</body>
</html>
