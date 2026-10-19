<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class BookingController extends Controller
{
    public function create(RoomType $roomType)
    {
        abort_unless($roomType->is_active, 404);

        return view('bookings.create', compact('roomType'));
    }

    public function store(Request $request, RoomType $roomType)
    {
        abort_unless($roomType->is_active, 404);

        $data = $request->validate([
            'check_in' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'check_out' => [
                'required',
                'date',
                'after:check_in',
            ],
            'guests' => [
                'required',
                'integer',
                'min:1',
                'max:' . $roomType->capacity,
            ],
            'guest_name' => [
                'required',
                'string',
                'max:255',
            ],
            'guest_email' => [
                'required',
                'email',
                'max:255',
            ],
            'guest_phone' => [
                'required',
                'string',
                'max:30',
            ],
            'special_requests' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $booking = DB::transaction(function () use (
            $data,
            $roomType
        ) {
            // Cari kamar dengan tipe yang dipilih dan
            // pastikan tanggalnya tidak bertabrakan.
            $room = Room::query()
                ->where('room_type_id', $roomType->id)
                ->where('status', 'available')
                ->whereDoesntHave('bookings', function ($query) use ($data) {
                    $query
                        ->whereIn('status', ['pending', 'confirmed'])
                        ->where('check_in', '<', $data['check_out'])
                        ->where('check_out', '>', $data['check_in']);
                })
                ->orderBy('room_number')
                ->lockForUpdate()
                ->first();

            // Tidak ada kamar yang cocok dengan tanggal.
            if (! $room) {
                return null;
            }

            $nights = (int) Carbon::parse($data['check_in'])
                ->diffInDays(Carbon::parse($data['check_out']));

            $totalPrice = round(
                (float) $roomType->price_per_night * $nights,
                2
            );

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'room_id' => $room->id,
                'booking_code' => 'HTL-' .
                    now()->format('Ymd') . '-' .
                    Str::upper(Str::random(6)),
                'guest_name' => $data['guest_name'],
                'guest_email' => $data['guest_email'],
                'guest_phone' => $data['guest_phone'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'guests' => $data['guests'],
                'total_price' => $totalPrice,
                'status' => 'pending',
                'special_requests' =>
                    $data['special_requests'] ?? null,
            ]);

            // Buat catatan pembayaran awal.
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $totalPrice,
                'payment_method' => 'manual',
                'status' => 'pending',
            ]);

            return $booking;
        });

        if (! $booking) {
            return back()
                ->withInput()
                ->withErrors([
                    'check_in' =>
                        'Maaf, kamar untuk tipe ini tidak tersedia pada tanggal tersebut. Silakan pilih tanggal lain.',
                ]);
        }

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Reservasi berhasil dibuat. Kode booking: ' . $booking->booking_code);
    }

    public function index()
    {
    $user = User::findOrFail(Auth::id());

    $bookings = $user->bookings()
        ->with(['room.roomType', 'payments'])
        ->latest()
        ->get();

    return view('bookings.index', compact('bookings'));
    }
}
