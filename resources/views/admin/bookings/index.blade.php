<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin | Stayora</title>

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
            background: #173d31;
            color: white;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .brand {
            font-size: 23px;
            font-weight: 800;
        }

        .brand span {
            color: #e2bd7d;
        }

        header a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        main {
            width: min(1250px, 94%);
            margin: 30px auto;
        }

        .page-heading {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            align-items: start;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 7px;
            font-size: 30px;
        }

        .muted {
            color: #758179;
            font-size: 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .stat {
            background: white;
            padding: 20px;
            border: 1px solid #e3e9e3;
            border-radius: 12px;
        }

        .stat-label {
            color: #758179;
            font-size: 13px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 800;
            margin-top: 8px;
            overflow-wrap: anywhere;
        }

        .revenue {
            background: #e6f1e8;
            color: #245747;
        }

        .panel {
            background: white;
            border: 1px solid #e3e9e3;
            border-radius: 12px;
            overflow: hidden;
        }

        .panel-heading {
            padding: 20px;
            border-bottom: 1px solid #e8ede8;
        }

        .panel-heading h2 {
            margin: 0 0 5px;
            font-size: 20px;
        }

        .notice {
            margin: 18px 0;
            padding: 14px 16px;
            border-radius: 8px;
            background: #e4f5e8;
            color: #205c38;
        }

        .error {
            margin: 18px 0;
            padding: 14px 16px;
            border-radius: 8px;
            background: #fff0ee;
            color: #a12c22;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1000px;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px 16px;
            text-align: left;
            border-bottom: 1px solid #edf0ed;
            vertical-align: top;
            font-size: 13px;
        }

        th {
            background: #fafbf9;
            color: #657168;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .booking-code {
            font-weight: 800;
            color: #245747;
        }

        .status {
            display: inline-block;
            border-radius: 20px;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: bold;
            white-space: nowrap;
        }

        .pending {
            color: #885b13;
            background: #fff1cf;
        }

        .confirmed {
            color: #20663e;
            background: #e0f3e5;
        }

        .cancelled {
            color: #a42e25;
            background: #ffebe8;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 110px;
        }

        .actions form {
            margin: 0;
        }

        .button {
            display: block;
            border: 0;
            width: 100%;
            padding: 9px 10px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 12px;
        }

        .confirm {
            background: #245747;
            color: white;
        }

        .cancel {
            background: #ffebe8;
            color: #a42e25;
        }

        .empty {
            padding: 35px;
            text-align: center;
            color: #758179;
        }

        .pagination {
            padding: 20px;
        }

        .pagination nav p {
            font-size: 13px;
            color: #758179;
        }

        @media (max-width: 850px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 450px) {
            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="brand">STAYORA<span>.</span> ADMIN</div>
        <a href="{{ route('home') }}">Lihat Website Hotel &rarr;</a>
    </header>

    <main>
        <div class="page-heading">
            <div>
                <h1>Dashboard Admin</h1>
                <div class="muted">
                    Selamat datang, {{ auth()->user()->name }}.
                    Kelola reservasi hotel dari halaman ini.
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="notice">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <section class="stats">
            <div class="stat">
                <div class="stat-label">Total reservasi</div>
                <div class="stat-number">
                    {{ number_format($stats['total']) }}
                </div>
            </div>

            <div class="stat">
                <div class="stat-label">Menunggu konfirmasi</div>
                <div class="stat-number">
                    {{ number_format($stats['pending']) }}
                </div>
            </div>

            <div class="stat">
                <div class="stat-label">Dikonfirmasi</div>
                <div class="stat-number">
                    {{ number_format($stats['confirmed']) }}
                </div>
            </div>

            <div class="stat">
                <div class="stat-label">Dibatalkan</div>
                <div class="stat-number">
                    {{ number_format($stats['cancelled']) }}
                </div>
            </div>
        </section>

        <section class="stat revenue" style="margin-bottom: 22px">
            <div class="stat-label">
                Nilai reservasi berstatus dikonfirmasi
            </div>

            <div class="stat-number">
                Rp{{ number_format((float) $stats['confirmed_value'], 0, ',', '.') }}
            </div>

            <div class="muted">
                Bukan angka pembayaran yang sudah diterima.
            </div>
        </section>

        <section class="panel">
            <div class="panel-heading">
                <h2>Daftar Reservasi</h2>
                <div class="muted">
                    Periksa data pelanggan dan kelola status pemesanan.
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Kode booking</th>
                            <th>Pelanggan</th>
                            <th>Kamar</th>
                            <th>Tanggal menginap</th>
                            <th>Total harga</th>
                            <th>Status booking</th>
                            <th>Status pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td>
                                    <div class="booking-code">
                                        {{ $booking->booking_code }}
                                    </div>
                                    <div class="muted">
                                        {{ $booking->created_at->format('d-m-Y') }}
                                    </div>
                                </td>

                                <td>
                                    <strong>
                                        {{ $booking->guest_name }}
                                    </strong>
                                    <div class="muted">
                                        {{ $booking->guest_email }}
                                    </div>
                                    <div class="muted">
                                        {{ $booking->guest_phone }}
                                    </div>
                                </td>

                                <td>
                                    {{ $booking->room->roomType->name }}
                                    <div class="muted">
                                        Kamar {{ $booking->room->room_number }}
                                    </div>
                                </td>

                                <td>
                                    {{ $booking->check_in->format('d-m-Y') }}
                                    <div class="muted">
                                        sampai
                                        {{ $booking->check_out->format('d-m-Y') }}
                                    </div>
                                    {{ $booking->guests }} tamu
                                </td>

                                <td>
                                    <strong>
                                        Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}
                                    </strong>
                                </td>

                                <td>
                                    <span class="status {{ $booking->status }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>

                                <td>
                                    @php
                                        $paymentStatus = $booking->payments->first()?->status ?? 'pending';
                                    @endphp

                                    <span class="status {{ $paymentStatus === 'paid' ? 'confirmed' : 'pending' }}">
                                        {{ ucfirst($paymentStatus) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="actions">
                                        @if ($booking->status === 'pending')
                                            <form
                                                method="POST"
                                                action="{{ route('admin.bookings.status', $booking) }}"
                                                onsubmit="return confirm('Konfirmasi reservasi ini?')"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <input
                                                    type="hidden"
                                                    name="status"
                                                    value="confirmed"
                                                >

                                                <button class="button confirm" type="submit">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                        @endif

                                        @if (in_array($booking->status, ['pending', 'confirmed'], true))
                                            <form
                                                method="POST"
                                                action="{{ route('admin.bookings.status', $booking) }}"
                                                onsubmit="return confirm('Batalkan reservasi ini?')"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <input
                                                    type="hidden"
                                                    name="status"
                                                    value="cancelled"
                                                >

                                                <button class="button cancel" type="submit">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty">
                                    Belum ada reservasi yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $bookings->links() }}
            </div>
        </section>
    </main>
</body>
</html>
