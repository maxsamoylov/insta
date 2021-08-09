<?php
include_once 'classes/user.php';

function makeJsonAnswer(User $user, $errors)
{
    header('Content-Type: application/json;charset=utf-8');
    return json_encode([
        'id' => $user->getId(),
        'login' => $user->getLogin(),
        'nickname' => $user->getNickname(),
        'email' => $user->getEmail(),
        'contacts' => $user->getContacts(),
        'errors' => $errors,
    ]);
}

function getPublicContacts($pdo)
{
    try {
        $stmt = $pdo->prepare('SELECT * FROM contacts ORDER BY id');
        $stmt -> execute();
    }
    catch(PDOException $e){
        $this->clear();
        return false;
    }

    $result = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[$row['id']] = [
            'nickname' => $row['nickname'],
            'email' => $row['email']
        ];
    }
    return $result;
}

function getPublicContactHtml($contact_id, $contact, $user_contacts)
{
    // "1":{"nickname":"Alicia Cain","email":"jeucrummottepra-8373@google.com"}
    $cbId = 'cb_' . $contact_id;
    if (isset($user_contacts[$contact_id])) {
        return '<div class="contact_div">'
            . '<img src="img/check.png" class="check_img" alt="Галочка">'
            . $contact['nickname'] . ' (' . $contact['email'] . ')'
            . '</div>';
    } else {
        return '<div class="contact_div"><input type="checkbox" class="checkbox" name="'
            . $cbId
            . '" id="'
            . $cbId
            . '" value="'
            . $contact_id
            . '"><label class="contact_label" for="'
            . $cbId
            . '">'
            . $contact['nickname'] . ' (' . $contact['email'] . ')'
            . '</label></div>';
    }
}

function getPublicContactsHtml($contacts, $user_contacts)
{
    $result = '';
    foreach ($contacts as $index => $item) {
        $result .= getPublicContactHtml($index, $item, $user_contacts);
    }
    $result = '<form class="contacts_form" method="post" action="" id="contacts_form">'
        . $result
        . '<div class="error" id="add_contact_error"></div>'
        . '<button type="submit" class="btn block" id="contacts_btn" disabled="disabled">Добавить в избранное</button>'
        . '</form>';
    return $result;
}

function getUserContactsHtml(User $user) {
    $contacts = $user->getContacts();
    $result = '';
    foreach ($contacts as $contact) {
        $result .= '<div class="contact_div">'
            . $contact['nickname'] . ' (' . $contact['email'] . ')'
            . '</div>';
    }
    return $result;
}
