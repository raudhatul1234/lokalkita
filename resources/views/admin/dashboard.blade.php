<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard UMKM - LOKALKITA</title>

    <link rel="stylesheet" href="{{ asset('css/lokalkita.css') }}">
</head>

<body class="admin-page">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">

        <a href="{{ route('home') }}"
           class="admin-logo"
           title="Kembali ke Beranda LOKALKITA"
           style="text-decoration:none; cursor:pointer;">
            🌿 LOKALKITA
        </a>

        <nav class="admin-nav">

            <a href="{{ route('home') }}">
                🏠 Beranda LOKALKITA
            </a>

            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                ▦ Dashboard
            </a>

            <a href="{{ route('admin.products') }}"
               class="{{ request()->routeIs('admin.products') ? 'active' : '' }}">
                ▣ Produk Saya
            </a>

            <a href="{{ route('admin.orders') }}"
               class="{{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                ▤ Pesanan
            </a>

            <a href="{{ route('admin.profile') }}"
               class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                ♙ Profil UMKM
            </a>

            <a href="{{ route('admin.settings') }}"
               class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
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
                <h1>Dashboard UMKM</h1>
                <p>Selamat datang di halaman pengelolaan UMKM Anda.</p>
            </div>

            <div class="admin-user">
                <span>{{ auth()->user()->name ?? 'Pengguna' }}</span>

                <a href="{{ route('admin.profile') }}"
                   class="admin-profile"
                   title="Profil UMKM"
                   aria-label="Buka Profil UMKM">
                    <span>
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </span>
                </a>
            </div>

        </header>


        <!-- STATISTIK -->
        <section class="admin-stats">

            <article class="admin-stat-card">
                <div class="stat-icon green">▣</div>
                <div>
                    <p>Total Produk</p>
                    <h2>6</h2>
                    <small>Produk contoh di dashboard</small>
                </div>
            </article>

            <article class="admin-stat-card">
                <div class="stat-icon orange">▤</div>
                <div>
                    <p>Pesanan Masuk</p>
                    <h2>12</h2>
                    <small>Pesanan pelanggan</small>
                </div>
            </article>

            <article class="admin-stat-card">
                <div class="stat-icon mint">♧</div>
                <div>
                    <p>Pendapatan</p>
                    <h2>Rp 1.250.000</h2>
                    <small>Total pendapatan contoh</small>
                </div>
            </article>

        </section>


        <!-- DAFTAR PRODUK -->
        <section class="admin-products">

            <div class="admin-section-header">
                <div>
                    <h2>Produk Terbaru</h2>
                    <p>Daftar produk UMKM Anda</p>
                </div>

                <a href="{{ route('admin.products') }}"
                   class="admin-add-button">
                    + Tambah Produk
                </a>
            </div>

            @php
                $products = [
                    [
                        'id' => 1,
                        'name' => 'Keripik Pisang',
                        'price' => 15000,
                        'stock' => 50,
                        'icon' => '🍌'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Kopi Lokal',
                        'price' => 35000,
                        'stock' => 30,
                        'icon' => '☕'
                    ],
                    [
                        'id' => 3,
                        'name' => 'Madu Lokal',
                        'price' => 45000,
                        'stock' => 20,
                        'icon' => '🍯'
                    ],
                    [
                        'id' => 4,
                        'name' => 'Kue Lapis Legit',
                        'price' => 25000,
                        'stock' => 40,
                        'icon' => '🍰'
                    ],
                    [
                        'id' => 5,
                        'name' => 'Tas Anyaman',
                        'price' => 75000,
                        'stock' => 15,
                        'icon' => '👜'
                    ],
                    [
                        'id' => 6,
                        'name' => 'Batik Tulis',
                        'price' => 150000,
                        'stock' => 10,
                        'icon' => '👘'
                    ],
                ];
            @endphp

            <div class="admin-table-wrapper">
                <table class="admin-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <div class="admin-product-name">
                                        <span class="product-emoji">
                                            {{ $product['icon'] }}
                                        </span>

                                        {{ $product['name'] }}
                                    </div>
                                </td>

                                <td>
                                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                                </td>

                                <td>{{ $product['stock'] }}</td>

                                <td>
                                    <div class="admin-actions">

                                        <a href="{{ route('admin.products') }}"
                                           class="admin-edit"
                                           title="Edit produk"
                                           aria-label="Edit {{ $product['name'] }}">
                                            ✎
                                        </a>

                                        <button
                                            type="button"
                                            class="admin-delete"
                                            title="Hapus produk"
                                            aria-label="Hapus {{ $product['name'] }}"
                                            onclick="alert('Fitur hapus produk belum dihubungkan ke database.')">
                                            🗑
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </section>


        <!-- FOOTER -->
        <footer class="admin-footer">

            <a href="{{ route('home') }}"
               style="text-decoration:none; color:inherit;">
                🌿 Kembali ke Beranda LOKALKITA
            </a>

            <p>
                © {{ date('Y') }} LOKALKITA — Bersama UMKM, Maju Bersama
            </p>

        </footer>

    </main>

</body>
</html>
