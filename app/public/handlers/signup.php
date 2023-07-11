<?php

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

    $errors = isValidSignUp($_POST, $conn);

    if (empty($errors)) {
        session_start();
        header('Location: /login');

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (:name, :email, :phone, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'password' => $password]);


        $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name AND email = :email");
        $stmt->execute(['name' => $name, 'email' => $email]);
        $res = $stmt->fetch();

        echo 'id ' . $res['id'] . "<br>";
        echo 'имя ' . $res['name'] . "<br>";
        echo 'email ' . $res['email'] . "<br>";
        echo 'телефон ' . $res['phone'] . "<br>";
        echo 'пароль ' . $res['password'];
    }
}
function isValidSignUp(array $data, PDO $conn):array
{
    $errors = [];

    if (!isset($data['name']))
    {
        $errors['name'] = 'Name is required';

    } elseif (empty($data['name']))
    {
        $errors['name'] = '* Ввведите Имя';

    } elseif (strlen($data['name']) < 2 || strlen($data['name']) > 40)
    {
        $errors['name'] = '* Имя не может быть меньше 2 и больше 20 символов';
    }



    if (!isset($data['email']))
    {
        $errors['email'] = 'Email is required';
    } elseif (empty($data['email']))
    {
        $errors['email'] = '* Ввведите E-mail';

    } elseif (strlen($data['email']) < 2 || strlen($data['email']) > 40)
    {
        $errors['email'] = '* E-mail не может быть меньше 2 и больше 40 символов';

    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $data['email']]);

        $userData = $stmt->fetch();

        if (!empty($userData))
        {
            $errors['email'] = '* Такой E-mail уже сущесвует';
        }
    }



    if (!isset($data['phone']))
    {
        $errors['phone'] = 'Phone is required';

    } elseif (empty($data['phone']))
    {
        $errors['phone'] = '* Введите телефон';

    } elseif (strlen($data['phone']) < 2 || strlen($data['phone']) > 40)
    {
        $errors['phone'] = '* Телефон не может быть меньше 2 и больше 40 символов';
    }



    if (!isset($data['password']))
    {
        $errors['password'] = 'Password is required';

    } elseif (empty($data['password']))
    {
        $errors['password'] = '* Введите пароль';

    } elseif (strlen($data['password']) < 2 || strlen($data['password']) > 40)
    {
        $errors['password'] = '* Пароль не может быть меньше 2 и больше 40';
    }



    if (!isset($data['psw']))
    {
        $errors['psw'] = 'Psw is required';

    } elseif (empty($data['psw']))
    {
        $errors['psw'] = '* Повторите пароль';

    } elseif ($data['psw'] !== $data['password'])
    {
        $errors['psw'] = '* Пароли не совпадают';
    }

    return $errors;
}

//session_start();
if (isset($_COOKIE['user'])) {
    header('Location: /main');
}

require_once './views/signup.phtml';