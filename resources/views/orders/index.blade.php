@extends('layouts.app')

@section('content')

<style>
    /* =====================================================
       LOKALKITA - HALAMAN PESANAN SAYA
       ===================================================== */

    :root {
        --green: #28733a;
        --green-dark: #205d2e;
        --green-light: #e8f5e9;
        --text: #1f2937;
        --muted: #6b7280;
        --border: #e5e7eb;
        --bg: #f6faf7;
        --danger: #b42318;
        --danger-dark: #8f1b13;
        --warning: #a16207;
    }


    /* =====================================================
       HALAMAN
       ===================================================== */

    .orders-page {
        min-height: 100vh;
        padding: 35px 0 60px;

        background:
            linear-gradient(
                180deg,
                #eef8f0 0%,
                #f8faf9 35%,
                #ffffff 100%
            );

        color: var(--text);
    }


    .orders-container {
        width: 92%;
        max-width: 1100px;
        margin: 0 auto;
    }


    /* =====================================================
       HEADER
       ===================================================== */

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 20px;

        margin-bottom: 25px;
        padding: 25px 28px;

        background: #ffffff;

        border: 1px solid var(--border);
        border-radius: 20px;

        box-shadow:
            0 8px 30px rgba(31, 41, 55, .06);
    }


    .orders-title h1 {
        margin: 0 0 7px;

        color: var(--text);

        font-size: 30px;
        font-weight: 800;
    }


    .orders-title p {
        margin: 0;

        color: var(--muted);

        font-size: 14px;
    }


    .shop-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        padding: 12px 20px;

        color: #ffffff;
        background: var(--green);

        border-radius: 11px;

        text-decoration: none;

        font-size: 14px;
        font-weight: 700;

        box-shadow:
            0 5px 15px rgba(40, 115, 58, .20);

        transition: .2s ease;
    }


    .shop-button:hover {
        color: #ffffff;

        background: var(--green-dark);

        transform: translateY(-2px);

        box-shadow:
            0 8px 20px rgba(40, 115, 58, .28);
    }


    /* =====================================================
       ALERT
       ===================================================== */

    .orders-alert {
        margin-bottom: 20px;
        padding: 14px 17px;

        border-radius: 12px;

        font-size: 14px;
        line-height: 1.5;
    }


    .orders-alert-success {
        color: #166534;

        background: #ecfdf3;

        border: 1px solid #bbf7d0;
    }


    .orders-alert-danger {
        color: #991b1b;

        background: #fef2f2;

        border: 1px solid #fecaca;
    }


    .orders-alert ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }


    /* =====================================================
       CARD PESANAN
       ===================================================== */

    .order-card {
        overflow: hidden;

        margin-bottom: 20px;

        background: #ffffff;

        border: 1px solid var(--border);
        border-radius: 18px;

        box-shadow:
            0 6px 22px rgba(31, 41, 55, .06);

        transition:
            transform .2s ease,
            box-shadow .2s ease;
    }


    .order-card:hover {
        transform: translateY(-2px);

        box-shadow:
            0 12px 30px rgba(31, 41, 55, .09);
    }


    /* =====================================================
       HEADER CARD PESANAN
       ===================================================== */

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 15px;

        padding: 19px 22px;

        background:
            linear-gradient(
                135deg,
                #ffffff,
                #f8fcf9
            );

        border-bottom: 1px solid var(--border);
    }


    .order-label {
        display: block;

        margin-bottom: 3px;

        color: var(--muted);

        font-size: 12px;
    }


    .order-number {
        color: var(--text);

        font-size: 17px;
        font-weight: 800;
    }


    /* =====================================================
       STATUS
       ===================================================== */

    .order-status {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        padding: 7px 13px;

        border-radius: 999px;

        font-size: 12px;
        font-weight: 700;
    }


    .order-status::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;

        background: currentColor;
    }


    .status-pending {
        color: #92400e;
        background: #fef3c7;
    }


    .status-processing {
        color: #075985;
        background: #e0f2fe;
    }


    .status-completed {
        color: #166534;
        background: #dcfce7;
    }


    .status-cancelled {
        color: #991b1b;
        background: #fee2e2;
    }


    .status-default {
        color: #4b5563;
        background: #f3f4f6;
    }


    /* =====================================================
       BODY
       ===================================================== */

    .order-card-body {
        padding: 22px;
    }


    /* =====================================================
       ITEM PRODUK
       ===================================================== */

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 20px;

        padding: 16px 0;

        border-bottom: 1px solid #eef0f1;
    }


    .order-item:first-child {
        padding-top: 0;
    }


    .order-item:last-child {
        padding-bottom: 0;

        border-bottom: none;
    }


    .order-item-info {
        min-width: 0;
    }


    .order-product-name {
        margin: 0 0 6px;

        color: var(--text);

        font-size: 15px;
        font-weight: 700;

        overflow-wrap: anywhere;
    }


    .order-product-quantity {
        margin: 0;

        color: var(--muted);

        font-size: 13px;
    }


    .order-product-price {
        flex-shrink: 0;

        color: var(--green);

        font-size: 15px;
        font-weight: 800;
    }


    /* =====================================================
       SUMMARY
       ===================================================== */

    .order-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 20px;

        margin-top: 22px;
        padding-top: 20px;

        border-top: 1px dashed #d9dedb;
    }


    .summary-label {
        display: block;

        margin-bottom: 5px;

        color: var(--muted);

        font-size: 12px;
    }


    .summary-date {
        color: var(--text);

        font-size: 14px;
        font-weight: 600;
    }


    .summary-total {
        color: var(--green);

        font-size: 23px;
        font-weight: 800;

        text-align: right;
    }


    /* =====================================================
       ACTION
       ===================================================== */

    .order-actions {
        display: flex;
        justify-content: flex-end;

        gap: 10px;

        margin-top: 20px;
        padding-top: 18px;

        border-top: 1px solid #eef0f1;
    }


    .order-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 10px 17px;

        border-radius: 10px;

        font-family: inherit;

        font-size: 13px;
        font-weight: 700;

        cursor: pointer;

        transition: .2s ease;
    }


    .cancel-button {
        color: var(--danger);

        background: #ffffff;

        border: 1px solid #fecaca;
    }


    .cancel-button:hover {
        color: #ffffff;

        background: var(--danger);
        border-color: var(--danger);
    }


    .delete-button {
        color: #4b5563;

        background: #ffffff;

        border: 1px solid #d1d5db;
    }


    .delete-button:hover {
        color: #ffffff;

        background: #4b5563;
        border-color: #4b5563;
    }


    /* =====================================================
       PESANAN KOSONG
       ===================================================== */

    .orders-empty {
        padding: 65px 25px;

        text-align: center;

        background: #ffffff;

        border: 1px solid var(--border);
        border-radius: 20px;

        box-shadow:
            0 8px 28px rgba(31, 41, 55, .05);
    }


    .orders-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 85px;
        height: 85px;

        margin: 0 auto 18px;

        background: var(--green-light);

        border-radius: 50%;

        font-size: 40px;
    }


    .orders-empty h3 {
        margin: 0 0 8px;

        color: var(--text);

        font-size: 22px;
        font-weight: 800;
    }


    .orders-empty p {
        margin: 0 0 22px;

        color: var(--muted);

        font-size: 14px;
    }


    /* =====================================================
       PAGINATION
       ===================================================== */

    .orders-pagination {
        display: flex;
        justify-content: center;

        margin-top: 30px;
    }


    .orders-pagination nav {
        display: flex;
    }


    .orders-pagination .pagination {
        display: flex;

        gap: 5px;

        padding: 0;

        margin: 0;

        list-style: none;
    }


    .orders-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;

        min-width: 38px;
        height: 38px;

        color: var(--green);

        background: #ffffff;

        border: 1px solid var(--border);
        border-radius: 9px;

        text-decoration: none;

        font-size: 13px;
        font-weight: 600;
    }


    .orders-pagination .page-link:hover {
        color: #ffffff;

        background: var(--green);

        border-color: var(--green);
    }


    .orders-pagination .active .page-link {
        color: #ffffff;

        background: var(--green);

        border-color: var(--green);
    }


    /* =====================================================
       RESPONSIVE TABLET
       ===================================================== */

    @media (max-width: 768px) {

        .orders-page {
            padding-top: 20px;
        }


        .orders-container {
            width: 94%;
        }


        .orders-header {
            align-items: flex-start;

            flex-direction: column;

            padding: 21px;
        }


        .orders-title h1 {
            font-size: 25px;
        }


        .shop-button {
            width: 100%;
        }


        .order-card-header {
            align-items: flex-start;

            flex-direction: column;
        }


        .order-status {
            align-self: flex-start;
        }


        .order-summary {
            align-items: flex-start;

            flex-direction: column;
        }


        .summary-total {
            text-align: left;
        }


        .order-actions {
            flex-direction: column;
        }


        .order-action {
            width: 100%;
        }
    }


    /* =====================================================
       RESPONSIVE HP
       ===================================================== */

    @media (max-width: 480px) {

        .orders-container {
            width: 94%;
        }


        .orders-header {
            border-radius: 16px;

            padding: 18px;
        }


        .orders-title h1 {
            font-size: 22px;
        }


        .orders-title p {
            font-size: 13px;
            line-height: 1.5;
        }


        .order-card {
            border-radius: 15px;
        }


        .order-card-header {
            padding: 17px;
        }


        .order-card-body {
            padding: 17px;
        }


        .order-item {
            gap: 10px;
        }


        .order-product-name {
            font-size: 14px;
        }


        .order-product-price {
            font-size: 14px;
        }


        .summary-total {
            font-size: 20px;
        }


        .orders-empty {
            padding: 45px 18px;
        }
    }
