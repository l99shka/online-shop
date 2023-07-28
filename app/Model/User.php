<?php

namespace App\Model;

class User
{
    private static int $id;
    private string $name;
    private string $email;
    private string $phone;
    private string $password;
    public function __construct(string $name, string $email, string $phone, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
    }
    public static function getUserEmail(string $email):User|null
    {
        require_once "../Model/Connect.php";
        $stmt = ConnectFactory::create()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();

        self::$id = $data['id'];

        if (!$data) {
            return null;
        }

        return new User($data['name'], $data['email'], $data['phone'], $data['password']);
    }

    public function save(): void
    {
        require_once "../Model/Connect.php";
        $stmt = ConnectFactory::create()->prepare("INSERT INTO users (name, email, phone, password) VALUES (:name, :email, :phone, :password)");
        $stmt->execute(['name' => $this->name, 'email' => $this->email, 'phone' => $this->phone, 'password' => $this->password]);

    }

//    public function setId(int $id): int
//    {
//       return $this->id = $id;
//    }

    public function getId():int
    {
        return self::$id;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getEmail():string
    {
        return $this->email;
    }

    public function getPassword():string
    {
        return $this->password;
    }
}
