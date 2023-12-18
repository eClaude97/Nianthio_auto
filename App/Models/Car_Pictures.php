<?php

namespace App\Models;

use App\AppModels;

class Car_Pictures extends AppModels
{

    public function delete(string $keyName = 'car_id', int $id = null): bool
    {
        $state = CONNECT->prepare("DELETE FROM car_pictures WHERE $keyName = ?");
        $state->bindParam(1, $id);
        return $state->execute();
    }

    public function path(): string
    {
        return 'Storage/cars/'. $this->path;
    }

}