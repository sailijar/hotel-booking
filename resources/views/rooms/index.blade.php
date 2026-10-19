<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Stayora Hotel | Pemesanan Kamar</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f7f4;
            color: #20352c;
            line-height: 1.6;
        }

        header {
            background: white;
            padding: 22px 7%;
            border-bottom: 1px solid #e4eae5;
        }

        .brand {
            color: #245747;
            font-size: 25px;
            font-weight: 800;
        }

        .brand span {
            color: #c69b5c;
        }

        .hero {
            margin: 30px auto;
            width: 86%;
            min-height: 320px;
            padding: 55px;
            display: flex;
            align-items: center;
            color: white;
            border-radius: 18px;
            background:
                linear-gradient(90deg, #173d31, #173d3180),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1400&q=80')
                center/cover;
        }

        .hero h1 {
            max-width: 560px;
            font-size: clamp(32px, 5vw, 48px);
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .hero p {
            max-width: 500px;
            color: #e6eee8;
        }

        main {
            width: 86%;
            margin: 45px auto 70px;
        }

        .section-heading {
            margin-bottom: 25px;
        }

        .section-heading h2 {
            font-size: 30px;
        }

        .section-heading p {
            color: #738077;
        }

        .rooms {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .card {
            background: white;
            border: 1px solid #e6ebe6;
            border-radius: 16px;
            overflow: hidden;
        }

        .card img {
            width: 100%;
            height: 210px;
            display: block;
            object-fit: cover;
            background: #e5eae5;
        }

        .card-content {
            padding: 22px;
        }

        .status {
            display: inline-block;
            margin-bottom: 12px;
            padding: 4px 10px;
            border-radius: 20px;
            background: #e6f5e9;
            color: #247247;
            font-size: 12px;
        }

        .status.none {
            background: #fff0e8;
            color: #a34b21;
        }

        .card h3 {
            font-size: 21px;
            margin-bottom: 8px;
        }

        .description {
            min-height: 65px;
            color: #728077;
            font-size: 14px;
        }

        .amenities {
            margin: 15px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .amenity {
            border: 1px solid #e3e9e3;
            border-radius: 5px;
            padding: 4px 8px;
            font-size: 12px;
        }

        .price {
            padding-top: 15px;
            border-top: 1px solid #edf0ed;
            color: #245747;
            font-size: 23px;
            font-weight: bold;
        }

        .price small {
            color: #78847b;
            font-size: 12px;
            font-weight: normal;
        }

        .empty {
            grid-column: 1 / -1;
            padding: 35px;
            background: white;
            border-radius: 12px;
        }

        footer {
            padding: 25px;
            background: #173d31;
            color: white;
            text-align: center;
            font-size: 13px;
        }

        @media (max-width: 850px) {
            .rooms {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .hero {
                padding: 35px;
            }
        }

        @media (max-width: 560px) {
            .rooms {
                grid-template-columns: 1fr;
            }

            .hero {
                padding: 25px;
            }

            main, .hero {
                width: 92%;
            }

            header {
                padding: 20px 4%;
            }
        }
        .book-btn {
    display: block;
    margin-top: 16px;
    padding: 12px;
    background: #245747;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
}

.book-btn:hover {
    background: #183f32;
}

.unavailable {
    display: block;
    margin-top: 16px;
    padding: 12px;
    color: #a33e31;
    text-align: center;
    background: #fff0ee;
    border-radius: 8px;
}

.availability-search {
    width: 86%;
    max-width: 1120px;
    margin: -12px auto 0;
    position: relative;
    padding: 22px;
    background: white;
    border: 1px solid #e3e9e3;
    border-radius: 15px;
    box-shadow: 0 12px 30px rgba(24, 55, 40, 0.08);
}

.search-grid {
    display: grid;
    grid-template-columns: 1fr 1fr auto auto;
    align-items: end;
    gap: 14px;
}

.search-field label {
    display: block;
    margin-bottom: 7px;
    font-size: 13px;
    font-weight: bold;
}

.search-field input {
    width: 100%;
    padding: 12px;
    border: 1px solid #d9e1da;
    border-radius: 7px;
    font: inherit;
}

.search-submit {
    padding: 13px 18px;
    background: #245747;
    color: white;
    border: 0;
    border-radius: 7px;
    font-weight: bold;
    cursor: pointer;
}

.search-submit:hover {
    background: #183f32;
}

.reset-search {
    display: inline-block;
    padding: 12px 5px;
    color: #245747;
    font-size: 13px;
    text-align: center;
}

.search-error {
    margin-top: 14px;
    color: #a42e25;
    font-size: 13px;
}

@media (max-width: 760px) {
    .availability-search {
        width: 92%;
    }

    .search-grid {
        grid-template-columns: 1fr 1fr;
    }

    .search-submit,
    .reset-search {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .search-grid {
        grid-template-columns: 1fr;
    }
}
    </style>
</head>

<body>
    <header>
        <div class="brand">STAYORA<span>.</span></div>
    </header>

    <section class="hero">
        <div>
            <h1>Temukan kenyamanan untuk setiap perjalanan.</h1>

            <p>
                Pilih kamar hotel yang sesuai dengan kebutuhan Anda
                dan nikmati pengalaman menginap yang nyaman.
            </p>
        </div>
    </section>

    <section class="availability-search">
    <form
        action="{{ route('home') }}"
        method="GET"
        class="search-grid"
    >
        <div class="search-field">
            <label for="check_in">Tanggal Check-in</label>

            <input
                type="date"
                id="check_in"
                name="check_in"
                min="{{ now()->toDateString() }}"
                value="{{ old('check_in', request('check_in')) }}"
                required
            >
        </div>

        <div class="search-field">
            <label for="check_out">Tanggal Check-out</label>

            <input
                type="date"
                id="check_out"
                name="check_out"
                min="{{ now()->addDay()->toDateString() }}"
                value="{{ old('check_out', request('check_out')) }}"
                required
            >
        </div>

        <button type="submit" class="search-submit">
            Cari Kamar
        </button>

        <a href="{{ route('home') }}" class="reset-search">
            Reset
        </a>
    </form>

    @if ($errors->has('check_in') || $errors->has('check_out'))
        <div class="search-error">
            {{ $errors->first('check_in') ?: $errors->first('check_out') }}
        </div>
    @endif
</section>
    <main>
        <div class="section-heading">
            <h2>Pilihan Kamar</h2>
            <p>
                Jelajahi kamar kami dan temukan tempat istirahat
                yang tepat untuk Anda.
            </p>
        </div>

        <div class="rooms">
            @forelse ($roomTypes as $type)
                <article class="card">
                    <img
                        src="{{ $type->image ?: 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1000&q=80' }}"
                        alt="{{ $type->name }}"
                    >

                    <div class="card-content">
                        @if ($type->available_rooms_count > 0)
                            <span class="status">
                                {{ $type->available_rooms_count }} kamar tersedia
                            </span>
                        @else
                            <span class="status none">
                                Belum tersedia
                            </span>
                        @endif

                        <h3>{{ $type->name }}</h3>

                        <p class="description">
                            {{ $type->description }}
                        </p>

                        <p>
                            Kapasitas: {{ $type->capacity }} orang
                        </p>

                        <div class="amenities">
                            @forelse (array_slice($type->amenities ?? [], 0, 4) as $amenity)
                                <span class="amenity">{{ $amenity }}</span>
                            @empty
                                <span class="amenity">Fasilitas standar</span>
                            @endforelse
                        </div>

                        <div class="price">
                            Rp{{ number_format((float) $type->price_per_night, 0, ',', '.') }}
                        <small>/ malam</small>
                        </div>
                        @if ($type->available_rooms_count > 0)
    <a
        class="book-btn"
        href="{{ route('bookings.create', array_filter([
            'roomType' => $type->id,
            'check_in' => request('check_in'),
            'check_out' => request('check_out'),
        ], fn ($value) => $value !== null && $value !== '')) }}"
    >
        Pesan Kamar
    </a>
@else
    <span class="unavailable">
        {{ $hasDates ? 'Tidak tersedia pada tanggal tersebut' : 'Tidak tersedia' }}
    </span>
@endif
                    </div>
                </article>
            @empty
                <div class="empty">
                    <h3>Belum ada tipe kamar</h3>
                    <p>Tambahkan data kamar ke database untuk menampilkannya.</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} Stayora Hotel — Sistem Pemesanan Hotel
    </footer>

    <script>
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');

    function updateCheckoutMinimum() {
        if (!checkInInput.value) return;

        const date = new Date(checkInInput.value + 'T00:00:00');
        date.setDate(date.getDate() + 1);

        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');

        const minimumDate = `${year}-${month}-${day}`;

        checkOutInput.min = minimumDate;

        if (
            checkOutInput.value &&
            checkOutInput.value < minimumDate
        ) {
            checkOutInput.value = '';
        }
    }

    checkInInput.addEventListener(
        'change',
        updateCheckoutMinimum
    );

    updateCheckoutMinimum();
</script>
</body>
</html>
