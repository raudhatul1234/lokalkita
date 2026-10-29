<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Produk - LOKALKITA</title>

    <link rel="stylesheet" href="{{ asset('css/lokalkita.css') }}">

    <style>
        .product-form {
            max-width: 750px;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .06);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .form-control {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font: inherit;
        }

        .form-row {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .form-row .form-group {
            flex: 1;
            min-width: 200px;
        }

        .current-image,
        .image-preview {
            width: 200px;
            height: 200px;
            margin-top: 12px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ddd;
            background: #f3f4f6;
        }

        .current-image {
            display: block;
        }

        .image-preview {
            display: none;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .form-help {
            display: block;
            margin-top: 7px;
            color: #666;
            font-size: 13px;
        }

        .field-error {
            color: #b42318;
        }

        .no-image {
            width: 200px;
            height: 200px;
            margin-top: 12px;
            border-radius: 10px;
            background: #f3f4f6;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        .no-image span {
            font-size: 45px;
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
                <h1>Edit Produk</h1>
                <p>Perbarui informasi dan gambar produk UMKM kamu.</p>
            </div>
        </header>

        <section class="admin-products">

            {{-- NOTIFIKASI BERHASIL --}}
            @if (session('success'))
                <div class="alert alert-success" role="status">
                    {{ session('success') }}
                </div>
            @endif

            {{-- NOTIFIKASI ERROR --}}
            @if (session('error'))
                <div class="alert alert-error" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- VALIDASI --}}
            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <strong>Periksa kembali data berikut:</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM EDIT PRODUK --}}
            <form
                action="{{ route('admin.products.update', $product->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="product-form"
            >

                @csrf
                @method('PUT')

                {{-- NAMA PRODUK --}}
                <div class="form-group">

                    <label for="name">Nama Produk *</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $product->name) }}"
                        maxlength="255"
                        required
                    >

                    @error('name')
                        <small class="form-help field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                {{-- DESKRIPSI --}}
                <div class="form-group">

                    <label for="description">Deskripsi Produk</label>

                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="4"
                    >{{ old('description', $product->description) }}</textarea>

                    @error('description')
                        <small class="form-help field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                {{-- HARGA DAN STOK --}}
                <div class="form-row">

                    <div class="form-group">

                        <label for="price">Harga (Rp) *</label>

                        <input
                            type="number"
                            id="price"
                            name="price"
                            class="form-control"
                            value="{{ old('price', $product->price) }}"
                            min="0"
                            step="0.01"
                            required
                        >

                        @error('price')
                            <small class="form-help field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    <div class="form-group">

                        <label for="stock">Stok *</label>

                        <input
                            type="number"
                            id="stock"
                            name="stock"
                            class="form-control"
                            value="{{ old('stock', $product->stock) }}"
                            min="0"
                            step="1"
                            required
                        >

                        @error('stock')
                            <small class="form-help field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

                {{-- KATEGORI --}}
                <div class="form-group">

                    <label for="category_id">Kategori *</label>

                    <select
                        id="category_id"
                        name="category_id"
                        class="form-control"
                        required
                    >

                        <option value="">-- Pilih Kategori --</option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    (string) old('category_id', $product->category_id)
                                    === (string) $category->id
                                )
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('category_id')
                        <small class="form-help field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                {{-- NAMA PENJUAL --}}
                <div class="form-group">

                    <label for="seller_name">Nama Penjual</label>

                    <input
                        type="text"
                        id="seller_name"
                        name="seller_name"
                        class="form-control"
                        value="{{ old('seller_name', $product->seller_name ?: auth()->user()->name) }}"
                        maxlength="255"
                    >

                    @error('seller_name')
                        <small class="form-help field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                {{-- GAMBAR LAMA --}}
                <div class="form-group">

                    <label>Gambar Produk Saat Ini</label>

                    @php
                        $currentImageName = $product->image
                            ? basename(str_replace('\\', '/', $product->image))
                            : null;

                        $currentImagePath = $currentImageName
                            ? public_path('images/products/' . $currentImageName)
                            : null;

                        $currentImageUrl = $currentImageName
                            ? asset('images/products/' . rawurlencode($currentImageName))
                            : null;
                    @endphp

                    @if ($currentImagePath && file_exists($currentImagePath))

                        <img
                            id="current-image"
                            class="current-image"
                            src="{{ $currentImageUrl }}"
                            alt="{{ $product->name }}"
                        >

                    @else

                        <div class="no-image" id="no-current-image">
                            <span>📦</span>
                            <p>Belum ada gambar</p>
                        </div>

                    @endif

                </div>

                {{-- UPLOAD GAMBAR BARU --}}
                <div class="form-group">

                    <label for="image">Pilih Gambar Produk Baru</label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        aria-describedby="image-help"
                    >

                    <small id="image-help" class="form-help">
                        Kosongkan jika tidak ingin mengganti gambar.
                        Format JPG, JPEG, PNG, atau WEBP.
                        Ukuran maksimal 10 MB.
                    </small>

                    @error('image')
                        <small class="form-help field-error">
                            {{ $message }}
                        </small>
                    @enderror

                    {{-- PRATINJAU GAMBAR BARU --}}
                    <img
                        id="image-preview"
                        class="image-preview"
                        alt="Pratinjau gambar baru"
                    >

                </div>

                {{-- TOMBOL --}}
                <div class="form-actions">

                    <button type="submit" class="admin-add-button">
                        Simpan Perubahan
                    </button>

                    <a
                        href="{{ route('admin.products') }}"
                        class="admin-add-button"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </section>

    </main>

    {{-- JAVASCRIPT PRATINJAU GAMBAR --}}
    <script>
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');

        let previewUrl = null;

        imageInput.addEventListener('change', function () {
            const file = this.files[0];

            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
                previewUrl = null;
            }

            imagePreview.removeAttribute('src');
            imagePreview.style.display = 'none';

            if (!file) {
                return;
            }

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!allowedTypes.includes(file.type)) {
                alert('Pilih gambar JPG, JPEG, PNG, atau WEBP.');
                this.value = '';
                return;
            }

            const maxSize = 10 * 1024 * 1024;

            if (file.size > maxSize) {
                alert('Ukuran gambar maksimal 10 MB.');
                this.value = '';
                return;
            }

            previewUrl = URL.createObjectURL(file);

            imagePreview.src = previewUrl;
            imagePreview.style.display = 'block';
        });

        window.addEventListener('beforeunload', function () {
            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
            }
        });
    </script>

</body>
</html>
