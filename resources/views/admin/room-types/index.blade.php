<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kamar | Stayora</title>

    <style>
        * { box-sizing: border-box; }

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

        header a {
            color: white;
            text-decoration: none;
        }

        .brand {
            font-size: 22px;
            font-weight: 800;
        }

        .brand span { color: #e2bd7d; }

        main {
            width: min(1200px, 94%);
            margin: 35px auto;
        }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 22px;
        }

        h1 { margin: 0 0 8px; }

        .muted {
            color: #748078;
            font-size: 13px;
        }

        .button {
            display: inline-block;
            padding: 10px 14px;
            border: 0;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        .primary {
            background: #245747;
            color: white;
        }

        .secondary {
            background: #edf2ed;
            color: #245747;
        }

        .danger {
            background: #ffebe8;
            color: #a42e25;
        }

        .notice {
            padding: 14px;
            margin-bottom: 18px;
            background: #e4f5e8;
            color: #205c38;
            border-radius: 8px;
        }

        .panel {
            background: white;
            border: 1px solid #e3e9e3;
            border-radius: 12px;
            overflow: hidden;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            min-width: 760px;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            border-bottom: 1px solid #edf0ed;
            text-align: left;
            vertical-align: middle;
            font-size: 13px;
        }

        th {
            background: #fafbf9;
            color: #657168;
            text-transform: uppercase;
            font-size: 11px;
        }

        .room-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .price {
            font-weight: bold;
            color: #245747;
            white-space: nowrap;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .active {
            background: #e0f3e5;
            color: #20663e;
        }

        .inactive {
            background: #ffebe8;
            color: #a42e25;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }

        .actions form { margin: 0; }

        .empty {
            padding: 28px;
            text-align: center;
            color: #748078;
        }

        .pagination { padding: 18px; }

        @media (max-width: 600px) {
            .heading { align-items: flex-start; }
        }
    </style>
</head>

<body>
<header>
    <div class="brand">STAYORA<span>.</span> ADMIN</div>
    <a href="{{ route('admin.bookings.index') }}">
        Dashboard Reservasi &rarr;
    </a>
</header>

<main>
    <div class="heading">
        <div>
            <h1>Manajemen Tipe Kamar</h1>
            <div class="muted">
                Tambah, ubah harga, dan kelola fasilitas kamar hotel.
            </div>
        </div>

        <a
            class="button primary"
            href="{{ route('admin.room-types.create') }}"
        >
            + Tambah Tipe Kamar
        </a>
    </div>

    @if (session('success'))
        <div class="notice">{{ session('success') }}</div>
    @endif

    <section class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Tipe Kamar</th>
                        <th>Harga per Malam</th>
                        <th>Kapasitas</th>
                        <th>Jumlah Kamar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($roomTypes as $roomType)
                        <tr>
                            <td>
                                <div class="room-name">
                                    {{ $roomType->name }}
                                </div>
                                <div class="muted">
                                    {{ $roomType->description }}
                                </div>
                            </td>

                            <td class="price">
                                Rp{{ number_format((float) $roomType->price_per_night, 0, ',', '.') }}
                            </td>

                            <td>{{ $roomType->capacity }} orang</td>

                            <td>{{ $roomType->rooms_count }} kamar</td>

                            <td>
                                @if ($roomType->is_active)
                                    <span class="badge active">Aktif</span>
                                @else
                                    <span class="badge inactive">Nonaktif</span>
                                @endif
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        class="button secondary"
                                        href="{{ route('admin.room-types.edit', $roomType) }}"
                                    >
                                        Edit
                                    </a>

                                    @if ($roomType->is_active)
                                        <form
                                            method="POST"
                                            action="{{ route('admin.room-types.destroy', $roomType) }}"
                                            onsubmit="return confirm('Nonaktifkan tipe kamar ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="button danger"
                                            >
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada tipe kamar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $roomTypes->links() }}
        </div>
    </section>
</main>
</body>
</html>
