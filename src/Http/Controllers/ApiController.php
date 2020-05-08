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
        return response()->json(Tab::query()->orderBy('order')->get(['_id', 'logo', 'name']));
    }

    public function bookings(string $tabId) {
        return response()->json(
            Booking::query()->where('tab_id', '=', $tabId)->orderBy('order')->get(['_id', 'name', 'is_default'])
        );
    }

    public function allBookings(string $tabId = null) {

        $tabs     = Tab::query()->orderBy('order')->get();
        $bookings = [];
        
        foreach ($tabs as $tab) {
            $bookings[] = Booking::query()
                ->where('tab_id', '=', $tab->_id)
                ->orderBy('order')
                ->get(['_id', 'name', 'is_default']);
        }

        return response()->json($bookings);
    }
}
