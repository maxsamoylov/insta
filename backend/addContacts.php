<?php
session_start();

include_once 'connect.php';
include_once 'classes/user.php';
include_once 'utils.php';

if (strtolower($_SERVER['REQUEST_METHOD']) === "post")
{
    $errors = [];

    if (isset($_SESSION['user_login'])) {

        $user = new User($pdo, $_SESSION['user_login']);

        if (!$user->getId()) {
            include_once '../logout.php';
            die();
        }

        if (is_array($_POST)) {
            foreach ($_POST as $index => $item) {
                if (strpos($index, 'cb_') === 0) {
                    $user->addContact($pdo, $item);
                }
            }
        }
    } else {
        $errors[] = 'Вы не авторизованы. Перезагрузите страницу.';
    }

    echo json_encode($errors);
}
