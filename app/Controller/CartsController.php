<?php

namespace App\Controller;

use App\Model\Cart;

class CartsController
{
    public function getDescription(): array
    {
        $profileName = [];

        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $profileName = $_SESSION['user_id']['name'];
        }

        $result = Cart::getDescription($_SESSION['user_id']['id']);

        $sumPrice = array_sum(array_column($result, 'total_price'));

        return [
            'view' => 'carts',
            'data' => [
                'result' => $result,
                'profileName' => $profileName,
                'sumPrice' => $sumPrice
            ]
        ];
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

            $product = new Cart($_SESSION['user_id']['id']);
            $product->setQuantity(1);
            $product->setProductID($_POST['product_id']);

            $product->save();
        }
    }

    public function delete(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            header('Location: /carts');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $products = new Cart($_SESSION['user_id']['id']);

            $products->delete();
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
            $product = new Cart($_SESSION['user_id']['id']);
            $product->setProductID($_POST['product_id']);

            $product->deleteProduct();
        }
    }
}