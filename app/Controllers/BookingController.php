<?php

namespace App\Controllers;

use App\Mailer;
use App\Models\Booking;
use App\Models\Room;

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
            http_response_code(400);
            return json_encode([
                'error' => 'room_id, from_date, to_date required'
            ]);
        }

        try {
            $bookings = Booking::bookedRoom($request);
            return json_encode($bookings);
        } catch (\Exception $exception) {
            http_response_code(400);
            return json_encode([
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function bookRoom(object $request)
    {
        $error = [];
        if (strlen($request->email) <= 0 || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'required valid email';
        }

        if (strlen($request->full_name) <= 0) {
            $error['full_name'] = 'required full_name';
        }

        if (!is_int((int)$request->room_id)) {
            $error['room_id'] = 'required room_id';
        }

        if (!$request->from_date) {
            $error['from_date'] = 'required from_date';
        }

        if (!$request->to_date) {
            $error['to_date'] = 'required to_date';
        }

        if (count($error) > 0) {
            http_response_code(400);
            return json_encode($error);
        }

        try {
            $booking = Booking::create((array)$request);
            http_response_code(201);
            return json_encode($booking);
        } catch (\Exception $exception) {
            http_response_code(400);
            return json_encode([
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function sendEmail(object $request) {
        try {
            $booking = Booking::getById($request->id);
            if (!$booking) {
                throw new \Exception("no such booking exists");
            }

            $room = Room::getById($booking->room_id);
            if (!$room) {
                throw new \Exception("no such room exists");
            }

            if (Mailer::sendMail(
                $booking->email,
                "Booking `{$room->name}`",
                "Dear {$booking->full_name}.\nYou have rented a room `{$room->name}` from {$booking->from_date} to {$booking->to_date}.\n Thank you!"
            )) {
                $booking->update();
                return json_encode([
                    'message' => "{$booking->full_name} has been mailed!"
                ]);
            }
            return json_encode([
                'message' => "{$booking->full_name} can not be mailed!"
            ]);
        }catch (\Exception $exception) {
            http_response_code(400);
            return json_encode([
                'error' => $exception->getMessage()
            ]);
        }


    }
}