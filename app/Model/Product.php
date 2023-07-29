<?php

namespace App\Model;

use PDO;

class Product
{
    private int $id;
    private string $name;
    private int $price;
    private string $description;
    private string $image_url;

    public function __construct(int $id, string $name, int $price, string $description, string $image_url)
    {

        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->image_url = $image_url;
    }
    public static function getAll():array
    {
        $stmt = ConnectFactory::create()->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
        $res = [];

        foreach ($stmt as $products)
        {

            $res[] = new Product($products['id'], $products['name'], $products['price'], $products['description'], $products['image_url']);
        }

        return $res;

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }
}