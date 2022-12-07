<?php

namespace App\Models;

use mysqli;

class Model
{
    protected static $table;
    private static mysqli $conn;
    private static $query;

    protected static function connectToDB(): Model
    {
        self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (self::$conn->connect_error) {
            throw new \Exception(self::$conn->connect_error);
        }
        return new static();
    }

    protected function select(string $statement): Model
    {
        self::$query = $statement;
        return new static();
    }

    protected function get(): array
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

    protected function insert(string $statement)
    {
        self::$query = $statement;
        if (self::$conn->query(self::$query) === TRUE) {
            return self::$conn->insert_id;
        } else {
            throw new \Exception(self::$conn->error);
        }
    }

    protected function updateRow(string $statement): bool
    {
        self::$query = $statement;
        if (self::$conn->query(self::$query) === TRUE) {
            return true;
        } else {
            throw new \Exception(self::$conn->error);
        }
    }
}