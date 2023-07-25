<?php

namespace App\Controller;

use App\Model\Product;
class MainController
{
    private Product $product;
    public function __construct()
    {
        $this->product = new Product;
    }
    public function description(): array
    {
        $profileEmail = [];

        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $profileEmail = $_SESSION['user_id']['email'];
        }

        $products = $this->product->getAll();

        return [
            'view' => 'main',
            'data' => [
                'products' => $products,
                'profileEmail' => $profileEmail
            ]
        ];
    }
}