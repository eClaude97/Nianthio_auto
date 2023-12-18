<?php

namespace App\Models;

class User extends Auth
{

    public string $doc;
    public string $name;
    public string $firstname;
    public string $lastname;
    public string $picture;

    public function picture(): string
    {
        return 'Storage/profil/img/' . $this->picture;
    }

    public function doc(): string
    {
        return 'Storage/profil/doc/' . $this->doc;
    }
}