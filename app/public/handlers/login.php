<?php

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    $errors = isValidLogin($_POST);

    if (empty($errors)) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $userData = $stmt->fetch();

        if (!empty($userData) && (password_verify($password, $userData['password']) == 1))
        {
            session_start();

            $_SESSION['user'] = ['email' => $userData['email']];
            header('Location: /main');
        } else {
            $errorsLogin['errors'] = '* Неверный логин или пароль';
        }
    }
}

require_once "./views/login.phtml";

function isValidLogin(array $data):array
{
    $errors = [];

    if (!isset($data['email']))
    {
        $errors['email'] = 'Email is required';
    }

    $email = $data['email'];
    if (empty($email))
    {
        $errors['email'] = '*Ввведите E-mail';
    }


    if (!isset($data['password']))
    {
        $errors['password'] = 'Password is required';
    }

    $password = $data['password'];
    if (empty($password))
    {
        $errors['password'] = '*Введите пароль';
    }

    return $errors;
}