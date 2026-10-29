@extends('layouts.app')

@section('content')
<div class="lokal-marketplace">

    {{-- SIDEBAR KATEGORI --}}
    <aside class="lokal-sidebar">
        <h2>Kategori</h2>

        <a href="{{ route('products.index') }}"
           class="lokal-category {{ !request('category') ? 'active' : '' }}">
            <span>▦</span>
            <span>Semua Produk</span>
            <span class="lokal-category-count">
                ({{ $categories->sum('products_count') }})
            </span>
        </a>

        @isset($categories)
            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->id]) }}"
                   class="lokal-category {{ (string) request('category') === (string) $category->id ? 'active' : '' }}">
                    <span>◇</span>
                    <span>{{ $category->name }}</span>
                    <span class="lokal-category-count">
                        ({{ $category->products_count }})
                    </span>
                </a>
            @endforeach
        @endisset

        <div class="lokal-promo">
            <div class="promo-leaf">🌿</div>
            <h3>Dukung UMKM Lokal</h3>
            <p>Belanja produk lokal, bantu usaha Indonesia terus berkembang.</p>
        </div>
    </aside>

    {{-- DAFTAR PRODUK --}}
    <main class="lokal-products">
        <div class="lokal-products-heading">
            <div>
                <h1>
                    @if(request('category') && isset($categories))
                        {{ optional($categories->firstWhere('id', request('category')))->name ?? 'Produk Pilihan' }}
                    @else
                        Semua Produk
                    @endif
                </h1>

                <p>Temukan produk UMKM pilihan dari sekitar kita.</p>
            </div>

            <form action="{{ route('products.index') }}"
                  method="GET"
                  class="lokal-search">

                @if(request('category'))
                    <input type="hidden"
                           name="category"
                           value="{{ request('category') }}">
                @endif

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    aria-label="Cari produk"
                >

                <button type="submit">Cari</button>
            </form>
        </div>

        @if(isset($products) && $products->count())
            <div class="lokal-product-grid">
                @foreach($products as $product)
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

                    <article class="lokal-product-card">
                        <div class="lokal-product-photo">
                            <img
                                src="{{ $image }}"
                                alt="{{ $product->name }}"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='https://placehold.co/500x400/e8f2ed/0b4f3c?text=Foto+Produk';"
                            >
                        </div>

                        <div class="lokal-product-info">
                            <h3>{{ $product->name }}</h3>

                            <p class="lokal-price">
                                Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                            </p>

                            @if($product->category)
                                <p class="lokal-product-category">
                                    {{ $product->category->name }}
                                </p>
                            @endif

                            <a href="{{ route('products.show', $product->id) }}"
                               class="lokal-detail-button">
                                Lihat Detail →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            @if(method_exists($products, 'links'))
                <div class="lokal-pagination">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="lokal-empty">
                <h2>Produk belum ditemukan</h2>
                <p>Coba kata kunci atau kategori lainnya.</p>
            </div>
        @endif
    </main>
</div>
@endsection