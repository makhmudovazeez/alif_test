<?php

namespace App\Models;

use Exception;

class Room extends Model
{
    protected static $table = 'rooms';

    public static function getAllRooms()
    {
        try {
            return self::connectToDB()->select("select * from " . self::$table)->get();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}