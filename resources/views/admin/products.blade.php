<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Produk Saya - LOKALKITA</title>

    <link rel="stylesheet" href="{{ asset('css/lokalkita.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        .products-content {
            width: 100%;
            min-width: 0;
        }

        .product-toolbar {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin: 20px 0;
            align-items: center;
        }

        .product-toolbar input,
        .product-toolbar select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            min-width: 180px;
            flex: 1;
            background: #fff;
            font: inherit;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 22px;
            margin-top: 24px;
        }

        .product-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .05);
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: transform .2s, box-shadow .2s;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .09);
        }

        /* GAMBAR PRODUK */
        .product-image-wrapper {
            width: 100%;
            height: 210px;
            overflow: hidden;
            background: #f3f4f6;
        }

        .product-image {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            background: #f3f4f6;
        }

        .product-no-image {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
            justify-content: center;
            color: #777;
            background: #f3f4f6;
            text-align: center;
            padding: 12px;
        }

        .product-no-image span {
            font-size: 38px;
        }

        .product-no-image p {
            margin: 0;
            font-size: 14px;
        }

        .product-card-body {
            padding: 18px;
            display: flex;
            flex-direction: column;
            flex: 1;
            overflow-wrap: anywhere;
        }

        .product-card-body h3 {
            margin: 0 0 8px;
            font-size: 18px;
        }

        .product-category {
            display: inline-block;
            background: #e8f5e9;
            color: #28733a;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 12px;
            align-self: flex-start;
        }

        .product-price {
            color: #28733a;
            font-weight: bold;
            font-size: 19px;
            margin: 8px 0;
        }

        .product-info {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }

        .product-description {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin: 12px 0;
        }

        .stock-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .stock-available {
            background: #e8f5e9;
            color: #28733a;
        }

        .stock-low {
            background: #fff4db;
            color: #8a5b00;
        }

        .stock-empty {
            background: #fdecec;
            color: #b42318;
        }

        .product-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: auto;
            padding-top: 15px;
        }

        .product-actions form {
            margin: 0;
        }

        .product-delete,
        .product-edit,
        .product-button {
            display: inline-block;
            border: none;
            cursor: pointer;
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            text-align: center;
        }

        .product-delete {
            background: #b42318;
            color: white;
        }

        .product-delete:hover {
            background: #8f1b13;
        }

        .product-edit {
            background: #e8f5e9;
            color: #246b36;
        }

        .product-edit:hover {
            background: #d4ead7;
        }

        .product-button {
            background: #28733a;
            color: white;
        }

        .product-button:hover {
            background: #205d2e;
        }

        .alert-success,
        .alert-error {
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .alert-success {
            background: #e8f7e9;
            color: #216e2d;
        }

        .alert-error {
            background: #fdecec;
            color: #a32121;
        }

        .product-empty {
            text-align: center;
            padding: 35px 15px;
            color: #666;
            background: #f9fafb;
            border-radius: 12px;
            margin-top: 24px;
        }

        .product-empty-icon {
            font-size: 45px;
            margin-bottom: 10px;
        }

        .product-count {
            color: #555;
            margin-top: 8px;
        }

        .product-pagination {
            margin-top: 25px;
            overflow-x: auto;
        }

        .product-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin: 20px 0;
        }

        .product-stat {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .03);
        }

        .product-stat-label {
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
        }

        .product-stat-value {
            font-size: 25px;
            font-weight: 700;
            color: #28733a;
        }

        .product-toolbar-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        @media (max-width: 600px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            .product-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .product-toolbar input,
            .product-toolbar select {
                width: 100%;
                min-width: 0;
            }

            .product-card {
                max-width: 100%;
            }

            .product-toolbar-actions {
                display: grid;
                grid-template-columns: 1fr;
                width: 100%;
            }

            .product-toolbar-actions > * {
                width: 100%;
            }
        }
    </style>
</head>

