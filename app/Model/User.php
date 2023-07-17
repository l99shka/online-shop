<?php

class User
{
    public function getUser():array
    {
        $email = $_POST['email'];

        require_once "../Model/Connect.php";
        $connect = new Connect();
        $conn = $connect->connect();

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function rememberUser()
    {
        require_once "../Model/Connect.php";
        $connect = new Connect();
        $conn = $connect->connect();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (:name, :email, :phone, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'password' => $password]);

    }
}
