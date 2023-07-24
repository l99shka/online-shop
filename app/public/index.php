<?php

spl_autoload_register(function($class) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    $appRoot = dirname(__DIR__);
    $path = preg_replace('#^App#', $appRoot, $path);

    if (file_exists($path)) {
        require_once $path;
        return true;
    }

    return false;
});

$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/') {
    $main = new App\Controller\MainController();
    $main->description();
} elseif ($requestUri === '/signup') {
    $user = new App\Controller\UserController();
    $user->signup();
} elseif ($requestUri === '/login') {
    $user = new App\Controller\UserController();
    $user->login();
} elseif ($requestUri === '/main') {

    $main = new App\Controller\MainController();
    $main->description();
} elseif ($requestUri === '/logout') {
    $user = new App\Controller\UserController();
    $user->logout();
} elseif ($requestUri === '/add-product') {
    $carts = new App\Controller\CartsController();
    $carts->addProduct();
} elseif ($requestUri === '/carts') {
    $carts = new App\Controller\CartsController();
    $carts->getDescription();
} elseif ($requestUri === '/delete') {
    $carts = new App\Controller\CartsController();
    $carts->deleteProduct();
} elseif ($requestUri === '/delete-carts') {
    $carts = new App\Controller\CartsController();
    $carts->deleteAll();
} else {
    require_once '../View/notFound.html';
}