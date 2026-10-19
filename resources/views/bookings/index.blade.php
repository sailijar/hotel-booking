<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Saya | Stayora</title>

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
            background: white;
            padding: 22px 7%;
            border-bottom: 1px solid #e3e9e3;
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

        main {
            width: min(1000px, 92%);
            margin: 35px auto;
        }

        .back {
            color: #245747;
            text-decoration: none;
            font-size: 14px;
        }

        .notice {
            padding: 14px;
            border-radius: 8px;
            background: #e5f5e9;
            color: #205d38;
            margin: 20px 0;
        }

        .booking {
            background: white;
            border: 1px solid #e3e9e3;
            border-radius: 12px;
            padding: 22px;
            margin: 18px 0;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .code {
            color: #245747;
            font-weight: bold;
        }

        .status {
            background: #fff3d7;
            color: #855d13;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
        }

        .details {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin: 22px 0;
        }

        .label {
            color: #718078;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .value {
            font-weight: bold;
        }

        .price {
            font-size: 22px;
            color: #245747;
            font-weight: bold;
        }

        .empty {
            margin-top: 25px;
            padding: 30px;
            background: white;
            border-radius: 12px;
            text-align: center;
        }

        .button {
            display: inline-block;
            background: #245747;
            color: white;
            padding: 11px 17px;
            border-radius: 7px;
            text-decoration: none;
            margin-top: 12px;
        }

        @media (max-width: 550px) {
            .details {
                grid-template-columns: 1fr;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('home') }}" class="brand">
            STAYORA<span>.</span>
        </a>
    </header>

    <main>
        <a class="back" href="{{ route('home') }}">
            &larr; Kembali ke halaman hotel
        </a>

        <h1>Reservasi Saya</h1>
        <p>Periksa detail dan status pemesanan kamar Anda.</p>

        @if (session('success'))
            <div class="notice">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($bookings as $booking)
            <article class="booking">
                <div class="booking-header">
                    <div>
                        <div class="label">Kode reservasi</div>
                        <div class="code">{{ $booking->booking_code }}</div>
                    </div>

                    <span class="status">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>

                <h2>{{ $booking->room->roomType->name }}</h2>

                <div class="details">
                    <div>
                        <div class="label">Nomor kamar</div>
                        <div class="value">
                            {{ $booking->room->room_number }}
                        </div>
                    </div>

                    <div>
                        <div class="label">Jumlah tamu</div>
                        <div class="value">
                            {{ $booking->guests }} orang
                        </div>
                    </div>

                    <div>
                        <div class="label">Check-in</div>
                        <div class="value">
                            {{ $booking->check_in->format('d-m-Y') }}
                        </div>
                    </div>

                    <div>
                        <div class="label">Check-out</div>
                        <div class="value">
                            {{ $booking->check_out->format('d-m-Y') }}
                        </div>
                    </div>
                </div>

                <div class="label">Total harga</div>
                <div class="price">
                    Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}
                </div>

                <p class="label">
                    Status pembayaran:
                    {{ ucfirst($booking->payments->first()?->status ?? 'pending') }}
                </p>
            </article>
        @empty
            <div class="empty">
                <h2>Belum ada reservasi</h2>
                <p>Pesanan kamar Anda akan muncul di halaman ini.</p>

                <a href="{{ route('home') }}" class="button">
                    Lihat pilihan kamar
                </a>
            </div>
        @endforelse
    </main>
</body>
</html>
