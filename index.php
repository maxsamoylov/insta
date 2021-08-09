<?php
session_start();

include_once 'backend/connect.php';
include_once 'backend/classes/user.php';
include_once 'backend/utils.php';

if ($pdo !== null) {

    $header = file_get_contents('frontend/html/header.html');

    if (isset($_SESSION['user_login'])) {
        // authorized
        $user = new User($pdo, $_SESSION['user_login']);
        if (!$user->getId()) {
            include_once 'logout.php';
            die();
        }

        if ($_GET['page'] == 2) {
            $page = file_get_contents('frontend/html/page_favorites.html');
            $page = str_replace('{contacts}', getUserContactsHtml($user), $page);
        } else {
            $page = file_get_contents('frontend/html/page_contacts.html');
            $contacts = getPublicContacts($pdo);
            $page = str_replace('{contacts}', getPublicContactsHtml($contacts, $user->getContacts()), $page);
        }

        // некоторые браузеры кешируют страницы,
        // добавляю в ссылку рандомную переменную чтобы перезагружались гарантированно
        $page = str_replace('{rnd}', rand(), $page);

        $logoutDiv = file_get_contents('frontend/html/logout_div.html');
        $page = str_replace('{logoutdiv}', $logoutDiv, $page);
        $page = str_replace('{name}', $user->getNickname(), $page);
        $page = str_replace('{email}', $user->getEmail(), $page);
    } else {
        // not authorized
        $page = file_get_contents('frontend/html/page_auth_register.html');
    }

    echo $header . $page;

} else {
    echo 'Не могу подключиться к базе данных...';
}
