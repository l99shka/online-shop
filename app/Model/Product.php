<?php

class Product
{
    private PDO $conn;
    public function __construct()
    {
        require_once "../Model/Connect.php";
        $this->conn = ConnectFactory::create();
    }
    public function getAll():array
    {
        return $this->conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    }
}