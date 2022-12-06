<?php

namespace App\Models;

use mysqli;

class Model
{
    protected static $table;
    private static mysqli $conn;
    private static $query;

    protected static function connectToDB()
    {
        self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (self::$conn->connect_error) {
            return "Connection failed: " . self::$conn->connect_error;
        }
        return new static();
    }

    protected function select(string $statement)
    {
        self::$query = $statement;
        return new static();
    }

    protected function get()
    {
        $objects = [];

        $result = self::$conn->query(self::$query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $newObject = new $this();
                foreach ($row as $k => $r) {
                    $newObject->$k = $r;
                }
                $objects[] = $newObject;
            }
        }
        return $objects;
    }
}