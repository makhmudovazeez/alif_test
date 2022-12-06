<?php

namespace App\Router;

trait Engine
{
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function path()
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    public function getRequest()
    {

        switch ($this->method()) {
            case 'get':
                parse_str($_SERVER["QUERY_STRING"], $output);
                break;
            case 'post':
                if ($obj = json_decode(file_get_contents('php://input'))) {
                    return $obj;
                } else {
                    parse_str(file_get_contents('php://input'), $output);
                }
                break;
        }

        return (object) $output;
    }
}