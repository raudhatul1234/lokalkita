<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Produk - LOKALKITA</title>

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

        .image-preview {
            display: none;
            width: 180px;
            height: 180px;
            margin-top: 12px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ddd;
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
                <h1>Tambah Produk</h1>
                <p>Tambahkan produk UMKM kamu ke LOKALKITA.</p>
            </div>
        </header>

        <section class="admin-products">

            {{-- NOTIFIKASI VALIDASI --}}
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

            {{-- FORM TAMBAH PRODUK --}}
            <form
                action="{{ route('admin.products.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="product-form"
            >

                @csrf

                {{-- NAMA PRODUK --}}
                <div class="form-group">

                    <label for="name">Nama Produk *</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
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
                    >{{ old('description') }}</textarea>

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
                            value="{{ old('price') }}"
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
                            value="{{ old('stock', 0) }}"
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
                                @selected((string) old('category_id') === (string) $category->id)
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
                        value="{{ old('seller_name', auth()->user()->name) }}"
                        maxlength="255"
                    >

                    @error('seller_name')
                        <small class="form-help field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                {{-- UPLOAD GAMBAR --}}
                <div class="form-group">

                    <label for="image">Gambar Produk</label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        aria-describedby="image-help"
                    >

                    <small id="image-help" class="form-help">
                        Format JPG, JPEG, PNG, atau WEBP.
                        Ukuran maksimal 10 MB.
                    </small>

                    @error('image')
                        <small class="form-help field-error">
                            {{ $message }}
                        </small>
                    @enderror

                    {{-- PRATINJAU GAMBAR --}}
                    <img
                        id="image-preview"
                        class="image-preview"
                        alt="Pratinjau gambar produk"
                    >

                </div>

                {{-- TOMBOL --}}
                <div class="form-actions">

                    <button type="submit" class="admin-add-button">
                        Simpan Produk
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
