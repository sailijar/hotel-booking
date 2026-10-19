<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $room->exists ? 'Edit' : 'Tambah' }} Kamar | Stayora</title>

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
            font-size: 22px;
            font-weight: 800;
        }

        header span { color: #e2bd7d; }

        main {
            width: min(700px, 94%);
            margin: 35px auto;
        }

        .back {
            color: #245747;
            text-decoration: none;
            font-size: 14px;
        }

        h1 { margin-bottom: 8px; }

        .muted {
            color: #748078;
            font-size: 13px;
            line-height: 1.6;
        }

        .card {
            margin-top: 22px;
            padding: 25px;
            background: white;
            border: 1px solid #e3e9e3;
            border-radius: 12px;
        }

        .field { margin-bottom: 18px; }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d9e1da;
            border-radius: 7px;
            font: inherit;
            background: white;
        }

        input:focus, select:focus {
            outline: 2px solid #c5dbcb;
            border-color: #245747;
        }

        .error-box {
            margin-top: 16px;
            padding: 13px;
            border-radius: 8px;
            background: #ffebe8;
            color: #a42e25;
        }

        .error-box ul {
            margin-bottom: 0;
            padding-left: 20px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 25px;
        }

        .button {
            display: inline-block;
            border: 0;
            padding: 12px 16px;
            border-radius: 7px;
            font-weight: bold;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
        }

        .primary {
            background: #245747;
            color: white;
        }

        .secondary {
            background: #eaf0ea;
            color: #245747;
        }

        @media (max-width: 500px) {
            .card { padding: 18px; }
        }
    </style>
</head>

<body>
<header>STAYORA<span>.</span> ADMIN</header>

<main>
    <a class="back" href="{{ route('admin.rooms.index') }}">
        &larr; Kembali ke daftar kamar
    </a>

    <h1>{{ $room->exists ? 'Edit Nomor Kamar' : 'Tambah Nomor Kamar' }}</h1>

    <p class="muted">
        Masukkan nomor kamar dan pilih tipe kamar yang sesuai.
    </p>

    @if ($errors->any())
        <div class="error-box">
            <strong>Periksa kembali formulir:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="card">
        @if ($roomTypes->isEmpty())
            <p class="muted">
                Belum ada tipe kamar aktif.
                Tambahkan tipe kamar terlebih dahulu sebelum membuat nomor kamar.
            </p>

            <a class="button primary"
               href="{{ route('admin.room-types.create') }}">
                Tambah Tipe Kamar
            </a>
        @else
            <form
                method="POST"
                action="{{ $room->exists
                    ? route('admin.rooms.update', $room)
                    : route('admin.rooms.store') }}"
            >
                @csrf

                @if ($room->exists)
                    @method('PUT')
                @endif

                <div class="field">
                    <label for="room_number">Nomor Kamar *</label>

                    <input
                        type="text"
                        id="room_number"
                        name="room_number"
                        value="{{ old('room_number', $room->room_number) }}"
                        maxlength="50"
                        placeholder="Contoh: 101"
                        required
                    >
                </div>

                <div class="field">
                    <label for="room_type_id">Tipe Kamar *</label>

                    <select
                        id="room_type_id"
                        name="room_type_id"
                        required
                    >
                        <option value="">-- Pilih Tipe Kamar --</option>

                        @foreach ($roomTypes as $type)
                            <option
                                value="{{ $type->id }}"
                                @selected(
                                    (string) old('room_type_id', $room->room_type_id)
                                    === (string) $type->id
                                )
                            >
                                {{ $type->name }}
                                — Rp{{ number_format((float) $type->price_per_night, 0, ',', '.') }}/malam
                                {{ $type->is_active ? '' : '(Nonaktif)' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="floor">Lantai</label>

                    <input
                        type="number"
                        id="floor"
                        name="floor"
                        min="0"
                        max="100"
                        value="{{ old('floor', $room->floor) }}"
                        placeholder="Contoh: 1"
                    >
                </div>

                <div class="field">
                    <label for="status">Status Operasional</label>

                    <select id="status" name="status" required>
                        <option
                            value="available"
                            @selected(old('status', $room->status) === 'available')
                        >
                            Tersedia
                        </option>

                        <option
                            value="maintenance"
                            @selected(old('status', $room->status) === 'maintenance')
                        >
                            Dalam Perawatan
                        </option>
                    </select>

                    <p class="muted">
                        Kamar dalam perawatan tidak akan dipilih untuk reservasi baru.
                    </p>
                </div>

                <div class="actions">
                    <button class="button primary" type="submit">
                        {{ $room->exists ? 'Simpan Perubahan' : 'Simpan Kamar' }}
                    </button>

                    <a
                        href="{{ route('admin.rooms.index') }}"
                        class="button secondary"
                    >
                        Batal
                    </a>
                </div>
            </form>
        @endif
    </section>
</main>
</body>
</html>
