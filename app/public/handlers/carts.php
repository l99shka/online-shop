<?php
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

require_once "./views/carts.phtml";