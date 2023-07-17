<?php

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
