<?php

$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/') {
    require_once '../Controller/MainController.php';
    $main = new MainController();
    $main->description();
} elseif ($requestUri === '/signup') {
    require_once '../Controller/UserController.php';
    $user = new UserController();
    $user->signup();
} elseif ($requestUri === '/login') {
    require_once '../Controller/UserController.php';
    $user = new UserController();
    $user->login();
} elseif ($requestUri === '/main') {
    require_once '../Controller/MainController.php';
    $main = new MainController();
    $main->description();
} elseif ($requestUri === '/logout') {
    require_once '../Controller/UserController.php';
    $user = new UserController();
    $user->logout();
} elseif ($requestUri === '/add-product') {
    require_once '../Controller/CartsController.php';
    $carts = new CartsController();
    $carts->addProducts();
} elseif ($requestUri === '/carts') {
    require_once '../Controller/CartsController.php';
    $carts = new CartsController();
    $carts->description();
} elseif ($requestUri === '/delete') {
    require_once '../Controller/CartsController.php';
    $carts = new CartsController();
    $carts->deleteProducts();
} elseif ($requestUri === '/delete-carts') {
    require_once '../Controller/CartsController.php';
    $carts = new CartsController();
    $carts->deleteAll();
} else {
    require_once '../View/notFound.html';
}