<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $errors = isValidLogin($_POST);

    if (empty($errors)) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $userData = $stmt->fetch();

        if (!empty($userData) && password_verify($password, $userData['password'])) {

            session_start();

            $_SESSION['user_id'] = ['id' => $userData['id'], 'email' => $userData['email']];
            header('Location: /main');
        } else {
            $errorsLogin['errors'] = '* Неверный логин или пароль';
        }
    }
}
function isValidLogin(array $data):array
{
    $errors = [];

    if (!isset($data['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (empty($data['email'])) {
        $errors['email'] = '* Ввведите E-mail';
    }



    if (!isset($data['password'])) {
        $errors['password'] = 'Password is required';
    } elseif (empty($data['password'])) {
        $errors['password'] = '* Введите пароль';
    }


    return $errors;
}

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: /main');
}

require_once "./views/login.phtml";