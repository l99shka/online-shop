<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
}

$profileEmail = $_SESSION['user_id']['email'];
$profileId = $_SESSION['user_id']['id'];

$conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
$products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

require_once "./views/main.phtml";

?>