<?php

use App\Router\Route;

$app = new Route();

$app::get('/', 'MainController', 'index');
$app::get('/get-rooms', 'RoomController', 'getRooms');
$app::get('/get-booked-room', 'BookingController', 'getBookedRoom');
$app::post('/book-room', 'BookingController', 'bookRoom');
$app::post('/send-email', 'BookingController', 'sendEmail');

$app->run();