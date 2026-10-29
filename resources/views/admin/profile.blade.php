<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil UMKM - LOKALKITA</title>

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

            <a href="{{ route('admin.profile') }}" class="active">
                ♙ Profil UMKM
            </a>

            <a href="{{ route('admin.settings') }}">
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
                <h1>Profil UMKM</h1>
                <p>Lengkapi informasi usaha kamu di LOKALKITA.</p>
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


        <!-- FORM PROFIL -->
        <section class="admin-products">

            <div class="admin-section-header">
                <div>
                    <h2>Informasi Usaha</h2>
                    <p>Masukkan informasi dasar UMKM kamu.</p>
                </div>
            </div>

            @if (session('success'))
                <p style="color: green;">
                    {{ session('success') }}
                </p>
            @endif

            <form action="{{ route('admin.profile') }}"
                  method="POST"
                  style="max-width: 650px; padding: 20px 0;">

                @csrf

                <div style="margin-bottom: 18px;">
                    <label for="owner_name">Nama Pemilik</label>

                    <input
                        type="text"
                        id="owner_name"
                        name="owner_name"
                        value="{{ old('owner_name', auth()->user()->name) }}"
                        required
                        maxlength="100"
                        style="display:block; width:100%; box-sizing:border-box; padding:12px; margin-top:8px; border:1px solid #ddd; border-radius:8px;">
                </div>

                <div style="margin-bottom: 18px;">
                    <label for="business_name">Nama UMKM</label>

                    <input
                        type="text"
                        id="business_name"
                        name="business_name"
                        value="{{ old('business_name') }}"
                        placeholder="Contoh: Keripik Makmur"
                        required
                        maxlength="150"
                        style="display:block; width:100%; box-sizing:border-box; padding:12px; margin-top:8px; border:1px solid #ddd; border-radius:8px;">
                </div>

                <div style="margin-bottom: 18px;">
                    <label for="email">Email</label>

                    <input
                        type="email"
                        id="email"
                        value="{{ auth()->user()->email }}"
                        readonly
                        style="display:block; width:100%; box-sizing:border-box; padding:12px; margin-top:8px; border:1px solid #ddd; border-radius:8px; background:#f5f5f5;">
                </div>

                <div style="margin-bottom: 18px;">
                    <label for="phone">Nomor Telepon</label>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="Contoh: 081234567890"
                        maxlength="20"
                        style="display:block; width:100%; box-sizing:border-box; padding:12px; margin-top:8px; border:1px solid #ddd; border-radius:8px;">
                </div>

                <div style="margin-bottom: 18px;">
                    <label for="address">Alamat Usaha</label>

                    <textarea
                        id="address"
                        name="address"
                        rows="4"
                        maxlength="1000"
                        placeholder="Masukkan alamat usaha"
                        style="display:block; width:100%; box-sizing:border-box; padding:12px; margin-top:8px; border:1px solid #ddd; border-radius:8px;">{{ old('address') }}</textarea>
                </div>

                <button type="submit"
                        class="admin-add-button"
                        style="border:none; cursor:pointer;">
                    Simpan Profil
                </button>

            </form>

        </section>


        <!-- FOOTER -->
        <footer class="admin-footer">
            <a href="{{ route('admin.dashboard') }}">
                ← Kembali ke Dashboard
            </a>

            <p>© {{ date('Y') }} LOKALKITA — Bersama UMKM, Maju Bersama</p>
        </footer>

    </main>

</body>
</html>
