<?php

namespace App\Controller;

use App\Model\Cart;

class CartsController
{
    public function getDescription(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $profileName = $_SESSION['user_id']['name'];
        }

        $carts = new Cart();
        $result = $carts->getDescription($_SESSION['user_id']['id']);

        $sumPrice = 'ИТОГО: ' . array_sum(array_column($result, 'total_price')) . ' руб.';

        require_once "../View/carts.phtml";
    }

    public function addProduct(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            header('Location: /main');
        }


        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $carts = new Cart();
            $carts->addProduct($_SESSION['user_id']['id'], $_POST['product_id']);
        }
    }

    public function deleteAll(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            header('Location: /carts');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $carts = new Cart();
            $carts->deleteAll($_SESSION['user_id']['id']);

        }
    }

    public function deleteProduct(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            header('Location: /carts');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $carts = new Cart();
            $carts->deleteProduct($_SESSION['user_id']['id'], $_POST['product_id']);

        }
    }
}