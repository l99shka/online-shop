<?php
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/signup')
{
    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

        $errors = isValidSignUp($_POST, $conn);

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

    require_once './views/signup.html';
} elseif ($requestUri === '/login')
{
    if ($_SERVER['REQUEST_METHOD'] === "POST")
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

        $errors = isValidLogin($_POST, $conn);


        if (empty($errors)) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);

            $userData = $stmt->fetch();

            $user = 1;

        if (!empty($userData) && (password_verify($password, $userData['password'])))
         {
            session_start();
            $_SESSION['id'] = $user;
         }
        }
    }

    require_once './views/login.html';
} elseif ($requestUri === '/main')
{
    session_start();
    echo $_SESSION['id'];
} else {
    echo 'NOT FOUND';
}
function isValidSignUp(array $data, PDO $conn):array
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
        $errors['name'] = '*Ввведите Имя';
    } elseif (strlen($name) < 2 || strlen($name) > 40)
    {
        $errors['name'] = '*Имя не может быть меньше 2 и больше 20 символов';
    }

    if (!isset($email))
    {
        $errors['email'] = 'Email is required';
    } elseif (empty($email))
    {
        $errors['email'] = '*Ввведите E-mail';
    } elseif (strlen($email) < 2 || strlen($email) > 40)
    {
        $errors['email'] = '*E-mail не может быть меньше 2 и больше 40 символов';
    }

    if (!isset($phone))
    {
        $errors['phone'] = 'Phone is required';
    } elseif (empty($phone))
    {
        $errors['phone'] = '*Введите телефон';
    } elseif (strlen($phone) < 2 || strlen($phone) > 40)
    {
        $errors['phone'] = '*Телефон не может быть меньше 2 и больше 40 символов';
    }

    if (!isset($password))
    {
        $errors['password'] = 'Password is required';
    } elseif (empty($password))
    {
        $errors['password'] = '*Введите пароль';
    } elseif (strlen($password) < 2 || strlen($password) > 40)
    {
        $errors['password'] = '*Пароль не может быть меньше 2 и больше 40';
    }

    if (!isset($psw))
    {
        $errors['psw'] = 'Psw is required';
    } elseif (empty($psw))
    {
        $errors['psw'] = '*Повторите пароль';
    } elseif ($psw !== $password)
    {
        $errors['psw'] = '*Пароли не совпадают';
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
function isValidLogin(array $data, PDO $conn):array
{
    $email = $data['email'];
    $password = $data['password'];
    $errors = [];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $userData = $stmt->fetch();

    if (!isset($email))
    {
        $errors['email'] = 'Email is required';
    } elseif (empty($email))
    {
        $errors['email'] = '*Ввведите E-mail';
    } elseif (strlen($email) < 2 || strlen($email) > 40)
    {
        $errors['email'] = '*E-mail не может быть меньше 2 и больше 40 символов';
    } elseif (empty($userData))
    {
        $errors['email'] = '*Неверный E-mail';
    }

    if (!isset($password))
    {
        $errors['password'] = 'Password is required';
    } elseif (empty($password))
    {
        $errors['password'] = '*Введите пароль';
    } elseif (!password_verify($password, $userData['password']))
    {
        $errors['password'] = '*Неверный пароль';
    }

    return $errors;
}



