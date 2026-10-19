<?php

namespace App\Http\Controllers\Admin;

use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'check_in' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],
            'check_out' => [
                'nullable',
                'date',
                'after:check_in',
            ],
        ]);

        $checkIn = $filters['check_in'] ?? null;
        $checkOut = $filters['check_out'] ?? null;

        if (($checkIn && ! $checkOut) || (! $checkIn && $checkOut)) {
            return redirect()
                ->route('home')
                ->withErrors([
                    'check_in' =>
                        'Silakan pilih tanggal check-in dan check-out.',
                ])
                ->withInput();
        }

        $hasDates = $checkIn !== null && $checkOut !== null;

        $roomTypes = RoomType::query()
            ->where('is_active', true)
            ->withCount([
                'rooms as available_rooms_count' =>
                    function ($query) use (
                        $hasDates,
                        $checkIn,
                        $checkOut
                    ) {
                        $query->where('status', 'available');

                        if ($hasDates) {
                            $query->whereDoesntHave(
                                'bookings',
                                function ($bookingQuery) use (
                                    $checkIn,
                                    $checkOut
                                ) {
                                    $bookingQuery
                                        ->whereIn('status', [
                                            'pending',
                                            'confirmed',
                                        ])
                                        ->where(
                                            'check_in',
                                            '<',
                                            $checkOut
                                        )
                                        ->where(
                                            'check_out',
                                            '>',
                                            $checkIn
                                        );
                                }
                            );
                        }
                    }
            ])
            ->orderBy('price_per_night')
            ->get();

        return view('rooms.index', compact(
            'roomTypes',
            'checkIn',
            'checkOut',
            'hasDates'
        ));
    }
}
