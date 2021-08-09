<?php

class UserContacts
{
    private $userId;
    private $contacts;

    public function __construct($pdo, $userId)
    {
        $this->clear();
        $this->userId = $userId;
        $this->load($pdo);
    }

    public function load($pdo)
    {
        try {
            $stmt = $pdo->prepare('SELECT user_contacts.id, user_contacts.contact_id,
contacts.nickname AS nickname, contacts.email AS email
FROM user_contacts
INNER JOIN contacts ON user_contacts.contact_id = contacts.id
WHERE user_contacts.user_id = :user_id
ORDER BY user_contacts.id');
            $stmt->bindParam(':user_id', $this->getUserId());
            $stmt -> execute();
        }
        catch(PDOException $e){
            $this->clear();
            return false;
        }

        $result = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['contact_id']] = [
                'user_id' => $this->getUserId(),
                'id' => $row['id'],
                'nickname' => $row['nickname'],
                'email' => $row['email']
            ];
        }
        $this->setContacts($result);
        return $this->getContacts();
    }

    public function save($pdo)
    {
        $changed = false;
        foreach ($this->contacts as $contact_id => $item) {
            if ($item['id'] === null) {
                $changed = true;
                try {
                    $stmt = $pdo->prepare('INSERT INTO user_contacts (user_id, contact_id) VALUES (?,?)');
                    $stmt->execute(array($this->userId, $contact_id));
                }
                catch(PDOException $e){
                    return $e->getMessage();
                }
            }
        }
        if ($changed) {
            $this->load($pdo);
        }
        return true;
    }

    public function addContact($pdo, $contact_id)
    {
        if (!isset($this->contacts[$contact_id])) {
            $this->contacts[$contact_id] = [
                'user_id' => $this->userId,
                'id' => null
            ];

            // save to base
            return $this->save($pdo);
        }
        return false;
    }

    public function getContacts()
    {
        return $this->contacts;
    }

    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    private function clear()
    {
        $this->setContacts([]);
    }
}