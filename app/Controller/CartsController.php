<?php

namespace App\Controller;

use App\Model\Cart;

class CartsController
{
    private Cart $carts;
    public function __construct()
    {
        $this->carts = new Cart;
    }
    public function getDescription(): array
    {
        $profileName = [];

        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $profileName = $_SESSION['user_id']['name'];
        }

        $result = $this->carts->getDescription($_SESSION['user_id']['id']);

        $sumPrice = 'ИТОГО: ' . array_sum(array_column($result, 'total_price')) . ' руб.';

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
            $this->carts->addProduct($_SESSION['user_id']['id'], $_POST['product_id']);
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
            $this->carts->deleteAll($_SESSION['user_id']['id']);
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
            $this->carts->deleteProduct($_SESSION['user_id']['id'], $_POST['product_id']);
        }
    }
}