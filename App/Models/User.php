<?php

namespace App\Models;

use App\AppModels;
use PhpParser\Node\Expr\Array_;

class User extends AppModels
{
    private int $id;
    private string $token;
    private string $firstname;
    private string $lastname;
    private string $login;
    private string $email;
    private string $password;
    private string $tel;
    private string $address;
    private string $about;
    private string $type;
    private string $job;
    private string $activation_code;
    private string $reboot_pass_code;
    private bool $active;
    private string $doc;
    private string $picture;
    private string $create_at;
    private string $update_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getTel(): string
    {
        return $this->tel;
    }

    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getAbout(): string
    {
        return $this->about;
    }

    public function setAbout(string $about): void
    {
        $this->about = $about;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getJob(): string
    {
        return $this->job;
    }

    public function setJob(string $job): void
    {
        $this->job = $job;
    }

    public function getActivationCode(): string
    {
        return $this->activation_code;
    }

    public function setActivationCode(string $activation_code): void
    {
        $this->activation_code = $activation_code;
    }

    public function getRebootPassCode(): string
    {
        return $this->reboot_pass_code;
    }

    public function setRebootPassCode(string $reboot_pass_code): void
    {
        $this->reboot_pass_code = $reboot_pass_code;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getDoc(): string
    {
        return $this->doc;
    }

    public function setDoc(string $doc): void
    {
        $this->doc = $doc;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }

    public function getCreateAt(): string
    {
        return $this->create_at;
    }

    public function setCreateAt(string $create_at): void
    {
        $this->create_at = $create_at;
    }

    public function getUpdateAt(): string
    {
        return $this->update_at;
    }

    public function setUpdateAt(string $update_at): void
    {
        $this->update_at = $update_at;
    }

    public function name(): string {
        return $this->firstname ." ". strtoupper($this->lastname);
    }

    public function picture(): string
    {
        return 'Storage/profil/img/' . $this->picture;
    }

    public function doc(): string
    {
        return 'Storage/profil/docs/' . $this->doc;
    }

    public static function connect(string $username, string $password) : Array|User|false
    {
       $state = CONNECT->prepare("SELECT * FROM user WHERE login = ? AND password = ?");
       $state->bindParam(1, $username);
       $state->bindParam(2, $password);
       if ($state->execute()) return $state->fetch(\PDO::FETCH_ASSOC); else {
           return false;
       }
    }
}