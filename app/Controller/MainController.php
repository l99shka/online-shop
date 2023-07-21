<?php

class MainController
{
    public function description()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $profileEmail = $_SESSION['user_id']['email'];
        }

        require_once "../Model/Product.php";
        $product = new Product();
        $products = $product->getAll();

        require_once "../View/main.phtml";
    }
}