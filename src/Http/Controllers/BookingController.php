<?php

namespace Selene\Modules\BookingModule\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Selene\Module\BookingModule\Services\BookingService;
use Selene\Modules\BookingModule\Http\Requests\StoreBookingItemRequest;
use Selene\Modules\BookingModule\Http\Requests\UpdateBookingItemRequest;
use Selene\Modules\BookingModule\Models\Booking;
use Selene\Modules\BookingModule\Models\Tab;
use Selene\Modules\DashboardModule\ZdrojowaTable;

/**
 * Class BookingController
 * @package Selene\Modules\BookingModule\Http\Controllers
 */
class BookingController extends Controller
{
    public function index()
    {
        return view('BookingModule::index');
    }

    public function ajax(Request $request)
    {
        return ZdrojowaTable::response(Booking::query(), $request);
    }

    public function add()
    {
        return view('BookingModule::edit', ['tabs' => Tab::all()]);
    }

    public function edit(Booking $booking)
    {
        return view('BookingModule::edit', ['booking' => $booking, 'tabs' => Tab::all()]);
    }

    public function store(StoreBookingItemRequest $request)
    {
        $booking = $this->save($request);
        if ($booking) {
            $request->session()->flash('alert-success', 'Pomyślnie dodano nowy booking');
            return redirect()->route('BookingModule::edit', ['booking' => $booking, 'tabs' => Tab::all()]);
        }

        $request->session()->flash('alert-error', 'Ooops. Try again.');
        return redirect()->back();
    }

    public function update(UpdateBookingItemRequest $request, Booking $booking)
    {
        if ($this->save($request)) {
            $request->session()->flash('alert-success', 'Pomyślnie zaktualizowano booking.');
        } else {
            $request->session()->flash('alert-error', 'Ooops. Try again.');
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param Booking|null $booking
     * @return bool|Booking
     */
    private function save(Request $request, Booking $booking = null)
    {
        $request->merge(['is_default' => $request->has('is_default')]);
        if ($booking === null) {
            return Booking::create($request->all());
        }
        return $booking->update($request->all());
    }

    public function destroy(Booking $booking, Request $request): void
    {
        try {
            $booking->delete();
            $request->session()->flash('alert-success', 'Booking is deleted');
        } catch (Exception $e) {
            $request->session()->flash('alert-error', 'Error: ' . $e->getMessage());
        }
    }

    public function redirectToBooking(Request $request): RedirectResponse
    {
        $bookingService = new BookingService(
            Tab::findOrFail($request->get('booking_tab')),
            Booking::findOrFail($request->get('booking_option')),
            $request->all()
        );

        $link = $bookingService->getLink();

        return Redirect::to($link);
    }
}