<body class="admin-page">

    {{-- SIDEBAR --}}
    <aside class="admin-sidebar">

        <a href="{{ route('admin.dashboard') }}" class="admin-logo">
            🌿 LOKALKITA
        </a>

        <nav class="admin-nav">

            <a href="{{ route('admin.dashboard') }}">
                ▦ Dashboard
            </a>

            <a href="{{ route('admin.products') }}" class="active">
                ▣ Produk Saya
            </a>

            <a href="{{ route('admin.orders') }}">
                ▤ Pesanan
            </a>

            <a href="{{ route('admin.profile') }}">
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

    {{-- KONTEN UTAMA --}}
    <main class="admin-main">

        <header class="admin-header">
            <div>
                <h1>Produk Saya</h1>
                <p>Kelola produk UMKM kamu di LOKALKITA.</p>
            </div>
        </header>

        <section class="admin-products products-content">

            {{-- NOTIFIKASI SUKSES --}}
            @if (session('success'))
                <div class="alert-success" role="status">
                    {{ session('success') }}
                </div>
            @endif

            {{-- NOTIFIKASI ERROR --}}
            @if (session('error'))
                <div class="alert-error" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- VALIDASI ERROR --}}
            @if ($errors->any())
                <div class="alert-error" role="alert">
                    <strong>Terjadi kesalahan:</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- JUDUL DAN TOMBOL TAMBAH --}}
            <div class="admin-section-header">
                <div>
                    <h2>Daftar Produk</h2>

                    <p class="product-count">
                        Produk ditemukan:
                        <strong>{{ $products->total() }}</strong>
                    </p>
                </div>

                <a
                    href="{{ route('admin.products.create') }}"
                    class="admin-add-button"
                >
                    + Tambah Produk
                </a>
            </div>

            {{-- STATISTIK PRODUK --}}
            <div class="product-stats">

                <div class="product-stat">
                    <div class="product-stat-label">
                        Total Produk
                    </div>

                    <div class="product-stat-value">
                        {{ \App\Models\Product::count() }}
                    </div>
                </div>

                <div class="product-stat">
                    <div class="product-stat-label">
                        Stok Tersedia
                    </div>

                    <div class="product-stat-value">
                        {{ \App\Models\Product::where('stock', '>', 0)->count() }}
                    </div>
                </div>

                <div class="product-stat">
                    <div class="product-stat-label">
                        Produk Habis
                    </div>

                    <div class="product-stat-value">
                        {{ \App\Models\Product::where('stock', '<=', 0)->count() }}
                    </div>
                </div>

            </div>

            {{-- PENCARIAN DAN FILTER --}}
            <form
                action="{{ route('admin.products') }}"
                method="GET"
                class="product-toolbar"
            >

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama, deskripsi, atau penjual..."
                    aria-label="Cari produk"
                >

                <select name="category_id" aria-label="Filter kategori">
                    <option value="">Semua Kategori</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected(
                                (string) request('category_id') ===
                                (string) $category->id
                            )
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select name="sort" aria-label="Urutkan produk">

                    <option
                        value="latest"
                        @selected(request('sort', 'latest') === 'latest')
                    >
                        Terbaru
                    </option>

                    <option
                        value="name"
                        @selected(request('sort') === 'name')
                    >
                        Nama A–Z
                    </option>

                    <option
                        value="price_low"
                        @selected(request('sort') === 'price_low')
                    >
                        Harga terendah
                    </option>

                    <option
                        value="price_high"
                        @selected(request('sort') === 'price_high')
                    >
                        Harga tertinggi
                    </option>

                    <option
                        value="stock"
                        @selected(request('sort') === 'stock')
                    >
                        Stok terendah
                    </option>

                </select>

                <div class="product-toolbar-actions">

                    <button type="submit" class="product-button">
                        🔍 Terapkan
                    </button>

                    @if (
                        request()->filled('search') ||
                        request()->filled('category_id') ||
                        request()->filled('sort')
                    )
                        <a
                            href="{{ route('admin.products') }}"
                            class="product-edit"
                        >
                            Reset Filter
                        </a>
                    @endif

                </div>

            </form>

            {{-- DAFTAR PRODUK --}}
            @if ($products->count() > 0)

                <div class="product-grid">

                    @foreach ($products as $product)

                        <article class="product-card">

                            {{-- GAMBAR PRODUK --}}
                            <div class="product-image-wrapper">

                                @php
                                    $imageValue = $product->image_url;
                                    $imageUrl = null;

                                    if ($imageValue) {
                                        $imageValue = str_replace(
                                            '\\',
                                            '/',
                                            $imageValue
                                        );

                                        if (
                                            str_starts_with(
                                                $imageValue,
                                                'http://'
                                            ) ||
                                            str_starts_with(
                                                $imageValue,
                                                'https://'
                                            )
                                        ) {
                                            $imageUrl = $imageValue;
                                        } elseif (
                                            str_starts_with(
                                                $imageValue,
                                                '/images/'
                                            )
                                        ) {
                                            $imageUrl = asset(
                                                ltrim($imageValue, '/')
                                            );
                                        } elseif (
                                            str_starts_with(
                                                $imageValue,
                                                'images/'
                                            )
                                        ) {
                                            $imageUrl = asset($imageValue);
                                        } else {
                                            $imageUrl = asset(
                                                'images/products/' .
                                                basename($imageValue)
                                            );
                                        }
                                    }
                                @endphp

                                @if ($imageUrl)
                                    <img
                                        class="product-image"
                                        src="{{ $imageUrl }}"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >

                                    <div
                                        class="product-no-image"
                                        style="display: none;"
                                    >
                                        <span>📦</span>
                                        <p>Gambar gagal dimuat</p>
                                    </div>
                                @else
                                    <div class="product-no-image">
                                        <span>📦</span>
                                        <p>Belum ada gambar</p>
                                    </div>
                                @endif

                            </div>

                            {{-- INFORMASI PRODUK --}}
                            <div class="product-card-body">

                                <span class="product-category">
                                    {{ $product->category->name ?? 'Tanpa kategori' }}
                                </span>

                                <h3>{{ $product->name }}</h3>

                                <div class="product-price">
                                    Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                </div>

                                {{-- STATUS STOK --}}
                                <p class="product-info">
                                    Stok:
                                    <strong>{{ $product->stock }}</strong>

                                    @if ($product->stock <= 0)
                                        <span class="stock-badge stock-empty">
                                            Habis
                                        </span>
                                    @elseif ($product->stock <= 5)
                                        <span class="stock-badge stock-low">
                                            Stok menipis
                                        </span>
                                    @else
                                        <span class="stock-badge stock-available">
                                            Tersedia
                                        </span>
                                    @endif
                                </p>

                                {{-- PENJUAL --}}
                                <p class="product-info">
                                    Penjual:
                                    {{ $product->seller_name ?: '-' }}
                                </p>

                                {{-- DESKRIPSI --}}
                                <div class="product-description">
                                    @if ($product->description)
                                        {{ \Illuminate\Support\Str::limit($product->description, 110) }}
                                    @else
                                        Belum ada deskripsi produk.
                                    @endif
                                </div>

                                {{-- AKSI PRODUK --}}
                                <div class="product-actions">

                                    <a
                                        href="{{ route('admin.products.edit', $product->id) }}"
                                        class="product-edit"
                                    >
                                        ✏️ Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.products.destroy', $product->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="product-delete"
                                        >
                                            🗑️ Hapus
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

                {{-- PAGINATION --}}
                <div class="product-pagination">
                    {{ $products->links() }}
                </div>

            @else

                {{-- PRODUK KOSONG --}}
                <div class="product-empty">

                    <div class="product-empty-icon">📦</div>

                    <h3>Produk belum ditemukan</h3>

                    @if (
                        request()->filled('search') ||
                        request()->filled('category_id')
                    )
                        <p>
                            Tidak ada produk yang sesuai dengan pencarian
                            atau kategori yang dipilih.
                        </p>

                        <a
                            href="{{ route('admin.products') }}"
                            class="product-button"
                        >
                            Reset Pencarian
                        </a>
                    @else
                        <p>
                            Kamu belum menambahkan produk ke LOKALKITA.
                        </p>

                        <a
                            href="{{ route('admin.products.create') }}"
                            class="product-button"
                        >
                            + Tambah Produk Pertama
                        </a>
                    @endif

                </div>

            @endif

            {{-- KEMBALI KE DASHBOARD --}}
            <div style="margin-top: 25px;">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="admin-add-button"
                >
                    ← Kembali ke Dashboard
                </a>
            </div>

        </section>

    </main>

</body>
</html>