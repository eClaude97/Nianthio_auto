<?php

namespace App\Models;

use App\AppModels;
use PDO;
use stdClass;

class Mark extends AppModels{

    private int $id;
    private string $token;
    private string $name;
    private string $logo;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): void
    {
        $this->logo = $logo;
    }

    public function __construct()
    {
        parent::__construct();
    }

    public static function all(array $attributes = [], bool $class = true): bool|array|stdClass
    {
        $columns = (!empty($attributes)) ? implode(', ', $attributes) : '*';
        $state = CONNECT->prepare("SELECT $columns FROM mark ORDER BY name ASC ");
        $state->execute();
        if ($class) return $state->fetchAll(PDO::FETCH_CLASS, get_called_class());
        return $state->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return string
     */
    public function logoPath(): string
    {
        return "Storage/logo/{$this->logo}";
    }

}