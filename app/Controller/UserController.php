<?php

class UserController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = $this->isValidLogin($_POST);

            if (empty($errors)) {

                $password = $_POST['password'];

                require_once "../Model/User.php";
                $user = new User();
                $userData = $user->getUser();

                if (!empty($userData) && password_verify($password, $userData['password'])) {

                    session_start();

                    $_SESSION['user_id'] = ['id' => $userData['id'], 'email' => $userData['email'], 'name' => $userData['name']];
                    header('Location: /main');
                } else {
                    $errorsLogin['errors'] = '* Неверный логин или пароль';
                }
            }
        }

        session_start();

        if (isset($_SESSION['user_id'])) {
            header('Location: /main');
        }

        require_once "../View/login.phtml";
    }
        private function isValidLogin(array $data):array
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


    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = $this->isValidSignUp($_POST);

            if (empty($errors)) {

                session_start();
                header('Location: /login');

                require_once "../Model/User.php";
                $user = new User();
                $user->rememberUser();

//        $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name AND email = :email");
//        $stmt->execute(['name' => $name, 'email' => $email]);
//        $res = $stmt->fetch();
//
//        echo 'id ' . $res['id'] . "<br>";
//        echo 'имя ' . $res['name'] . "<br>";
//        echo 'email ' . $res['email'] . "<br>";
//        echo 'телефон ' . $res['phone'] . "<br>";
//        echo 'пароль ' . $res['password'];
            }
        }

        session_start();

        if (isset($_SESSION['user_id'])) {
            header('Location: /main');
        }

        require_once '../View/signup.phtml';
    }
        private function isValidSignUp(array $data):array
        {
            $errors = [];

            if (!isset($data['name'])) {
                $errors['name'] = 'Name is required';
            } elseif (empty($data['name'])) {
                $errors['name'] = '* Ввведите Имя';
            } elseif (strlen($data['name']) < 2 || strlen($data['name']) > 40) {
                $errors['name'] = '* Имя не может быть меньше 2 и больше 20 символов';
            }



            if (!isset($data['email'])) {
                $errors['email'] = 'Email is required';
            } elseif (empty($data['email'])) {
                $errors['email'] = '* Ввведите E-mail';
            } elseif (strlen($data['email']) < 2 || strlen($data['email']) > 40) {
                $errors['email'] = '* E-mail не может быть меньше 2 и больше 40 символов';
            } else {
                require_once "../Model/User.php";
                $user = new User();
                $userData = $user->getUser();

                if (!empty($userData)) {
                    $errors['email'] = '* Такой E-mail уже сущесвует';
                }
            }



            if (!isset($data['phone'])) {
                $errors['phone'] = 'Phone is required';
            } elseif (empty($data['phone'])) {
                $errors['phone'] = '* Введите телефон';
            } elseif (strlen($data['phone']) < 2 || strlen($data['phone']) > 40) {
                $errors['phone'] = '* Телефон не может быть меньше 2 и больше 40 символов';
            }



            if (!isset($data['password'])) {
                $errors['password'] = 'Password is required';
            } elseif (empty($data['password'])) {
                $errors['password'] = '* Введите пароль';
            } elseif (strlen($data['password']) < 2 || strlen($data['password']) > 40) {
                $errors['password'] = '* Пароль не может быть меньше 2 и больше 40';
            }



            if (!isset($data['psw'])) {
                $errors['psw'] = 'Psw is required';
            } elseif (empty($data['psw'])) {
                $errors['psw'] = '* Повторите пароль';
            } elseif ($data['psw'] !== $data['password']) {
                $errors['psw'] = '* Пароли не совпадают';
            }


            return $errors;
        }


    public function logout()
    {
        session_start();

        unset($_SESSION['user_id']);
        header('Location: /login');
    }
}