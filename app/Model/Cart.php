<?php

namespace App\Model;

use PDO;

class Cart
{
    public function getDescription(int $userID):array
    {
        $stmt = ConnectFactory::create()->prepare("SELECT carts.product_id, products.name, carts.quantity, products.price * carts.quantity AS total_price
                                FROM products INNER JOIN carts ON carts.product_id = products.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userID]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct(int $userID, int $productID): void
    {
        $stmt = ConnectFactory::create()->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)
                                ON CONFLICT (user_id, product_id) DO UPDATE SET quantity = excluded.quantity + carts.quantity");

        $stmt->execute(['user_id' => $userID, 'product_id' => $productID]);

    }

    public function deleteAll(int $userID): void
    {
        $stmt = ConnectFactory::create()->prepare('DELETE FROM carts WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userID]);

    }

    public function deleteProduct(int $userID, int $productID): void
    {
        $stmt = ConnectFactory::create()->prepare('DELETE FROM carts WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userID, 'product_id' => $productID]);

    }
}