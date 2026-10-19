<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pesan Kamar | Stayora Hotel</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7f4;
            color: #20352c;
        }

        header {
            padding: 22px 7%;
            background: white;
            border-bottom: 1px solid #e4eae5;
        }

        .brand {
            color: #245747;
            font-size: 24px;
            font-weight: 800;
            text-decoration: none;
        }

        .brand span {
            color: #c69b5c;
        }

        .container {
            width: min(1000px, 92%);
            margin: 40px auto;
        }

        .back {
            color: #245747;
            text-decoration: none;
            font-size: 14px;
        }

        h1 {
            margin-bottom: 8px;
        }

        .intro {
            color: #708078;
            margin-bottom: 25px;
        }

        .layout {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 25px;
            align-items: start;
        }

        .card {
            padding: 25px;
            background: white;
            border: 1px solid #e3e9e3;
            border-radius: 15px;
        }

        .room-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 10px;
            background: #e5eae5;
        }

        .room-name {
            font-size: 23px;
            margin: 18px 0 8px;
        }

        .muted {
            color: #718078;
            line-height: 1.6;
        }

        .room-price {
            color: #245747;
            font-size: 25px;
            font-weight: 800;
            margin-top: 20px;
        }

        .room-price small {
            color: #718078;
            font-size: 13px;
            font-weight: normal;
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        .field input,
        .field textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d9e1da;
            border-radius: 8px;
            font: inherit;
            background: white;
        }

        .field textarea {
            min-height: 90px;
            resize: vertical;
        }

        .field input:focus,
        .field textarea:focus {
            outline: 2px solid #b8d1c0;
            border-color: #245747;
        }

        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .error {
            color: #b42318;
            background: #fff0ee;
            border: 1px solid #f5c7c3;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .error ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .estimate {
            padding: 15px;
            margin-bottom: 18px;
            border-radius: 9px;
            background: #edf4ed;
        }

        .estimate strong {
            color: #245747;
            font-size: 21px;
        }

        .submit {
            width: 100%;
            border: 0;
            border-radius: 8px;
            padding: 14px;
            color: white;
            background: #245747;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
        }

        .submit:hover {
            background: #183f32;
        }

        .note {
            color: #718078;
            font-size: 12px;
            line-height: 1.6;
            margin-top: 14px;
        }

        @media (max-width: 700px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .two-columns {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .container {
                margin-top: 25px;
            }
        }
    </style>
</head>

<body>
    <header>
        <a class="brand" href="{{ route('home') }}">
            STAYORA<span>.</span>
        </a>
    </header>

    <main class="container">
        <a class="back" href="{{ route('home') }}">
            &larr; Kembali ke daftar kamar
        </a>

        <h1>Reservasi Kamar</h1>

        <p class="intro">
            Lengkapi data di bawah untuk membuat pemesanan.
        </p>

        @if ($errors->any())
            <div class="error">
                <strong>Reservasi belum dapat diproses.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="layout">
            <section class="card">
                <img
                    class="room-image"
                    src="{{ $roomType->image }}"
                    alt="{{ $roomType->name }}"
                >

                <h2 class="room-name">{{ $roomType->name }}</h2>

                <p class="muted">{{ $roomType->description }}</p>

                <p class="muted">
                    Kapasitas maksimal:
                    {{ $roomType->capacity }} orang
                </p>

                <div class="room-price">
                    Rp{{ number_format((float) $roomType->price_per_night, 0, ',', '.') }}
                    <small>/ malam</small>
                </div>

                <p class="note">
                    Reservasi akan berstatus menunggu konfirmasi.
                    Total harga dihitung berdasarkan jumlah malam.
                </p>
            </section>

            <section class="card">
                <form
                    method="POST"
                    action="{{ route('bookings.store', $roomType) }}"
                >
                    @csrf

                    <div class="two-columns">
                        <div class="field">
                            <label for="check_in">Check-in</label>
                            <input
                                id="check_in"
                                name="check_in"
                                type="date"
                                min="{{ now()->toDateString() }}"
                                value="{{ old('check_in', $checkIn) }}"
                                required
                            >
                        </div>

                        <div class="field">
                            <label for="check_out">Check-out</label>
                            <input
                                id="check_out"
                                name="check_out"
                                type="date"
                                min="{{ now()->addDay()->toDateString() }}"
                                value="{{ old('check_out', $checkOut) }}"
                                required
                            >
                        </div>
                    </div>

                    <div class="field">
                        <label for="guests">Jumlah tamu</label>
                        <input
                            id="guests"
                            name="guests"
                            type="number"
                            min="1"
                            max="{{ $roomType->capacity }}"
                            value="{{ old('guests', 1) }}"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="guest_name">Nama tamu</label>
                        <input
                            id="guest_name"
                            name="guest_name"
                            type="text"
                            value="{{ old('guest_name', auth()->user()->name) }}"
                            maxlength="255"
                            autocomplete="name"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="guest_email">Email tamu</label>
                        <input
                            id="guest_email"
                            name="guest_email"
                            type="email"
                            value="{{ old('guest_email', auth()->user()->email) }}"
                            maxlength="255"
                            autocomplete="email"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="guest_phone">Nomor telepon</label>
                        <input
                            id="guest_phone"
                            name="guest_phone"
                            type="tel"
                            value="{{ old('guest_phone') }}"
                            maxlength="30"
                            autocomplete="tel"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="special_requests">
                            Permintaan khusus (opsional)
                        </label>
                        <textarea
                            id="special_requests"
                            name="special_requests"
                            maxlength="2000"
                        >{{ old('special_requests') }}</textarea>
                    </div>

                    <div class="estimate">
                        <div>Perkiraan total harga</div>
                        <strong id="total_price">Pilih tanggal menginap</strong>
                        <div class="muted" id="night_count"></div>
                    </div>

                    <button class="submit" type="submit">
                        Buat Reservasi
                    </button>

                    <p class="note">
                        Belum ada pembayaran otomatis pada tahap ini.
                        Data pembayaran akan berstatus menunggu konfirmasi.
                    </p>
                </form>
            </section>
        </div>
    </main>

    <script>
        const checkIn = document.getElementById('check_in');
        const checkOut = document.getElementById('check_out');
        const totalPrice = document.getElementById('total_price');
        const nightCount = document.getElementById('night_count');

        const pricePerNight = Number(
            @json((float) $roomType->price_per_night)
        );

        const rupiah = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        });

        function updateEstimate() {
            if (checkIn.value) {
                const minimumCheckout = new Date(
                    checkIn.value + 'T00:00:00'
                );

                minimumCheckout.setDate(
                    minimumCheckout.getDate() + 1
                );

                const year = minimumCheckout.getFullYear();
                const month = String(
                    minimumCheckout.getMonth() + 1
                ).padStart(2, '0');
                const day = String(
                    minimumCheckout.getDate()
                ).padStart(2, '0');

                checkOut.min = `${year}-${month}-${day}`;

                if (
                    checkOut.value &&
                    checkOut.value <= checkIn.value
                ) {
                    checkOut.value = '';
                }
            }

            if (!checkIn.value || !checkOut.value) {
                totalPrice.textContent = 'Pilih tanggal menginap';
                nightCount.textContent = '';
                return;
            }

            const start = new Date(checkIn.value + 'T00:00:00');
            const end = new Date(checkOut.value + 'T00:00:00');

            const nights = Math.round(
                (end - start) / (1000 * 60 * 60 * 24)
            );

            if (nights < 1) {
                totalPrice.textContent = 'Periksa tanggal Anda';
                nightCount.textContent = '';
                return;
            }

            totalPrice.textContent = rupiah.format(
                pricePerNight * nights
            );

            nightCount.textContent =
                `${nights} malam × ${rupiah.format(pricePerNight)}`;
        }

        checkIn.addEventListener('change', updateEstimate);
        checkOut.addEventListener('change', updateEstimate);

        updateEstimate();
    </script>
</body>
</html>
