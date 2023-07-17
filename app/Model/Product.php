<?php

class Product
{
    public function getProduct():array
    {
        require_once "../Model/Connect.php";
        $connect = new Connect();
        $conn = $connect->connect();

        return $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    }
}