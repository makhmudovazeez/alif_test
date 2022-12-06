<?php

namespace App\Controllers;

use App\View;

class MainController
{
    public function index(object $request) {
        return (new View('index'))->render();
    }
}