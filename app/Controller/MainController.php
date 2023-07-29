<?php

namespace App\Controller;

use App\Model\Product;
class MainController
{
    public function description(): array
    {
        $profileEmail = [];

        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $profileEmail = $_SESSION['user_id']['email'];
        }

        $products = Product::getAll();

        return [
            'view' => 'main',
            'data' => [
                'products' => $products,
                'profileEmail' => $profileEmail
            ]
        ];
    }
}