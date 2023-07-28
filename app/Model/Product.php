<?php

namespace App\Model;

use PDO;

class Product
{
    public function getAll():array
    {
        require_once "../Model/Connect.php";
        return ConnectFactory::create()->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    }
}