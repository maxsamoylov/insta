<?php

include_once 'userContacts.php';

class User
{
    private $id;
    private $login;
    private $nickname;
    private $email;
    private $contacts;

    private $passwordHash;

    private $contactsObject;

    public function __construct($pdo, $login = null)
    {
        if ($login)
        {
            $this->load($pdo, $login); // проверить получили ли мы юзера можно так: if ($user->getId()) { ... }
        }
        else
        {
            $this->clear();
        }
    }

    public function load($pdo, $login)
    {
        try {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE login=:login');
            $stmt->bindParam(':login', $login);
            $stmt -> execute();
        }
        catch(PDOException $e) {
            $this->clear();
            return false;
        }

        if ($stmt->rowCount() === 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->setId($result['id']);
            $this->setLogin($result['login']);
            $this->setNickname($result['nickname']);
            $this->setEmail($result['email']);
            $this->loadContacts($pdo);
            $this->passwordHash = $result['password'];

        } else {
            $this->clear();
            return false;
        }
        return true;
    }

    public function checkPassword($password)
    {
        return ($this->passwordHash ? $this->passwordHash === md5($password) : false);
    }

    public function register($pdo, $login, $password, $nickname, $email)
    {
        if ($login && $password && $nickname && $email) {
            try {
                $stmt = $pdo->prepare('INSERT INTO users (login, password, nickname, email) VALUES (?,?,?,?)');
                $stmt->execute(array($login, md5($password), $nickname, $email));
            }
            catch(PDOException $e) {
                return $e->getMessage();
            }
            $this->setId((int)$pdo->lastInsertId());
            $this->setLogin($login);
            $this->setNickname($nickname);
            $this->setEmail($email);
            return true;
        }
        return false;
    }

    public function addContact($pdo, $contact_id)
    {
        /** @var UserContacts $contactsObject */
        $contactsObject = $this->contactsObject;
        if ($contactsObject) {
            return $contactsObject->addContact($pdo, $contact_id);
        }
        return false;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getContacts()
    {
        return $this->contacts;
    }

    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    private function clear()
    {
        $this->id = null;
        $this->login = '';
        $this->nickname = '';
        $this->email = '';
        $this->contacts = [];
        $this->passwordHash = null;
    }

    private function loadContacts($pdo)
    {
        $contacts = new UserContacts($pdo, $this->getId());
        $this->setContacts($contacts->getContacts());
        $this->contactsObject = $contacts;
    }
}