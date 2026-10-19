<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::withCount('rooms')
            ->orderBy('name')
            ->paginate(10);

        return view(
            'admin.room-types.index',
            compact('roomTypes')
        );
    }

    public function create()
    {
        $roomType = new RoomType([
            'is_active' => true,
        ]);

        return view(
            'admin.room-types.form',
            compact('roomType')
        );
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        RoomType::create($data);

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Tipe kamar berhasil ditambahkan.');
    }

    public function edit(RoomType $roomType)
    {
        return view(
            'admin.room-types.form',
            compact('roomType')
        );
    }

    public function update(
        Request $request,
        RoomType $roomType
    ) {
        $data = $this->validatedData($request);

        $roomType->update($data);

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Tipe kamar berhasil diperbarui.');
    }

    public function destroy(RoomType $roomType)
    {
        // Nonaktifkan, bukan menghapus data secara permanen.
        $roomType->update([
            'is_active' => false,
        ]);

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Tipe kamar berhasil dinonaktifkan.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'price_per_night' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],
            'image' => [
                'nullable',
                'url',
                'max:2048',
            ],
            'amenities_text' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $amenitiesText = $data['amenities_text'] ?? '';

        unset($data['amenities_text']);

        $amenities = preg_split('/[\r\n,]+/', $amenitiesText);

        $data['amenities'] = array_values(
            array_unique(
                array_filter(
                    array_map('trim', $amenities)
                )
            )
        );

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
