<?php

namespace App\Controller;

use App\Model\User;


class UserController
{
    public function login(): array
    {
        $errors = [];
        $errorsLogin = [];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $errors = $this->isValidLogin($_POST);

            if (empty($errors)) {
                $password = $_POST['password'];

                $user = User::getUserEmail($_POST['email']);

                if (!empty($user) && password_verify($password, $user->getPassword())) {
                    session_start();

                    $_SESSION['user_id'] = ['id' => $user->getId(), 'email' => $user->getEmail(), 'name' => $user->getName()];
                    header('Location: /main');
                } else {
                    $errorsLogin = ['errors' => '* Неверный логин или пароль'];
                }
            }
        }
        session_start();

        if (isset($_SESSION['user_id'])) {
            header('Location: /main');
        }
        return [
            'view' => 'login',
            'data' => [
                'errors' => $errors,
                'errorsLogin' => $errorsLogin
            ]
        ];
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


    public function signup(): array
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $errors = $this->isValidSignUp($_POST);

            if (empty($errors)) {
                session_start();
                header('Location: /login');

                $password = $_POST['password'];
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $user = new User($_POST['name'], $_POST['email'], $_POST['phone'], $hash);

                $user->save();
            }
        }
        session_start();

        if (isset($_SESSION['user_id'])) {
            header('Location: /main');
        } return [
            'view' => 'signup',
            'data' => [
                'errors' => $errors
            ]
        ];
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
                $userData = User::getUserEmail($_POST['email']);

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
    public function logout(): void
    {
        session_start();

        unset($_SESSION['user_id']);
        header('Location: /login');
    }
}