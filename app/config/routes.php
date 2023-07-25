<?php

use App\Controller\MainController;
use App\Controller\UserController;
use App\Controller\CartsController;

return [
    '/' => [MainController::class, 'description'],
    '/signup' => [UserController::class, 'signup'],
    '/login' => [UserController::class, 'login'],
    '/main' => [MainController::class, 'description'],
    '/logout' => [UserController::class, 'logout'],
    '/add-product' => [CartsController::class, 'addProduct'],
    '/carts' => [CartsController::class, 'getDescription'],
    '/delete' => [CartsController::class, 'deleteProduct'],
    '/delete-carts' => [CartsController::class, 'deleteAll']
];