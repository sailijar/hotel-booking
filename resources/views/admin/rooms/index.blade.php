<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Nomor Kamar | Stayora</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7f4;
            color: #20352c;
        }

        header {
            padding: 20px 5%;
            background: #173d31;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        header a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .brand {
            font-size: 22px;
            font-weight: 800;
        }

        .brand span { color: #e2bd7d; }

        main {
            width: min(1100px, 94%);
            margin: 35px auto;
        }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        h1 { margin-bottom: 8px; }

        .muted {
            color: #748078;
            font-size: 13px;
        }

        .button {
            display: inline-block;
            border: 0;
            padding: 10px 14px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
        }

        .primary {
            color: white;
            background: #245747;
        }

        .secondary {
            color: #245747;
            background: #eaf0ea;
        }

        .notice {
            background: #e4f5e8;
            color: #205c38;
            padding: 14px;
            margin-bottom: 18px;
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
            min-width: 700px;
            border-collapse: collapse;
        }

        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #edf0ed;
            font-size: 13px;
        }

        th {
            color: #657168;
            background: #fafbf9;
            font-size: 11px;
            text-transform: uppercase;
        }

        .room-number {
            color: #245747;
            font-weight: 800;
            font-size: 15px;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .available {
            color: #20663e;
            background: #e0f3e5;
        }

        .maintenance {
            color: #925016;
            background: #fff0d8;
        }

        .empty {
            padding: 30px;
            text-align: center;
            color: #748078;
        }

        .pagination { padding: 18px; }

        @media (max-width: 600px) {
            .heading { align-items: flex-start; }
        }

}
    </style>
</head>

<body>
<header>
    <div class="brand">STAYORA<span>.</span> ADMIN</div>

    <a href="{{ route('admin.bookings.index') }}">
        &larr; Kembali ke Dashboard Admin
    </a>
</header>

<main>
    <div class="heading">
        <div>
            <h1>Manajemen Nomor Kamar</h1>
            <div class="muted">
                Kelola nomor kamar, tipe kamar, lantai, dan status operasional.
            </div>
        </div>

        <a
            href="{{ route('admin.rooms.create') }}"
            class="button primary"
        >
            + Tambah Nomor Kamar
        </a>
    </div>

    @if (session('success'))
        <div class="notice">
            {{ session('success') }}
        </div>
    @endif

    <section class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nomor Kamar</th>
                        <th>Tipe Kamar</th>
                        <th>Lantai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($rooms as $room)
                        <tr>
                            <td>
                                <div class="room-number">
                                    {{ $room->room_number }}
                                </div>
                            </td>

                            <td>
                                {{ $room->roomType->name ?? 'Tipe tidak tersedia' }}
                            </td>

                            <td>
                                {{ $room->floor ?? '-' }}
                            </td>

                            <td>
                                <span class="badge {{ $room->status }}">
                                    {{ $room->status === 'available'
                                        ? 'Tersedia'
                                        : 'Dalam Perawatan' }}
                                </span>
                            </td>

                            <td>
                                <a
                                    class="button secondary"
                                    href="{{ route('admin.rooms.edit', $room) }}"
                                >
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada nomor kamar.
                                Klik Tambah Nomor Kamar untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $rooms->links() }}
        </div>
    </section>
</main>
</body>
</html>
