<?php

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

    $errors = isValid($_POST, $conn);

    if (empty($errors)) {
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

function isValid(array $data, PDO $conn):array
{
    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $password = $data['password'];
    $psw = $data['psw'];
    $errors = [];

    if (!isset($name))
    {
        $errors['name'] = 'Name is required';
    } elseif (empty($name))
    {
        $errors['name'] = 'Имя не должно быть пустым';
    } elseif (strlen($name) <= 2 | strlen($name) >= 40)
    {
        $errors['name'] = 'Имя не может быть меньше 2 и больше 20 символов';
    }

    if (!isset($email))
    {
        $errors['email'] = 'Email is required';
    } elseif (empty($email))
    {
        $errors['email'] = 'E-mail не должен быть пустым';
    } elseif (strlen($email) <= 2 | strlen($email) >= 40)
    {
        $errors['email'] = 'E-mail не может быть меньше 2 и больше 40 символов';
    }

    if (!isset($phone))
    {
        $errors['phone'] = 'Phone is required';
    } elseif (empty($phone))
    {
        $errors['phone'] = 'Телефон не должен быть пустым';
    } elseif (strlen($phone) <= 2 | strlen($phone) >= 40)
    {
        $errors['phone'] = 'Телефон не может быть меньше 2 и больше 40 символов';
    }

    if (!isset($password))
    {
        $errors['password'] = 'Password is required';
    } elseif (empty($password))
    {
        $errors['password'] = 'Пароль не должен быть пустым';
    } elseif (strlen($password) <= 2 | strlen($password) >= 40)
    {
        $errors['password'] = 'Пароль не может быть меньше 2 и больше';
    }

    if (!isset($psw))
    {
        $errors['psw'] = 'Psw is required';
    } elseif (empty($psw))
    {
        $errors['psw'] = 'Пароль не должен быть пустым';
    } elseif ($psw !== $password)
    {
        $errors['psw'] = 'Пароли не совпадают';
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $userData = $stmt->fetch();

    if (!empty($userData))
    {
        $errors['email'] = 'Такой E-mail уже сущесвует';
    }

    return $errors;
}


?>

<form class="form" action="" method="POST">
    <h1>Регистрация</h1>
    <hr>
    <label><input class="input" type="text" placeholder="Ваше имя" name="name"></label>
    <label style="color: #4b1010"><?php if (isset($errors['name'])) {
            echo $errors['name'];
        } ?></label>
    <label><input class="input" type="email" placeholder="Ваш e-mail" name="email"></label>
    <label style="color: #4b1010"><?php if (isset($errors['email'])) {
            echo $errors['email'];
        } ?></label>
    <label><input class="input" type="tel" placeholder="Ваш телефон" name="phone"></label>
    <label style="color: #4b1010"><?php if (isset($errors['phone'])) {
            echo $errors['phone'];
        } ?></label>
    <label><input class="input" type="password" placeholder="Пароль" name="password"></label>
    <label style="color: #4b1010"><?php if (isset($errors['password'])) {
            echo $errors['password'];
        } ?></label>
    <label><input class="input" type="password" placeholder="Повторите пароль" name="psw"></label>
    <label style="color: #4b1010"><?php if (isset($errors['psw'])) {
            echo $errors['psw'];
        } ?></label>
    <label><button class="btn" type="submit">Регистрация</button></label>
</form>

<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 16px;
        color: #000;
        background-color: #46b7ae;
    }

    * {
        box-sizing: border-box;
    }

    .form {
        max-width: 320px;
        padding: 15px;
        margin: 20px auto;
        background-color: #b69e9e;
    }

    .input {
        display: block;
        width: 100%;
        padding: 8px 10px;
        margin-bottom: 10px;

        border: 1px solid #591e62;

        font-family: inherit;
        font-size: 16px;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 8px 10px;

        border: 0;
        background-color: #2a2621;
        cursor: pointer;

        font-family: inherit;
        font-size: 16px;
        color: #faf7f7;
    }

    .btn:hover {
        background-color: #14a20a;
    }
</style>
