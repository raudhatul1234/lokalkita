@extends('layouts.app')

@section('title', $product->name . ' - LOKALKITA')

@section('content')
@php
    $image = $product->image_url;

    if (!$image) {
        $image = asset('images/products/default.svg');
    } elseif (
        !str_starts_with($image, 'http://') &&
        !str_starts_with($image, 'https://')
    ) {
        $image = asset(ltrim($image, '/'));
    }
@endphp

<div class="lk-product-page">

    <a href="{{ route('products.index') }}" class="lk-back">
        ← Kembali ke daftar produk
    </a>

    @if (session('success'))
        <div class="lk-alert lk-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="lk-alert lk-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="lk-alert lk-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="lk-product-card">

        {{-- KOLOM GAMBAR --}}
        <div class="lk-gallery">

            <div class="lk-main-image">
                <img
                    src="{{ $image }}"
                    alt="{{ $product->name }}"
                    onerror="this.onerror=null;this.src='https://placehold.co/600x500/e8f2ed/0b4f3c?text=Foto+Produk';"
                >
            </div>

            <div class="lk-image-caption">
                <span>🌿 Produk Lokal Pilihan</span>
                <span>✓ Mendukung UMKM</span>
            </div>

        </div>

        {{-- KOLOM INFORMASI --}}
        <div class="lk-product-info">

            <div class="lk-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <a href="{{ route('products.index') }}">Produk</a>
                <span>/</span>
                <span>{{ $product->category->name ?? 'Lokal' }}</span>
            </div>

            <span class="lk-category">
                {{ $product->category->name ?? 'Produk Lokal' }}
            </span>

            <h1>{{ $product->name }}</h1>

            <p class="lk-seller">
                Dijual oleh
                <strong>{{ $product->seller_name ?: 'UMKM Lokal' }}</strong>
            </p>

            <div class="lk-price-box">
                <span class="lk-price-label">Harga produk</span>
                <div class="lk-price">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
            </div>

            <div class="lk-stock">
                <span class="lk-stock-dot"></span>

                @if ($product->stock > 0)
                    <span>
                        Stok tersedia:
                        <strong>{{ $product->stock }} barang</strong>
                    </span>
                @else
                    <span class="lk-out-of-stock">
                        Stok sedang habis
                    </span>
                @endif
            </div>

            <div class="lk-divider"></div>

            {{-- TAMBAH KE KERANJANG --}}
            @if ($product->stock > 0)

                @auth
                    <form
                        action="{{ route('cart.add', $product->id) }}"
                        method="POST"
                        class="lk-cart-form"
                    >
                        @csrf

                        <label for="lk-quantity">
                            Jumlah pembelian
                        </label>

                        <div class="lk-quantity-control">
                            <button
                                type="button"
                                class="lk-quantity-btn"
                                onclick="changeQuantity(-1)"
                                aria-label="Kurangi jumlah"
                            >−</button>

                            <input
                                type="number"
                                id="lk-quantity"
                                name="quantity"
                                min="1"
                                max="{{ $product->stock }}"
                                value="{{ old('quantity', 1) }}"
                                required
                            >

                            <button
                                type="button"
                                class="lk-quantity-btn"
                                onclick="changeQuantity(1)"
                                aria-label="Tambah jumlah"
                            >+</button>
                        </div>

                        <button type="submit" class="lk-add-cart">
                            <span>🛒</span>
                            Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <div class="lk-login-message">
                        Silakan login terlebih dahulu untuk membeli
                        produk ini.
                    </div>

                    <a
                        href="{{ route('login') }}"
                        class="lk-add-cart lk-login-button"
                    >
                        🔐 Login untuk Membeli
                    </a>
                @endauth

            @else
                <button type="button" class="lk-add-cart" disabled>
                    Stok Habis
                </button>
            @endif

            <div class="lk-benefits">
                <div>
                    <span>🌱</span>
                    <strong>Produk Lokal</strong>
                    <small>Mendukung UMKM</small>
                </div>

                <div>
                    <span>✓</span>
                    <strong>Produk Pilihan</strong>
                    <small>Dari penjual lokal</small>
                </div>

                <div>
                    <span>📦</span>
                    <strong>Stok Jelas</strong>
                    <small>Informasi tersedia</small>
                </div>
            </div>

        </div>
    </div>

    {{-- TAB INFORMASI PRODUK --}}
    <section class="lk-detail-section">

        <div class="lk-tab-buttons">
            <button
                type="button"
                class="lk-tab-btn active"
                onclick="showProductTab('description', this)"
            >
                Deskripsi Produk
            </button>

            <button
                type="button"
                class="lk-tab-btn"
                onclick="showProductTab('seller', this)"
            >
                Informasi Penjual
            </button>
        </div>

        <div id="description" class="lk-tab-content active">
            <h2>Tentang Produk</h2>

            <p>
                {{ $product->description ?: 'Produk UMKM lokal pilihan yang dibuat untuk memenuhi kebutuhan sehari-hari.' }}
            </p>

            <div class="lk-description-details">
                <div>
                    <span>Nama produk</span>
                    <strong>{{ $product->name }}</strong>
                </div>

                <div>
                    <span>Kategori</span>
                    <strong>
                        {{ $product->category->name ?? 'Produk Lokal' }}
                    </strong>
                </div>

                <div>
                    <span>Ketersediaan</span>
                    <strong>
                        {{ $product->stock > 0 ? 'Tersedia' : 'Stok habis' }}
                    </strong>
                </div>
            </div>
        </div>

        <div id="seller" class="lk-tab-content">
            <h2>Informasi Penjual</h2>

            <div class="lk-seller-card">
                <div class="lk-seller-avatar">🏪</div>

                <div>
                    <span>Nama UMKM / Penjual</span>
                    <h3>{{ $product->seller_name ?: 'UMKM Lokal' }}</h3>
                    <p>Penjual produk lokal LOKALKITA</p>
                </div>
            </div>

            <p class="lk-seller-note">
                Informasi kontak dan alamat penjual dapat ditambahkan
                jika datanya sudah tersedia di aplikasi.
            </p>
        </div>

    </section>

    <div class="lk-bottom-action">
        <a href="{{ route('products.index') }}">
            ← Jelajahi Produk Lainnya
        </a>

        @auth
            <a href="{{ route('cart.index') }}">
                Lihat Keranjang 🛒
            </a>
        @endauth
    </div>

</div>

{{-- JAVASCRIPT --}}
<script>
function changeQuantity(amount) {
    const input = document.getElementById('lk-quantity');

    if (!input) return;

    const min = Number(input.min) || 1;
    const max = Number(input.max) || 1;
    const current = Number(input.value) || min;

    input.value = Math.min(max, Math.max(min, current + amount));
}

function showProductTab(tabId, button) {
    document.querySelectorAll('.lk-tab-content').forEach(function (tab) {
        tab.classList.remove('active');
    });

    document.querySelectorAll('.lk-tab-btn').forEach(function (tabButton) {
        tabButton.classList.remove('active');
    });

    document.getElementById(tabId).classList.add('active');
    button.classList.add('active');
}
</script>
@endsection