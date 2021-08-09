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
        return makeJsonAnswer(new User(null), $errors);
    }

    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        if (empty($login) || strlen($login) > 32) {
            $errors[] = 'Логин должен быть от одного до 32-ух символов.';
        }
        if (empty($password)) {
            $errors[] = 'Пароль не может быть пустым.';
        }

        if (count($errors) === 0) {
            $user = new User($pdo, $login);
            if ($user->getId()) {
                if ($user->checkPassword($password)) {
                    $_SESSION['user_login'] = $user->getLogin();
                    echo makeJsonAnswer($user, $errors);
                    die();
                } else {
                    $errors[] = 'Пароль не верный.';
                }
            } else {
                $errors[] = 'Пользователя с таким логином не существует.';
            }
        }

        echo makeJsonAnswer(new User(null), $errors);
    }
}