<?php

class Cart
{
    public function getDescription():array
    {
        require_once "../Model/Connect.php";
        $connect = new Connect();
        $conn = $connect->connect();

        $userID = $_SESSION['user_id']['id'];

        $stmt = $conn->prepare("SELECT carts.product_id, products.name, carts.quantity, products.price * carts.quantity AS total_price
FROM products INNER JOIN carts ON carts.product_id = products.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userID]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function remember()
    {
        require_once "../Model/Connect.php";
        $connect = new Connect();
        $conn = $connect->connect();

        $user_id = $_SESSION['user_id']['id'];
        $product_id = $_POST['product_id'];

        $stmt = $conn->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)
                                      ON CONFLICT (user_id, product_id) DO UPDATE SET quantity = excluded.quantity + carts.quantity");

        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);

    }

    public function delete()
    {
        $userID = $_SESSION['user_id']['id'];

        require_once "../Model/Connect.php";
        $connect = new Connect();
        $conn = $connect->connect();

        $stmt = $conn->prepare('DELETE FROM carts WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userID]);

    }

    public function deleteProduct()
    {
        $userID = $_SESSION['user_id']['id'];
        $product_id = $_POST['product_id'];


        require_once "../Model/Connect.php";
        $connect = new Connect();
        $conn = $connect->connect();

        $stmt = $conn->prepare('DELETE FROM carts WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userID, 'product_id' => $product_id]);

    }
}