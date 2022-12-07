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

    public static function getById(int $id)
    {
        try {
            $sql = "select * from " . self::$table . " where id = $id";
            $roomArray = self::connectToDB()->select($sql)->get();
            if (count($roomArray) > 0) {
                return $roomArray[0];
            }
            return null;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}