<?php

namespace App\Model;

use PDO;

class Product
{
    public static function getAll():array
    {
        return ConnectFactory::create()->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

    }
}