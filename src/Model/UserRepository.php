<?php

namespace Model;

use App;
use PDO;
use PDOStatement;

class UserRepository
{
    /** @var PDO */
    private $pdo;

    public function __construct()
    {
        $this->pdo = App::$db->pdo;
    }

    /**
     * @param string $username
     * @return mixed|null
     */
    public function findByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':username', $username);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $users = $this->generateUsersFromDbRows($stmt);

        if (count($users) === 0) {
            return null;
        }

        return $users[0];
    }

    /**
     * @param string $session_token
     * @return mixed|null
     */
    public function findBySessionToken($session_token)
    {
        $query = "SELECT * FROM users WHERE session_token = :session_token";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':session_token', $session_token);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $users = $this->generateUsersFromDbRows($stmt);

        if (count($users) === 0) {
            return null;
        }

        return $users[0];
    }

    /**
     * @param User $user
     * @return bool
     */
    public function updateSessionToken($user)
    {
        $query = "UPDATE users SET session_token = :session_token WHERE id = :id";
        $stmt = $this->pdo->prepare($query);

        $user_id = $user->getId();
        $session_token = $user->getSessionToken();
        $stmt->bindParam(':session_token', $session_token);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            return false;
        }

        return true;
    }

    /**
     * @param PDOStatement $stmt
     * @return array
     */
    private function generateUsersFromDbRows(PDOStatement $stmt)
    {
        $users = [];

        while ($db_row = $stmt->fetch()) {
            $user = new User();
            $user->setId($db_row['id']);
            $user->setUsername($db_row['username']);
            $user->setPassword($db_row['password']);
            $user->setFunds($db_row['funds']);
            $user->setSessionToken($db_row['session_token']);

            $users[] = $user;
        }

        return $users;
    }

    /**
     * Get all users except user with id=$user_id
     * @param $user_id
     * @return array
     */
    public function getReceivers($user_id)
    {
        $query = "SELECT id, username FROM users WHERE id <> :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $user_id);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $receivers = $stmt->fetchAll();

        return $receivers;
    }

    /**
     * Transaction for funds sending.
     * @param int $amount
     * @param int $sender_id
     * @param int $receiver_id
     * @return bool
     */
    public function withdrawFunds($amount, $sender_id, $receiver_id)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->pdo->beginTransaction();

            // Subtract amount from sender
            $stmt1 = $this->pdo->prepare('UPDATE users SET funds = funds - :amount WHERE id = :sender_id');
            $stmt1->bindParam(':amount', $amount);
            $stmt1->bindParam(':sender_id', $sender_id, PDO::PARAM_INT);
            $stmt1->execute();

            // Add amount to receiver
            $stmt2 = $this->pdo->prepare('UPDATE users SET funds = funds + :amount WHERE id = :receiver_id');
            $stmt2->bindParam(':amount', $amount);
            $stmt2->bindParam(':receiver_id', $receiver_id, PDO::PARAM_INT);
            $stmt2->execute();

            $this->pdo->commit();

            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}