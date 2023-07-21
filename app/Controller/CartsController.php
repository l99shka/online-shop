<?php

class CartsController
{
    public function description(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $profileName = $_SESSION['user_id']['name'];
        }

        require_once "../Model/Cart.php";
        $carts = new Cart();
        $result = $carts->getDescription($_SESSION['user_id']['id']);

        $sumPrice = 'ИТОГО: ' . array_sum(array_column($result, 'total_price')) . ' руб.';

        require_once "../View/carts.phtml";
    }

    public function addProducts(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            header('Location: /main');
        }


        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            require_once "../Model/Cart.php";
            $carts = new Cart();
            $carts->addProducts($_SESSION['user_id']['id'], $_POST['product_id']);
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

            require_once "../Model/Cart.php";
            $carts = new Cart();
            $carts->deleteAll($_SESSION['user_id']['id']);

        }
    }

    public function deleteProducts(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            header('Location: /carts');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            require_once "../Model/Cart.php";
            $carts = new Cart();
            $carts->deleteProducts($_SESSION['user_id']['id'], $_POST['product_id']);

        }
    }
}