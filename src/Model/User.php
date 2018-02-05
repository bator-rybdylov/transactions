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


    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword() :string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return float
     */
    public function getFunds() : float
    {
        return $this->funds;
    }

    /**
     * @param float $funds
     */
    public function setFunds(float $funds)
    {
        $this->funds = floatval($funds);
    }

    /**
     * @return string|null
     */
    public function getSessionToken()
    {
        return $this->session_token;
    }

    /**
     * @param string|null $session_token
     */
    public function setSessionToken($session_token)
    {
        $this->session_token = $session_token;
    }
}