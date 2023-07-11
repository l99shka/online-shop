<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
} else {
    header('Location: /main');
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];

    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id) VALUES (:user_id, :product_id)");
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);

}
