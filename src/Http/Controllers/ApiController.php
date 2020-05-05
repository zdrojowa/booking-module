<?php

namespace Selene\Modules\BookingModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Selene\Modules\BookingModule\Models\Booking;
use Selene\Modules\BookingModule\Models\Tab;

/**
 * Class BookingController
 * @package Selene\Modules\BookingModule\Http\Controllers
 */
class ApiController extends Controller
{
    public function tabs(Request $request) {
        return response()->json(Tab::query()->orderBy('order')->get());
    }

    public function bookings(string $tabId) {
        return response()->json(
            Booking::query()->where('tab_id', '=', $tabId)->orderBy('order')->get()
        );
    }
}
