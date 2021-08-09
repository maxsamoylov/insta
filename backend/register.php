<?php
session_start();

include_once 'connect.php';
include_once 'classes/user.php';
include_once 'utils.php';

if (strtolower($_SERVER['REQUEST_METHOD']) === "post")
{
    $errors = [];

    if (!$pdo) {
        $errors[] = 'Нет подключения к базе данных.';
        echo makeJsonAnswer(new User(null), $errors);
        die();
    }

    if (isset($_POST['login']) && isset($_POST['password'])
        && isset($_POST['nickname']) && isset($_POST['email']))
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $nickname = $_POST['nickname'];
        $email = $_POST['email'];

        if (empty($login) || strlen($login) > 32) {
            $errors[] = 'Логин должен быть от одного до 32-ух символов.';
        }

        if (empty($password)) {
            $errors[] = 'Пароль не может быть пустым.';
        }

        if (empty($nickname) || strlen($nickname) > 32) {
            $errors[] = 'Никнейм должен быть от одного до 32-ух символов';
        }

        if (strlen($email) < 6 || strlen($email) > 256) {
            $errors[] = 'E-mail должен быть от 6 до 256 символов';
        }

        $user = new User($pdo, $login);
        if (!$user->getId()) {
            $result = $user->register($pdo, $login, $password, $nickname, $email);

            if ($result !== true) {
                if (is_string($result)) {
                    $errors[] = $result;
                } else {
                    $errors[] = 'Не удалось зарегистрировать пользователя.';
                }
            } else {
                // registration success
                $_SESSION['user_login'] = $user->getLogin();
            }
        } else {
            $errors[] = 'Пользователь с таким логином уже существует.';
            $user = new User(null);
        }

        echo makeJsonAnswer($user, $errors);
    } else {
        $errors[] = 'Ошибка в данных.';
        echo makeJsonAnswer(new User(null), $errors);
    }
}