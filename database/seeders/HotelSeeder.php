<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $standard = RoomType::updateOrCreate(
            ['name' => 'Standard Room'],
            [
                'description' => 'Kamar nyaman untuk liburan atau perjalanan bisnis.',
                'price_per_night' => 350000,
                'capacity' => 2,
                'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=80',
                'amenities' => ['Wi-Fi', 'AC', 'TV', 'Air Mineral'],
                'is_active' => true,
            ]
        );

        $deluxe = RoomType::updateOrCreate(
            ['name' => 'Deluxe Room'],
            [
                'description' => 'Kamar lebih luas dengan fasilitas untuk kenyamanan ekstra.',
                'price_per_night' => 550000,
                'capacity' => 2,
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                'amenities' => ['Wi-Fi', 'AC', 'TV', 'Mini Bar'],
                'is_active' => true,
            ]
        );

        $suite = RoomType::updateOrCreate(
            ['name' => 'Suite Room'],
            [
                'description' => 'Kamar premium dengan ruang yang lebih lega.',
                'price_per_night' => 900000,
                'capacity' => 4,
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                'amenities' => ['Wi-Fi', 'AC', 'TV', 'Mini Bar', 'Ruang Santai'],
                'is_active' => true,
            ]
        );

        $rooms = [
            ['room_type_id' => $standard->id, 'room_number' => '101', 'floor' => 1],
            ['room_type_id' => $standard->id, 'room_number' => '102', 'floor' => 1],
            ['room_type_id' => $standard->id, 'room_number' => '103', 'floor' => 1],

            ['room_type_id' => $deluxe->id, 'room_number' => '201', 'floor' => 2],
            ['room_type_id' => $deluxe->id, 'room_number' => '202', 'floor' => 2],
            ['room_type_id' => $deluxe->id, 'room_number' => '203', 'floor' => 2],

            ['room_type_id' => $suite->id, 'room_number' => '301', 'floor' => 3],
            ['room_type_id' => $suite->id, 'room_number' => '302', 'floor' => 3],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                ['room_number' => $room['room_number']],
                [
                    'room_type_id' => $room['room_type_id'],
                    'floor' => $room['floor'],
                    'status' => 'available',
                ]
            );
        }
    }
}
