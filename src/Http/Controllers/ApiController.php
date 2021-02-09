<?php

namespace Selene\Modules\BookingModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Selene\Modules\BookingModule\Models\Booking;
use Selene\Modules\BookingModule\Models\Tab;
use Selene\Modules\HotelModule\Models\Hotels;

/**
 * Class BookingController
 * @package Selene\Modules\BookingModule\Http\Controllers
 */
class ApiController extends Controller
{
    public function tabs(Request $request) {
        return response()->json(Tab::query()->orderBy('order')->get(['_id', 'logo', 'name', 'include_all_bookings']));
    }

    public function bookings(string $tabId) {
        return response()->json($this->getTabData($tabId));
    }

    public function allBookings(string $tabId = null) {
        $tabs     = Tab::query()->orderBy('order')->get();
        $bookings = new Collection();
        
        foreach ($tabs as $tab) {
            $tabData = $this->getTabData($tab->_id);

            foreach ($tabData as $tabItem) {
                $bookings->add($tabItem);
            }
        }

        return response()->json($bookings->toArray());
    }

    private function getTabData(string $tabId) {
        $bookings = Booking::query()
            ->where('tab_id', '=', $tabId)
            ->orderBy('order')
            ->get();

        $excluded = $this->getExcludedBookings($bookings->pluck('_id')->toArray());

        return $bookings->filter(function ($value, $key) use ($excluded) {
                return !in_array($value->_id, $excluded);
            })
            ->map(fn($value) => Arr::only($value->toArray(), ['_id', 'name', 'is_default']))
            ->values()
            ->all();
    }

    private function getExcludedBookings(array $bookingIds) {
        $excluded = [];
        foreach ($bookingIds as $bookingId) {
            $hotels = Hotels::query()
                ->where('booking', $bookingId)
                ->get();

            if ($hotels->count() === 1 && ($hotels[0]->toArray()['booking_disabled'] ?? false)) {
                $excluded[] = $bookingId;
            }
        }

        return $excluded;
    }
}
