<?php

namespace App\Models;

use Exception;

class Booking extends Model
{
    protected static $table = "booking";

    public static function bookedRoom($request)
    {
        try {
            $select = "select * from " . self::$table . " where room_id = {$request->room_id}";

            $select .= " and (
                            (from_date BETWEEN '{$request->from_date}' and '{$request->to_date}')
                                or
                            (to_date BETWEEN '{$request->from_date}' and '{$request->to_date}')
                                or
                            (from_date <= '{$request->from_date}' and to_date >= '{$request->from_date}')
                                or
                            (to_date <= '{$request->to_date}' and to_date >= '{$request->to_date}')
                        )";
            return self::connectToDB()->select($select)->get();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}