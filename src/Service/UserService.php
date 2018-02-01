<?php

namespace Service;

use Model\User;
use Model\UserRepository;

class UserService
{
    private $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @return mixed|null
     */
    public function getCurrentUser()
    {
        return $this->user_repository->findBySessionToken($_SESSION['token']);
    }

    /**
     * Get all users except current user
     * @param $current_user
     * @return array
     */
    public function getReceivers($current_user)
    {
        $user_id = $current_user;
        if ($current_user instanceof User) {
            $user_id = $current_user->getId();
        }

        return $this->user_repository->getReceivers($user_id);
    }

    /**
     * Send funds from $sender to $receiver
     * @param $amount
     * @param $sender
     * @param $receiver
     * @return bool
     */
    public function withdrawFunds($amount, $sender, $receiver)
    {
        $sender_id = $sender;
        if ($sender instanceof User) {
            $sender_id = $sender->getId();
        }
        $receiver_id = $receiver;
        if ($receiver instanceof User) {
            $receiver_id = $receiver->getId();
        }

        return $this->user_repository->withdrawFunds($amount, $sender_id, $receiver_id);
    }

    /**
     * If user doesn't exist or user token from DB doesn't match with token from session,
     * the user is invalid
     *
     * @param User $user
     * @return bool
     */
    public function isLoggedUser($user)
    {
        return !is_null($user) && $_SESSION['token'] === $user->getSessionToken();
    }
}