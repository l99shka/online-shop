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

        $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

        $userID = $_SESSION['user_id']['id'];

        $stmt = $conn->prepare("SELECT carts.product_id, products.name, carts.quantity, products.price * carts.quantity AS total_price
FROM products INNER JOIN carts ON carts.product_id = products.id WHERE user_id = :user_id");

        $stmt->execute(['user_id' => $userID]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

            $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

            $user_id = $_SESSION['user_id']['id'];
            $product_id = $_POST['product_id'];

            $stmt = $conn->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)
                                      ON CONFLICT (user_id, product_id) DO UPDATE SET quantity = excluded.quantity + carts.quantity");

            $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
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

            $userID = $_SESSION['user_id']['id'];

            $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

            $stmt = $conn->prepare('DELETE FROM carts WHERE user_id = :user_id');
            $stmt->execute(['user_id' => $userID]);

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

            $userID = $_SESSION['user_id']['id'];
            $product_id = $_POST['product_id'];


            $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

            $stmt = $conn->prepare('DELETE FROM carts WHERE user_id = :user_id AND product_id = :product_id');
            $stmt->execute(['user_id' => $userID, 'product_id' => $product_id]);

        }
    }
}