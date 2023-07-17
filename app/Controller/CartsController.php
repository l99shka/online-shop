<?php

class CartsController
{
    public function carts()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }

        $profileName = $_SESSION['user_id']['name'];

        require_once "../Model/Cart.php";
        $carts = new Cart();
        $result = $carts->getDescription();

        $sumPrice = 'ИТОГО: ' . array_sum(array_column($result, 'total_price')) . ' руб.';

        require_once "../View/carts.phtml";
    }

    public function addProduct()
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
            $carts->remember();
        }
    }

    public function deleteCarts()
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
            $carts->delete();

        }
    }

    public function deleteProduct()
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
            $carts->deleteProduct();

        }
    }
}