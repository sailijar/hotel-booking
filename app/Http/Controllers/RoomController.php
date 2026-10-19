<?php

namespace App\Http\Controllers;

use App\Models\RoomType;

class RoomController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::query()
            ->where('is_active', true)
            ->withCount([
                'rooms as available_rooms_count' => function ($query) {
                    $query->where('status', 'available');
                }
            ])
            ->orderBy('price_per_night')
            ->get();

        return view('rooms.index', compact('roomTypes'));
    }
}
