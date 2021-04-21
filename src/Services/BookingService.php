<?php

namespace Selene\Modules\BookingModule\Services;

use Selene\Modules\BookingModule\Models\Booking;

class BookingService
{
    private Booking $booking;

    private array $request;

    public function __construct(Booking $booking, array $request)
    {
        $this->booking = $booking;
        $this->request = $request;
    }

    public function getLink()
    {
        $tab = $this->booking->getTab();
        if (!$tab) {
            return null;
        }
        $link = $this->booking->custom_link ? $this->booking->custom_link : $tab->link;
        $link = str_replace('%%code%%', $this->booking->code, $link);
        if (isset($this->request['booking_from'])) {
            $link = str_replace(
                ['%%from%%', '%%fromWithoutDashes%%'],
                [$this->request['booking_from'], str_replace('-', '', $this->request['booking_from'])],
                $link
            );
        }

        if (isset($this->request['booking_to'])) {
            $link = str_replace(
                ['%%to%%', '%%toWithoutDashes%%'],
                [$this->request['booking_to'], str_replace('-', '', $this->request['booking_to'])],
                $link
            );
        }

        if (isset($this->request['booking_nights'])) {
            $link = str_replace('%%nights%%', $this->request['booking_nights'], $link);
        }

        return $link;
    }
}
