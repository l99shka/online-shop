<?php

namespace App\Controller;

use App\Model\Product;
class MainController
{
    public function description(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $profileEmail = $_SESSION['user_id']['email'];
        }

        $product = new Product();
        $products = $product->getAll();

        require_once "../View/main.phtml";
    }
}