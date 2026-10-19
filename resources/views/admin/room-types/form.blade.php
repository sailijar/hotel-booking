<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ $roomType->exists ? 'Edit' : 'Tambah' }} Tipe Kamar | Stayora
    </title>

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
            font-size: 22px;
            font-weight: bold;
        }

        header span { color: #e2bd7d; }

        main {
            width: min(760px, 94%);
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
            font-size: 14px;
            line-height: 1.6;
        }

        .card {
            background: white;
            border: 1px solid #e3e9e3;
            border-radius: 12px;
            padding: 25px;
            margin-top: 24px;
        }

        .field { margin-bottom: 19px; }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            font-size: 14px;
        }

        input:not([type="checkbox"]),
        textarea {
            display: block;
            width: 100%;
            padding: 12px;
            border: 1px solid #d9e1da;
            border-radius: 7px;
            font: inherit;
            background: white;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: 2px solid #c5dbcb;
            border-color: #245747;
        }

        .hint {
            color: #748078;
            font-size: 12px;
            margin-top: 6px;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 20px 0;
        }

        .checkbox-row label { margin: 0; }

        .error-box {
            color: #a42e25;
            background: #ffebe8;
            padding: 13px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .error-box ul {
            padding-left: 20px;
            margin-bottom: 0;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .button {
            display: inline-block;
            padding: 12px 17px;
            border-radius: 7px;
            border: 0;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
        }

        .primary {
            color: white;
            background: #245747;
        }

        .secondary {
            color: #245747;
            background: #edf2ed;
        }

        @media (max-width: 500px) {
            .card { padding: 18px; }
        }
    </style>
</head>

<body>
<header>
    STAYORA<span>.</span> ADMIN
</header>

<main>
    <a class="back" href="{{ route('admin.room-types.index') }}">
        &larr; Kembali ke manajemen kamar
    </a>

    <h1>
        {{ $roomType->exists ? 'Edit Tipe Kamar' : 'Tambah Tipe Kamar' }}
    </h1>

    <p class="muted">
        Isi informasi tipe kamar, harga, kapasitas, gambar, dan fasilitas.
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
        <form
            method="POST"
            action="{{ $roomType->exists
                ? route('admin.room-types.update', $roomType)
                : route('admin.room-types.store') }}"
        >
            @csrf

            @if ($roomType->exists)
                @method('PUT')
            @endif

            <div class="field">
                <label for="name">Nama tipe kamar *</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    maxlength="100"
                    value="{{ old('name', $roomType->name) }}"
                    placeholder="Contoh: Deluxe Room"
                    required
                >
            </div>

            <div class="field">
                <label for="description">Deskripsi</label>
                <textarea
                    id="description"
                    name="description"
                    maxlength="2000"
                    placeholder="Jelaskan fasilitas dan kenyamanan kamar."
                >{{ old('description', $roomType->description) }}</textarea>
            </div>

            <div class="field">
                <label for="price_per_night">Harga per malam (Rupiah) *</label>
                <input
                    id="price_per_night"
                    name="price_per_night"
                    type="number"
                    min="0.01"
                    step="0.01"
                    value="{{ old('price_per_night', $roomType->price_per_night) }}"
                    placeholder="350000"
                    required
                >
            </div>

            <div class="field">
                <label for="capacity">Kapasitas tamu *</label>
                <input
                    id="capacity"
                    name="capacity"
                    type="number"
                    min="1"
                    max="20"
                    value="{{ old('capacity', $roomType->capacity ?? 2) }}"
                    required
                >
            </div>

            <div class="field">
                <label for="image">URL gambar kamar</label>
                <input
                    id="image"
                    name="image"
                    type="url"
                    maxlength="2048"
                    value="{{ old('image', $roomType->image) }}"
                    placeholder="https://example.com/kamar.jpg"
                >
                <div class="hint">
                    Gunakan URL gambar yang dapat diakses publik.
                </div>
            </div>

            <div class="field">
                <label for="amenities_text">Fasilitas kamar</label>
                <textarea
                    id="amenities_text"
                    name="amenities_text"
                    maxlength="1000"
                    placeholder="Wi-Fi, AC, TV, Sarapan"
                >{{ old('amenities_text', implode(', ', $roomType->amenities ?? [])) }}</textarea>
                <div class="hint">
                    Pisahkan setiap fasilitas menggunakan koma.
                </div>
            </div>

            <div class="checkbox-row">
                <input
                    id="is_active"
                    name="is_active"
                    type="checkbox"
                    value="1"
                    {{ old('is_active', $roomType->is_active) ? 'checked' : '' }}
                >
                <label for="is_active">Tipe kamar aktif dan dapat dipesan</label>
            </div>

            <div class="actions">
                <button type="submit" class="button primary">
                    {{ $roomType->exists ? 'Simpan Perubahan' : 'Simpan Tipe Kamar' }}
                </button>

                <a
                    href="{{ route('admin.room-types.index') }}"
                    class="button secondary"
                >
                    Batal
                </a>
            </div>
        </form>
    </section>
</main>
</body>
</html>
