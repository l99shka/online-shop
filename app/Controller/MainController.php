<?php

class MainController
{
    public function main()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }

        $profileEmail = $_SESSION['user_id']['email'];

        require_once "../Model/Product.php";
        $product = new Product();
        $products = $product->getProduct();

        require_once "../View/main.phtml";
    }
}