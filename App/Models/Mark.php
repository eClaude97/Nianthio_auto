<?php

namespace App\Models;

use App\AppModels;
use PDO;
use stdClass;

class Mark extends AppModels{

    public string $logoPath;
    public string $logo;

    public function __construct()
    {
        parent::__construct();
        $this->logoPath = $this->logo();
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
    public function logo(): string
    {
        return "Storage/logo/{$this->logo}";
    }

}