</style>


<div class="orders-page">

    <div class="orders-container">

        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="orders-header">

            <div class="orders-title">

                <h1>
                    📦 Pesanan Saya
                </h1>

                <p>
                    Lihat dan kelola semua pesanan yang sudah kamu beli.
                </p>

            </div>


            <a
                href="{{ route('products.index') }}"
                class="shop-button"
            >
                🛍️ Belanja Lagi
            </a>

        </div>


        {{-- =================================================
             NOTIFIKASI SUCCESS
        ================================================== --}}

        @if(session('success'))

            <div class="orders-alert orders-alert-success">

                ✅ {{ session('success') }}

            </div>

        @endif


        {{-- =================================================
             NOTIFIKASI ERROR
        ================================================== --}}

        @if(session('error'))

            <div class="orders-alert orders-alert-danger">

                ❌ {{ session('error') }}

            </div>

        @endif


        {{-- =================================================
             VALIDATION ERROR
        ================================================== --}}

        @if($errors->any())

            <div class="orders-alert orders-alert-danger">

                <strong>
                    Terjadi kesalahan:
                </strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =================================================
             DAFTAR PESANAN
        ================================================== --}}

        @forelse($orders as $order)


            @php

                $status = strtolower(
                    trim($order->status ?? 'pending')
                );


                if ($status === 'pending') {

                    $statusText = 'Menunggu';
                    $statusClass = 'status-pending';

                } elseif (
                    $status === 'processing' ||
                    $status === 'process' ||
                    $status === 'diproses'
                ) {

                    $statusText = 'Diproses';
                    $statusClass = 'status-processing';

                } elseif (
                    $status === 'completed' ||
                    $status === 'complete' ||
                    $status === 'selesai'
                ) {

                    $statusText = 'Selesai';
                    $statusClass = 'status-completed';

                } elseif (
                    $status === 'cancelled' ||
                    $status === 'canceled' ||
                    $status === 'dibatalkan'
                ) {

                    $statusText = 'Dibatalkan';
                    $statusClass = 'status-cancelled';

                } else {

                    $statusText = ucfirst($status);
                    $statusClass = 'status-default';

                }

            @endphp


            {{-- =================================================
                 CARD PESANAN
            ================================================== --}}

            <div class="order-card">


                {{-- HEADER PESANAN --}}

                <div class="order-card-header">

                    <div>

                        <span class="order-label">
                            Nomor Pesanan
                        </span>

                        <div class="order-number">
                            #{{ $order->id }}
                        </div>

                    </div>


                    <span
                        class="order-status {{ $statusClass }}"
                    >
                        {{ $statusText }}
                    </span>

                </div>


                {{-- BODY PESANAN --}}

                <div class="order-card-body">


                    {{-- =================================================
                         ITEM PESANAN
                    ================================================== --}}

                    @forelse($order->items as $item)

                        <div class="order-item">


                            <div class="order-item-info">

                                <p class="order-product-name">

                                    @if($item->product)

                                        {{ $item->product->name }}

                                    @else

                                        Produk tidak tersedia

                                    @endif

                                </p>


                                <p class="order-product-quantity">

                                    Jumlah:
                                    <strong>
                                        {{ $item->quantity }}
                                    </strong>

                                </p>

                            </div>


                            <div class="order-product-price">

                                Rp
                                {{ number_format(
                                    $item->price ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </div>


                        </div>

                    @empty

                        <div class="orders-alert orders-alert-danger">

                            Produk dalam pesanan tidak ditemukan.

                        </div>

                    @endforelse


                    {{-- =================================================
                         TOTAL DAN TANGGAL
                    ================================================== --}}

                    <div class="order-summary">


                        <div>

                            <span class="summary-label">
                                Tanggal Pesanan
                            </span>

                            <div class="summary-date">

                                @if($order->created_at)

                                    {{ $order->created_at->format(
                                        'd M Y, H:i'
                                    ) }}

                                @else

                                    -

                                @endif

                            </div>

                        </div>


                        <div>

                            <span class="summary-label">
                                Total Pesanan
                            </span>

                            <div class="summary-total">

                                Rp
                                {{ number_format(
                                    $order->total ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </div>

                        </div>


                    </div>


                    {{-- =================================================
                         TOMBOL PESANAN
                    ================================================== --}}

                    @if($status === 'pending')

                        <div class="order-actions">

                            <form
                                action="{{ route(
                                    'orders.cancel',
                                    $order->id
                                ) }}"
                                method="POST"
                                onsubmit="return confirm(
                                    'Yakin ingin membatalkan pesanan ini?'
                                )"
                            >

                                @csrf

                                @method('PATCH')


                                <button
                                    type="submit"
                                    class="order-action cancel-button"
                                >
                                    ❌ Batalkan Pesanan
                                </button>

                            </form>

                        </div>

                    @endif


                    {{-- =================================================
                         HAPUS PESANAN YANG DIBATALKAN
                    ================================================== --}}

                    @if(
                        $status === 'cancelled' ||
                        $status === 'canceled' ||
                        $status === 'dibatalkan'
                    )

                        <div class="order-actions">

                            <form
                                action="{{ route(
                                    'orders.delete',
                                    $order->id
                                ) }}"
                                method="POST"
                                onsubmit="return confirm(
                                    'Yakin ingin menghapus riwayat pesanan ini?'
                                )"
                            >

                                @csrf

                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="order-action delete-button"
                                >
                                    🗑️ Hapus Riwayat
                                </button>

                            </form>

                        </div>

                    @endif


                </div>

            </div>


        @empty


            {{-- =================================================
                 BELUM ADA PESANAN
            ================================================== --}}

            <div class="orders-empty">

                <div class="orders-empty-icon">
                    🛍️
                </div>


                <h3>
                    Belum Ada Pesanan
                </h3>


                <p>
                    Kamu belum memiliki pesanan.
                    Yuk mulai belanja produk lokal favoritmu!
                </p>


                <a
                    href="{{ route('products.index') }}"
                    class="shop-button"
                >
                    🛒 Mulai Belanja
                </a>

            </div>


        @endforelse


        {{-- =================================================
             PAGINATION
        ================================================== --}}

        @if($orders->hasPages())

            <div class="orders-pagination">

                {{ $orders->links() }}

            </div>

        @endif


    </div>

</div>

@endsection
