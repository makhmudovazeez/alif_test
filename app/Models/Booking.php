<?php

namespace App\Models;

use Exception;

class Booking extends Model
{
    protected static $table = "booking";

    public static function bookedRoom($request): array
    {
        try {
            $sql = "select * from " . self::$table . " where room_id = {$request->room_id}";

            $sql .= " and (
                            (from_date BETWEEN '{$request->from_date}' and '{$request->to_date}')
                                or
                            (to_date BETWEEN '{$request->from_date}' and '{$request->to_date}')
                                or
                            (from_date <= '{$request->from_date}' and to_date >= '{$request->from_date}')
                                or
                            (to_date <= '{$request->to_date}' and to_date >= '{$request->to_date}')
                        )";
            return self::connectToDB()->select($sql)->get();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public static function create(array $data)
    {
        try {
            $sql = "insert into " . self::$table . "(room_id, full_name, email, from_date, to_date, emailed) values ($data[room_id], '$data[full_name]', '$data[email]', '$data[from_date]', '$data[to_date]', false)";
            $id = self::connectToDB()->insert($sql);
            return self::getById($id);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function update(): bool
    {
        try {
            if (!isset($this->id)) {
                throw new Exception("object is empty");
            }
            $sql = "update " . self::$table . " set emailed = true where id = {$this->id}";
            return self::connectToDB()->updateRow($sql);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public static function getById(int $id)
    {
        try {
            $sql = "select * from " . self::$table . " where id = $id";
            $bookArray = self::connectToDB()->select($sql)->get();
            if (count($bookArray) > 0) {
                return $bookArray[0];
            }
            return null;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}