<?php

namespace App\Models;

use App\AppController;
use App\AppModels;

class Auth extends AppModels
{

    protected string $_username;
    protected string $_password;

    public function __construct(){
        parent::__construct();
    }

    public function _init(string $username, string $password): void
    {
        $this->_username = $username;
        $this->_password = $password;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->_username;
    }

    /**
     * Cette methode permet de connecter un utilisateur.
     * @return User|false retourne un objet User ou false
     */
    public function connect(): User|false {
        $pass = SHA1($this->_password);
        return User::findWhere(conditions: ['login' => $this->_username, 'password' => $pass]);
    }


}