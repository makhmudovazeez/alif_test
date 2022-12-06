<?php

namespace App\Controllers;

use App\Models\Booking;

class BookingController
{
    public function getBookedRoom(object $request)
    {
        if (
            !$request->room_id
            ||
            $request->room_id == 'null'
            ||
            !$request->from_date
            ||
            $request->from_date == 'null'
            ||
            !$request->to_date
            ||
            $request->to_date == 'null'
        ) {
            return json_encode([
                'error' => 'room_id, from_date, to_date required'
            ]);
        }
        $bookings = Booking::bookedRoom($request);
        return json_encode($bookings);
    }
}