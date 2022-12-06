<?php

namespace App\Controllers;

use App\Models\Room;

class RoomController
{
    public function getRooms(object $request)
    {
        $rooms = Room::getAllRooms();
        return json_encode($rooms);
    }
}