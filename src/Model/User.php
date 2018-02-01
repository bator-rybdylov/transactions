<?php

namespace Model;

class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var float
     */
    private $funds;

    /**
     * @var string
     */
    private $session_token;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getFunds()
    {
        return $this->funds;
    }

    public function setFunds($funds)
    {
        $this->funds = $funds;
    }

    public function getSessionToken()
    {
        return $this->session_token;
    }

    public function setSessionToken($session_token)
    {
        $this->session_token = $session_token;
    }
}