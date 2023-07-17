<?php
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
