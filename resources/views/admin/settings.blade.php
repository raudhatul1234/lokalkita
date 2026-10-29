<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengaturan - LOKALKITA</title>

    <link rel="stylesheet" href="{{ asset('css/lokalkita.css') }}">
</head>

<body class="admin-page">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">

        <a href="{{ route('admin.dashboard') }}" class="admin-logo">
            🌿 LOKALKITA
        </a>

        <nav class="admin-nav">

            <a href="{{ route('admin.dashboard') }}">
                ▦ Dashboard
            </a>

            <a href="{{ route('admin.products') }}">
                ▣ Produk Saya
            </a>

            <a href="{{ route('admin.orders') }}">
                ▤ Pesanan
            </a>

            <a href="{{ route('admin.profile') }}">
                ♙ Profil UMKM
            </a>

            <a href="{{ route('admin.settings') }}" class="active">
                ⚙ Pengaturan
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="admin-logout">
                    ↪ Logout
                </button>
            </form>

        </nav>
    </aside>


    <!-- KONTEN UTAMA -->
    <main class="admin-main">

        <!-- HEADER -->
        <header class="admin-header">

            <div>
                <h1>Pengaturan</h1>
                <p>Kelola preferensi akun LOKALKITA kamu.</p>
            </div>

            <div class="admin-user">
                <span>{{ auth()->user()->name ?? 'Pengguna' }}</span>

                <a href="{{ route('admin.profile') }}"
                   class="admin-profile"
                   title="Profil UMKM">
                    <span>
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </span>
                </a>
            </div>

        </header>


        <!-- PENGATURAN AKUN -->
        <section class="admin-products">

            <div class="admin-section-header">
                <div>
                    <h2>Pengaturan Akun</h2>
                    <p>Informasi akun yang sedang kamu gunakan.</p>
                </div>
            </div>

            <div style="max-width:650px; padding:20px 0;">

                <!-- NAMA -->
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px;">
                        Nama Pengguna
                    </label>

                    <input
                        type="text"
                        value="{{ auth()->user()->name ?? '' }}"
                        readonly
                        style="width:100%; box-sizing:border-box; padding:12px; border:1px solid #ddd; border-radius:8px; background:#f5f5f5;">
                </div>

                <!-- EMAIL -->
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px;">
                        Email Akun
                    </label>

                    <input
                        type="email"
                        value="{{ auth()->user()->email ?? '' }}"
                        readonly
                        style="width:100%; box-sizing:border-box; padding:12px; border:1px solid #ddd; border-radius:8px; background:#f5f5f5;">
                </div>

                <!-- KEAMANAN -->
                <div style="padding:20px; background:#f0f8f4; border-radius:10px; margin-bottom:22px;">
                    <h3 style="margin-top:0; color:#075b49;">
                        🔒 Keamanan Akun
                    </h3>

                    <p style="margin-bottom:0;">
                        Jaga kerahasiaan kata sandi kamu.
                        Jangan membagikan kata sandi kepada orang lain.
                    </p>
                </div>

                <!-- STATUS -->
                <div style="padding:20px; border:1px solid #e5e7eb; border-radius:10px; margin-bottom:22px;">
                    <h3 style="margin-top:0;">
                        Status Akun
                    </h3>

                    <p>
                        Akun kamu sedang digunakan untuk mengakses
                        dashboard LOKALKITA.
                    </p>

                    <span style="display:inline-block; padding:6px 12px; background:#e0f5e8; color:#087443; border-radius:20px;">
                        ● Aktif
                    </span>
                </div>

                <!-- TOMBOL PROFIL -->
                <a href="{{ route('admin.profile') }}"
                   class="admin-add-button"
                   style="display:inline-block; text-decoration:none;">
                    Lihat Profil UMKM
                </a>

            </div>

        </section>


        <!-- FOOTER -->
        <footer class="admin-footer">

            <a href="{{ route('admin.dashboard') }}">
                ← Kembali ke Dashboard
            </a>

            <p>
                © {{ date('Y') }} LOKALKITA — Bersama UMKM, Maju Bersama
            </p>

        </footer>

    </main>

</body>
</html>