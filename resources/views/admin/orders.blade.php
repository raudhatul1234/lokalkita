<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pesanan - LOKALKITA</title>

    <link rel="stylesheet" href="{{ asset('css/lokalkita.css') }}">

    <style>
        /* =====================================================
           PESANAN - MENYESUAIKAN DENGAN DASHBOARD
        ===================================================== */

        .admin-main {
            min-width: 0;
        }

        /* ===============================
           STATUS PESANAN
        =============================== */

        .order-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-pending {
            color: #995c00;
            background: #fff0d6;
        }

        .status-completed {
            color: #087443;
            background: #dff5e8;
        }

        .status-cancelled {
            color: #991b1b;
            background: #fee2e2;
        }

        .status-other {
            color: #475569;
            background: #e9eef5;
        }

        /* ===============================
           ALERT
        =============================== */

        .order-alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
        }

        .order-alert.success {
            background: #dff5e8;
            color: #087443;
        }

        .order-alert.error {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ===============================
           PRODUK DALAM PESANAN
        =============================== */

        .order-products {
            min-width: 180px;
            line-height: 1.7;
            font-size: 13px;
        }

        .order-products small {
            font-size: 12px;
            color: #718096;
        }

        .order-number {
            font-weight: 600;
            color: #075b49;
            font-size: 13px;
        }

        .order-total {
            font-weight: 700;
            white-space: nowrap;
            font-size: 13px;
        }

        .order-date {
            white-space: nowrap;
            font-size: 13px;
            color: #475569;
        }

        /* ===============================
           AKSI
        =============================== */

        .order-actions {
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 90px;
        }

        .order-action-button {
            border: none;
            border-radius: 6px;
            padding: 7px 10px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            font-family: inherit;
            width: 100%;
        }

        .cancel-order-button {
            background: #fff0d6;
            color: #995c00;
        }

        .delete-order-button {
            background: #fee2e2;
            color: #991b1b;
        }

        .order-action-button:hover {
            opacity: .8;
        }

        .order-action-button:focus-visible {
            outline: 2px solid #075b49;
            outline-offset: 2px;
        }

        /* ===============================
           TABEL
        =============================== */

        .order-table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

        .order-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
            font-size: 13px;
        }

        .order-table th {
            background: #f4f7f6;
            color: #475569;
            font-size: 12px;
            font-weight: 600;
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .order-table td {
            padding: 18px 12px;
            color: #475569;
            border-bottom: 1px solid #edf0ef;
            vertical-align: middle;
        }

        .order-table tbody tr:hover {
            background: #fafcfb;
        }

        /* ===============================
           PESANAN KOSONG
        =============================== */

        .empty-orders {
            padding: 45px 20px;
            text-align: center;
            color: #718096;
        }

        .empty-orders-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .empty-orders strong {
            display: block;
            font-size: 16px;
            color: #263238;
            margin-bottom: 8px;
        }

        .empty-orders p {
            margin: 5px 0;
            font-size: 13px;
        }

        .back-home {
            display: inline-block;
            margin-top: 14px;
            color: #087443;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }

        .back-home:hover {
            text-decoration: underline;
        }

        /* ===============================
           PAGINATION
        =============================== */

        .order-pagination {
            margin-top: 20px;
            font-size: 13px;
        }

        /* ===============================
           FOOTER
        =============================== */

        .admin-footer {
            margin-top: 25px;
            padding: 20px 0;
            font-size: 13px;
            color: #718096;
        }

        .admin-footer p {
            margin-top: 8px;
        }

        /* ===============================
           RESPONSIVE
        =============================== */

        @media (max-width: 900px) {
            .order-table-container {
                overflow-x: auto;
            }

            .admin-stats {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .order-table {
                min-width: 850px;
            }

            .admin-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .admin-user {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body class="admin-page">

    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    <aside class="admin-sidebar">

        <a
            href="{{ route('home') }}"
            class="admin-logo"
            style="text-decoration: none;"
        >
            🌿 LOKALKITA
        </a>

        <nav class="admin-nav">

            <a href="{{ route('home') }}">
                🏠 Beranda LOKALKITA
            </a>

            <a href="{{ route('admin.dashboard') }}">
                ▦ Dashboard
            </a>

            <a href="{{ route('admin.products') }}">
                ▣ Produk Saya
            </a>

            <a
                href="{{ route('admin.orders') }}"
                class="active"
            >
                ▤ Pesanan
            </a>

            <a href="{{ route('admin.profile') }}">
                ♙ Profil UMKM
            </a>

            <a href="{{ route('admin.settings') }}">
                ⚙ Pengaturan
            </a>

            <form
                action="{{ route('logout') }}"
                method="POST"
            >
                @csrf

                <button
                    type="submit"
                    class="admin-logout"
                >
                    ↪ Logout
                </button>
            </form>

        </nav>

    </aside>


    {{-- =====================================================
         KONTEN UTAMA
    ====================================================== --}}

    <main class="admin-main">

        {{-- HEADER --}}

        <header class="admin-header">

            <div>
                <h1>Pesanan</h1>

                <p>
                    Kelola pesanan pelanggan LOKALKITA.
                </p>
            </div>

            <div class="admin-user">

                <span>
                    {{ auth()->user()->name ?? 'Pengguna' }}
                </span>

                <a
                    href="{{ route('admin.profile') }}"
                    class="admin-profile"
                    title="Buka Profil UMKM"
                >
                    <span>
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </span>
                </a>

            </div>

        </header>


        {{-- =================================================
             NOTIFIKASI
        ================================================== --}}

        @if (session('success'))

            <div class="order-alert success">
                {{ session('success') }}
            </div>

        @endif


        @if (session('error'))

            <div class="order-alert error">
                {{ session('error') }}
            </div>

        @endif


        @if ($errors->has('cart'))

            <div class="order-alert error">
                {{ $errors->first('cart') }}
            </div>

        @endif


        {{-- =================================================
             STATISTIK
        ================================================== --}}

        <section class="admin-stats">

            {{-- TOTAL PESANAN --}}

            <article class="admin-stat-card">

                <div class="stat-icon green">
                    ▤
                </div>

                <div>

                    <p>
                        Total Pesanan
                    </p>

                    <h2>
                        {{ $totalPesanan }}
                    </h2>

                    <small>
                        Pesanan dari database
                    </small>

                </div>

            </article>


            {{-- MENUNGGU --}}

            <article class="admin-stat-card">

                <div class="stat-icon orange">
                    ◷
                </div>

                <div>

                    <p>
                        Menunggu
                    </p>

                    <h2>
                        {{ $menunggu }}
                    </h2>

                    <small>
                        Menunggu diproses
                    </small>

                </div>

            </article>


            {{-- SELESAI --}}

            <article class="admin-stat-card">

                <div class="stat-icon mint">
                    ✓
                </div>

                <div>

                    <p>
                        Selesai
                    </p>

                    <h2>
                        {{ $selesai }}
                    </h2>

                    <small>
                        Pesanan selesai
                    </small>

                </div>

            </article>

        </section>


        {{-- =================================================
             DAFTAR PESANAN
        ================================================== --}}

        <section class="admin-products">

            <div class="admin-section-header">

                <div>

                    <h2>
                        Daftar Pesanan
                    </h2>

                    <p>
                        Pesanan yang tercatat melalui proses checkout.
                    </p>

                </div>

            </div>


            {{-- =================================================
                 TABEL PESANAN
            ================================================== --}}

            <div class="order-table-container">

                <table class="order-table">

                    <thead>

                        <tr>

                            <th>
                                No. Pesanan
                            </th>

                            <th>
                                Pelanggan
                            </th>

                            <th>
                                Produk
                            </th>

                            <th>
                                Jumlah
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($orders as $order)

                            @php

                                $status = strtolower(
                                    str_replace(
                                        ' ',
                                        '_',
                                        trim(
                                            $order->status ?? 'pending'
                                        )
                                    )
                                );

                                if ($status === 'pending') {

                                    $statusLabel = 'Menunggu';
                                    $statusClass = 'status-pending';

                                } elseif (
                                    in_array(
                                        $status,
                                        [
                                            'completed',
                                            'complete',
                                            'selesai'
                                        ]
                                    )
                                ) {

                                    $statusLabel = 'Selesai';
                                    $statusClass = 'status-completed';

                                } elseif (
                                    in_array(
                                        $status,
                                        [
                                            'cancelled',
                                            'canceled',
                                            'dibatalkan'
                                        ]
                                    )
                                ) {

                                    $statusLabel = 'Dibatalkan';
                                    $statusClass = 'status-cancelled';

                                } else {

                                    $statusLabel = ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $status
                                        )
                                    );

                                    $statusClass = 'status-other';
                                }

                                $jumlahProduk =
                                    $order->items->sum('quantity');

                            @endphp


                            <tr>

                                {{-- NOMOR PESANAN --}}

                                <td>

                                    <span class="order-number">
                                        {{ $order->order_number ?? 'ORD-' . $order->id }}
                                    </span>

                                </td>


                                {{-- PELANGGAN --}}

                                <td>

                                    {{ $order->user->name ?? 'Pengguna tidak ditemukan' }}

                                </td>


                                {{-- PRODUK --}}

                                <td>

                                    <div class="order-products">

                                        @forelse ($order->items as $item)

                                            <div>

                                                {{ $item->product_name ?? ($item->product->name ?? 'Produk') }}

                                                <small>
                                                    ({{ $item->quantity }} ×
                                                    Rp {{ number_format((float) $item->price, 0, ',', '.') }})
                                                </small>

                                            </div>

                                        @empty

                                            <span>
                                                Detail produk tidak tersedia.
                                            </span>

                                        @endforelse

                                    </div>

                                </td>


                                {{-- JUMLAH --}}

                                <td>

                                    {{ $jumlahProduk }}

                                </td>


                                {{-- TOTAL --}}

                                <td>

                                    <span class="order-total">

                                        Rp
                                        {{ number_format((float) $order->total, 0, ',', '.') }}

                                    </span>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    <span
                                        class="order-status {{ $statusClass }}"
                                    >
                                        {{ $statusLabel }}
                                    </span>

                                </td>


                                {{-- TANGGAL --}}

                                <td>

                                    <span class="order-date">

                                        {{ $order->created_at
                                            ? $order->created_at->format('d/m/Y H:i')
                                            : '-' }}

                                    </span>

                                </td>


                                {{-- AKSI --}}

                                <td>

                                    <div class="order-actions">

                                        @if ($status === 'pending')

                                            <form
                                                action="{{ route('admin.orders.cancel', $order->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="order-action-button cancel-order-button"
                                                >
                                                    Batalkan
                                                </button>

                                            </form>

                                        @endif


                                        <form
                                            action="{{ route('admin.orders.delete', $order->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pesanan ini secara permanen?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="order-action-button delete-order-button"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8">

                                    <div class="empty-orders">

                                        <div class="empty-orders-icon">
                                            🛍️
                                        </div>

                                        <strong>
                                            Belum ada pesanan
                                        </strong>

                                        <p>
                                            Pesanan yang berhasil dibuat
                                            melalui checkout akan muncul
                                            di halaman ini.
                                        </p>

                                        <a
                                            href="{{ route('home') }}"
                                            class="back-home"
                                        >
                                            ← Kembali ke Beranda LOKALKITA
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                 PAGINATION
            ================================================== --}}

            @if (method_exists($orders, 'links'))

                <div class="order-pagination">

                    {{ $orders->links() }}

                </div>

            @endif

        </section>


        {{-- =================================================
             FOOTER
        ================================================== --}}

        <footer class="admin-footer">

            <a
                href="{{ route('admin.dashboard') }}"
                style="text-decoration:none; color:inherit;"
            >
                ← Kembali ke Dashboard
            </a>

            <p>
                © {{ date('Y') }}
                LOKALKITA — Bersama UMKM, Maju Bersama
            </p>

        </footer>

    </main>

</body>
</html>