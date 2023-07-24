<?php

namespace App\Model;

use PDO;

class User
{
    private PDO $conn;
    public function __construct()
    {
        require_once "../Model/Connect.php";
        $this->conn = ConnectFactory::create();
    }
    public function getEmail(string $email):array|false
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function save(string $name, string $email, string $phone, string $password): void
    {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (:name, :email, :phone, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'password' => $password]);

    }
}
