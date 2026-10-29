
@extends('layouts.app')

@section('title', 'Keranjang Belanja - LOKALKITA')

@section('content')
<div class="cart-page">
    <div class="cart-container">

        <div class="cart-heading">
            <div>
                <h1>Keranjang Belanja</h1>
                <p>Periksa produk pilihanmu sebelum melanjutkan belanja.</p>
            </div>

            {{-- TOMBOL PESANAN SAYA --}}
            <a href="{{ route('orders.index') }}"
               class="cart-btn cart-btn-orders">
                📦 Pesanan Saya
            </a>
        </div>

        @if (session('success'))
            <div class="cart-alert success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="cart-alert error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="cart-alert error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (isset($cart) && $cart && $cart->items->count() > 0)

            <div class="cart-layout">

                <section class="cart-card">
                    <div class="cart-card-heading">
                        <h2>Produk Pilihanmu</h2>
                        <span class="cart-count">
                            {{ $cart->items->sum('quantity') }} barang
                        </span>
                    </div>

                    @foreach ($cart->items as $item)
                        @if ($item->product)
                            <div class="cart-item">

                                @php
                                    $productImage = $item->product->image_url;

                                    if (!$productImage) {
                                        $productImage = asset(
                                            'images/products/default.svg'
                                        );
                                    } elseif (
                                        !\Illuminate\Support\Str::startsWith(
                                            $productImage,
                                            ['http://', 'https://']
                                        )
                                    ) {
                                        $productImage = asset(
                                            ltrim($productImage, '/')
                                        );
                                    }
                                @endphp

                                <img
                                    class="cart-item-image"
                                    src="{{ $productImage }}"
                                    alt="{{ $item->product->name }}"
                                    onerror="this.onerror=null;this.src='https://placehold.co/300x300/e8f2ed/0b4f3c?text=Produk';"
                                >

                                <div class="cart-item-content">
                                    <div class="cart-item-top">
                                        <div>
                                            <a
                                                href="{{ route('products.show', $item->product->id) }}"
                                                class="cart-item-name"
                                            >
                                                {{ $item->product->name }}
                                            </a>

                                            <div class="cart-item-meta">
                                                {{ $item->product->category->name ?? 'Produk Lokal' }}

                                                @if ($item->product->seller_name)
                                                    · {{ $item->product->seller_name }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cart-item-price">
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </div>

                                    <div class="cart-item-actions">

                                        <form
                                            action="{{ route('cart.update', $item->id) }}"
                                            method="POST"
                                            class="cart-quantity-form"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <label for="quantity-{{ $item->id }}">
                                                Jumlah
                                            </label>

                                            <input
                                                id="quantity-{{ $item->id }}"
                                                class="cart-quantity-input"
                                                type="number"
                                                name="quantity"
                                                value="{{ $item->quantity }}"
                                                min="1"
                                                max="{{ $item->product->stock }}"
                                                required
                                            >

                                            <button
                                                type="submit"
                                                class="cart-btn cart-btn-light"
                                            >
                                                Perbarui
                                            </button>
                                        </form>

                                        <form
                                            action="{{ route('cart.remove', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="cart-btn cart-btn-danger"
                                            >
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <div class="cart-clear-form">
                        <form
                            action="{{ route('cart.clear') }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin mengosongkan seluruh keranjang?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="cart-btn cart-btn-danger"
                            >
                                Kosongkan Keranjang
                            </button>
                        </form>
                    </div>

                </section>

                <aside class="cart-summary">
                    <h2>Ringkasan Belanja</h2>

                    <div class="cart-summary-row">
                        <span>Total jenis produk</span>
                        <strong>{{ $cart->items->count() }} produk</strong>
                    </div>

                    <div class="cart-summary-row">
                        <span>Total barang</span>
                        <strong>{{ $cart->items->sum('quantity') }} barang</strong>
                    </div>

                    <div class="cart-summary-row cart-summary-total">
                        <span>Total harga</span>
                        <strong>
                            Rp{{ number_format(
                                $total ?? $cart->items->sum(
                                    fn ($item) => $item->price * $item->quantity
                                ),
                                0,
                                ',',
                                '.'
                            ) }}
                        </strong>
                    </div>

                    <div class="cart-checkout-note">
                        🌿 Terima kasih telah mendukung UMKM lokal.
                        Pastikan jumlah dan produk yang dipilih sudah benar.
                    </div>

                    <form
                        action="{{ route('cart.checkout') }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin melanjutkan checkout?')"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="cart-btn cart-btn-primary cart-checkout-btn"
                        >
                            Checkout Sekarang
                        </button>
                    </form>

                    <a
                        href="{{ route('products.index') }}"
                        class="cart-continue"
                    >
                        ← Lanjut Belanja
                    </a>

                    {{-- LINK PESANAN SAYA DI RINGKASAN --}}
                    <a
                        href="{{ route('orders.index') }}"
                        class="cart-continue cart-orders-link"
                    >
                        📦 Lihat Pesanan Saya →
                    </a>
                </aside>

            </div>

        @else

            <div class="cart-empty">
                <div class="cart-empty-icon">🛒</div>

                <h2>Keranjangmu Masih Kosong</h2>

                <p>
                    Yuk, temukan produk lokal favoritmu dan dukung UMKM
                    di sekitarmu.
                </p>

                <a
                    href="{{ route('products.index') }}"
                    class="cart-btn cart-btn-primary"
                >
                    Jelajahi Produk
                </a>

                {{-- TETAP BISA MELIHAT RIWAYAT PESANAN --}}
                <a
                    href="{{ route('orders.index') }}"
                    class="cart-btn cart-btn-orders"
                >
                    📦 Lihat Pesanan Saya
                </a>
            </div>

        @endif

    </div>
</div>
@endsection
