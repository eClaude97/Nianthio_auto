<?php

namespace App;

use PDO;
use PDOException;

require "../Class/config.php";

class DbConfig
{
    private string $dns  = DB_CONNECTION . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE;
    private string $username = DB_USER;
    private string $pass = DB_PASS;

    public function Connect(){
        try {
            return new PDO($this->dns, $this->username, $this->pass );
        }catch (PDOException $e){
            die ( "Error : " . $e->getMessage() );
        }
    }

}