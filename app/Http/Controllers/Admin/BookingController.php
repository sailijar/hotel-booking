<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Booking::count(),

            'pending' => Booking::where(
                'status',
                'pending'
            )->count(),

            'confirmed' => Booking::where(
                'status',
                'confirmed'
            )->count(),

            'cancelled' => Booking::where(
                'status',
                'cancelled'
            )->count(),

            'confirmed_value' => Booking::where(
                'status',
                'confirmed'
            )->sum('total_price'),
        ];

        $bookings = Booking::with([
            'user',
            'room.roomType',
            'payments',
        ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.bookings.index',
            compact('stats', 'bookings')
        );
    }

    public function updateStatus(
        Request $request,
        Booking $booking
    ) {
        $data = $request->validate([
            'status' => [
                'required',
                Rule::in(['confirmed', 'cancelled']),
            ],
        ]);

        DB::transaction(function () use ($booking, $data) {
            $current = Booking::whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($data['status'] === 'confirmed') {
                $roomAvailable = Room::whereKey($current->room_id)
                    ->where('status', 'available')
                    ->exists();

                if (! $roomAvailable) {
                    throw ValidationException::withMessages([
                        'status' => 'Kamar ini tidak tersedia.',
                    ]);
                }

                $conflict = Booking::query()
                    ->where('room_id', $current->room_id)
                    ->where('id', '!=', $current->id)
                    ->whereIn('status', [
                        'pending',
                        'confirmed',
                    ])
                    ->where(
                        'check_in',
                        '<',
                        $current->check_out
                    )
                    ->where(
                        'check_out',
                        '>',
                        $current->check_in
                    )
                    ->exists();

                if ($conflict) {
                    throw ValidationException::withMessages([
                        'status' => 'Ada reservasi lain pada tanggal yang bertabrakan. Batalkan atau selesaikan reservasi tersebut terlebih dahulu.',
                    ]);
                }
            }

            $current->status = $data['status'];
            $current->save();
        });

        return redirect()
            ->route('admin.bookings.index')
            ->with(
                'success',
                'Status reservasi berhasil diperbarui.'
            );
    }
}
