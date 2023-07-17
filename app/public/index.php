<?php

$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/') {
    require_once './handlers/main.php';
} elseif ($requestUri === '/signup') {
    require_once './handlers/signup.php';
} elseif ($requestUri === '/login') {
    $login = new UserController();
    $login->login();
} elseif ($requestUri === '/main') {
    require_once './handlers/main.php';
} elseif ($requestUri === '/logout') {
    require_once './handlers/logout.php';
} elseif ($requestUri === '/add-product') {
    require_once './handlers/add-product.php';
} elseif ($requestUri === '/carts') {
    require_once './handlers/carts.php';
} elseif ($requestUri === '/delete') {
    require_once './handlers/delete-product.php';
} elseif ($requestUri === '/delete-carts') {
    require_once './handlers/delete-carts.php';
} else {
    require_once './views/notFound.html';
}