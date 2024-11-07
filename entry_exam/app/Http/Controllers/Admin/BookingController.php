<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index()
    {
        $query = Booking::query();

        if (request('customer_name')) {
            $query->where('customer_name', 'like', '%' . request('customer_name') . '%');
        }
        if (request('hotel_name')) {
            $hotels = Hotel::query()->where('hotel_name', 'LIKE', '%' . request('hotel_name') . '%')->get();
            $query->whereIn('hotel_id', $hotels->pluck('hotel_id'))->get();
        }

        $data = $query->orderBy('booking_id', 'desc')->paginate(getAdminPagination());

        $viewData = [
            'data' => $data,
        ];

        return view('admin.booking.index', $viewData);
    }
}
