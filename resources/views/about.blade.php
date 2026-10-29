@extends('layouts.app')

@section('title', 'Tentang dan Kontak - LOKALKITA')

@section('content')

<!-- HALAMAN KONTAK -->
<section class="contact-page">

    <div class="contact-heading">
        <h1>Kontak Kami</h1>
        <p>
            Jika ada pertanyaan atau kebutuhan, silakan hubungi
            kami melalui informasi berikut.
        </p>
    </div>

    <div class="contact-layout">

        <!-- INFORMASI KONTAK -->
        <div class="contact-information">
            <h2>Informasi Kontak</h2>
            <p class="contact-description">
                Kami siap membantu kamu mengenal dan menemukan
                produk UMKM lokal Indonesia.
            </p>

            <div class="contact-info-item">
                <div class="contact-info-icon">✉️</div>
                <div>
                    <h3>Email</h3>
                    <p>lokalkita@example.com</p>
                </div>
            </div>

            <div class="contact-info-item">
                <div class="contact-info-icon">📞</div>
                <div>
                    <h3>Telepon</h3>
                    <p>+62 812 3456 7890</p>
                </div>
            </div>

            <div class="contact-info-item">
                <div class="contact-info-icon">📍</div>
                <div>
                    <h3>Alamat</h3>
                    <p>
                        Jl. Melati No. 12, Kisaran,
                        Sumatera Utara, Indonesia
                    </p>
                </div>
            </div>
        </div>

        <!-- FORMULIR PESAN -->
        <div class="contact-form-card">
            <h2>Kirim Pesan</h2>
            <p class="contact-description">
                Isi formulir berikut untuk menghubungi kami.
            </p>

            @if (session('success'))
                <div class="contact-alert contact-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="contact-alert contact-alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST">
                @csrf

                <div class="contact-form-group">
                    <label for="contact_name">Nama Lengkap</label>
                    <input
                        type="text"
                        id="contact_name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama kamu"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="contact-form-group">
                    <label for="contact_email">Email</label>
                    <input
                        type="email"
                        id="contact_email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email kamu"
                        maxlength="150"
                        required
                    >
                </div>

                <div class="contact-form-group">
                    <label for="contact_subject">Subjek</label>
                    <input
                        type="text"
                        id="contact_subject"
                        name="subject"
                        value="{{ old('subject') }}"
                        placeholder="Subjek pesan"
                        maxlength="150"
                        required
                    >
                </div>

                <div class="contact-form-group">
                    <label for="contact_message">Pesan</label>
                    <textarea
                        id="contact_message"
                        name="message"
                        rows="4"
                        placeholder="Tuliskan pesan kamu..."
                        maxlength="3000"
                        required
                    >{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="contact-submit-button">
                    Kirim Pesan →
                </button>
            </form>
        </div>

    </div>

    <!-- PETA LOKASI -->
    <div class="contact-map-section">
        <h2>Lokasi Kami</h2>
        <p>Kisaran, Sumatera Utara, Indonesia</p>

        <div class="contact-map">
            <iframe
                title="Peta Kisaran, Sumatera Utara"
                src="https://www.google.com/maps?q=Kisaran,Sumatera,Utara,Indonesia&output=embed"
                width="100%"
                height="300"
                style="border:0;"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen>
            </iframe>
        </div>

        <a
            href="https://www.google.com/maps/search/?api=1&query=Kisaran%2C%20Sumatera%20Utara%2C%20Indonesia"
            target="_blank"
            rel="noopener noreferrer"
            class="contact-map-link">
            Buka di Google Maps →
        </a>
    </div>

</section>

@endsection