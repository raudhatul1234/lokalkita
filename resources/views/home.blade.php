@extends('layouts.app')

@section('title', 'Beranda - LOKALKITA')

@section('content')

{{-- =========================
     HERO
========================= --}}

<section class="hero">

    <div class="hero-art">
        <img
            src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=1200&q=85"
            alt="Produk lokal Indonesia"
        >
    </div>

    <div class="hero-copy">

        <span class="hero-label">
            🌿 BANGGA PRODUK INDONESIA
        </span>

        <h1>
            Dukung UMKM Lokal
            Bersama LOKALKITA
        </h1>

        <p>
            Temukan berbagai produk lokal berkualitas
            dari UMKM Indonesia. Belanja produk lokal,
            dukung ekonomi masyarakat.
        </p>

        <a href="#produk" class="button">
            Belanja Sekarang →
        </a>

    </div>

</section>


{{-- =========================
     KATEGORI
========================= --}}

<section class="section" id="kategori">

    <div class="section-heading">

        <div>
            <h2>Kategori Produk</h2>

            <p class="seller">
                Temukan produk sesuai kebutuhanmu
            </p>
        </div>

    </div>


    <div class="category-grid">

        {{-- SEMUA PRODUK --}}

        <a
            href="{{ route('home') }}"
            class="category-item {{ !request('category') ? 'active-category' : '' }}"
        >

            <div class="category-icon">
                ✨
            </div>

            <strong>
                Semua Produk
            </strong>

            <p class="seller">
                Semua kategori
            </p>

        </a>


        {{-- KATEGORI DARI DATABASE --}}

        @foreach ($categories as $category)

            <a
                href="{{ route('home', ['category' => $category->slug]) }}"
                class="category-item
                {{ request('category') === $category->slug ? 'active-category' : '' }}"
            >

                <div class="category-icon">
                    {{ $category->icon ?: '🌿' }}
                </div>

                <strong>
                    {{ $category->name }}
                </strong>

                <p class="seller">
                    {{ $category->products_count }} produk
                </p>

            </a>

        @endforeach

    </div>

</section>


{{-- =========================
     PRODUK
========================= --}}

<section class="section" id="produk">

    <div class="section-heading">

        <div>

            @if(request('category'))

                <h2>
                    {{ $categories->firstWhere('slug', request('category'))->name ?? 'Produk' }}
                </h2>

                <p class="seller">
                    Produk berdasarkan kategori yang kamu pilih
                </p>

            @elseif(request('search'))

                <h2>
                    Hasil Pencarian
                </h2>

                <p class="seller">
                    Menampilkan hasil untuk "{{ request('search') }}"
                </p>

            @else

                <h2>
                    Produk Unggulan
                </h2>

                <p class="seller">
                    Produk pilihan dari UMKM lokal
                </p>

            @endif

        </div>


        @if(request('category') || request('search'))

            <a href="{{ route('home') }}">
                Reset Filter ×
            </a>

        @endif

    </div>


    {{-- INFO FILTER --}}

    @if(request('category') || request('search'))

        <div class="active-filter">

            <div>

                @if(request('category'))

                    <span>
                        📂 Kategori:
                        <strong>
                            {{ $categories->firstWhere('slug', request('category'))->name ?? request('category') }}
                        </strong>
                    </span>

                @endif


                @if(request('search'))

                    <span>
                        🔍 Pencarian:
                        <strong>
                            {{ request('search') }}
                        </strong>
                    </span>

                @endif

            </div>


            <a href="{{ route('home') }}">
                Hapus Filter
            </a>

        </div>

    @endif


    {{-- PRODUK --}}

    <div class="product-grid">

        @forelse ($products as $product)

            <article class="product-card">

                <div class="product-image">

                    @if($product->image_url)

                        <img
                            src="{{ $product->image_url }}"
                            alt="{{ $product->name }}"
                            loading="lazy"
                        >

                    @else

                        <div class="product-placeholder">
                            🌿
                        </div>

                    @endif

                </div>


                <div class="product-info">

                    <small>
                        {{ $product->category->name ?? 'Produk Lokal' }}
                    </small>


                    <h3>
                        {{ $product->name }}
                    </h3>


                    <strong class="price">
                        Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                    </strong>


                    <p class="seller">
                        {{ $product->seller_name }}
                    </p>


                    <p class="seller">
                        Stok: {{ $product->stock }}
                    </p>


                    <a
                        href="#"
                        class="button button-small"
                    >
                        Lihat Detail →
                    </a>

                </div>

            </article>

        @empty

            <div class="empty-products">

                <div>
                    😢
                </div>

                <h3>
                    Produk tidak ditemukan
                </h3>

                <p>
                    Coba pilih kategori lain atau hapus filter.
                </p>

                <a
                    href="{{ route('home') }}"
                    class="button"
                >
                    Lihat Semua Produk
                </a>

            </div>

        @endforelse

    </div>

</section>


{{-- =========================
     SUPPORT UMKM
========================= --}}

<section class="section">

    <div class="support-banner">

        <div>

            <h2>
                Belanja Lokal, Bantu UMKM Indonesia
            </h2>

            <p>
                Setiap pembelianmu ikut membantu usaha lokal
                berkembang dan menciptakan ekonomi yang lebih kuat.
            </p>

        </div>

        <a
            href="#produk"
            class="button"
        >
            Jelajahi Produk →
        </a>

    </div>

</section>

@endsection