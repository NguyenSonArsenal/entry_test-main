<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Hotel;
use App\Models\Prefecture;

class HotelController extends Controller
{
    protected $hotel;
    protected $prefecture;

    public function __construct(
        Hotel $hotel,
        Prefecture $prefecture
    )
    {
        $this->hotel = $hotel;
        $this->prefecture = $prefecture;
    }

    public function showList(string $prefecture_name_alpha): View
    {
        // prefecture information
        $prefecture = $this->prefecture
            ->where('prefecture_name_alpha', $prefecture_name_alpha)
            ->first();

        // hotel information
        $hotels = $this->hotel
            ->where('prefecture_id', $prefecture->prefecture_id)
            ->orderby('hotel_id', 'desc')
            ->get();

        $viewData = [
            'prefecture' => $prefecture,
            'hotels' => $hotels,
        ];

        return view('user.hotellist', $viewData);
    }

    public function showDetail(int $hotel_id): View
    {
        $hotel = $this->hotel
            ->find($hotel_id);

        return view('user.hotel.detail', compact(
            'hotel'
        ));
    }
}
