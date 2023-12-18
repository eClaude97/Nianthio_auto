<?php

namespace App\Models;

use App\AppModels;
use PDO;
use PDOException;

class Car extends AppModels
{

    private int $id;
    private string $token;
    private string $matricule;
    private string $title;
    private string $description;
    private int $mark_id;
    private int $model_id;
    private string $type;
    private string $color;
    private int $price;
    private int $mileage;
    private int $doors;
    private int $seats;
    private string $energy;
    private string $transmission;
    private bool $sold;
    private bool $rented;
    private int $add_by;
    private string $create_at;
    private string $update_at;
    public array|false $pictures;
    public mixed $user;
    public  mixed $modelMark;

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

    public function getMatricule(): string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): void
    {
        $this->matricule = $matricule;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getMarkId(): int
    {
        return $this->mark_id;
    }

    public function setMarkId(int $mark_id): void
    {
        $this->mark_id = $mark_id;
    }

    public function getModelId(): int
    {
        return $this->model_id;
    }

    public function setModelId(int $model_id): void
    {
        $this->model_id = $model_id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getMileage(): int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): void
    {
        $this->mileage = $mileage;
    }

    public function getDoors(): int
    {
        return $this->doors;
    }

    public function setDoors(int $doors): void
    {
        $this->doors = $doors;
    }

    public function getSeats(): int
    {
        return $this->seats;
    }

    public function setSeats(int $seats): void
    {
        $this->seats = $seats;
    }

    public function getEnergy(): string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): void
    {
        $this->energy = $energy;
    }

    public function getTransmission(): string
    {
        return $this->transmission;
    }

    public function setTransmission(string $transmission): void
    {
        $this->transmission = $transmission;
    }

    public function isSold(): bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): void
    {
        $this->sold = $sold;
    }

    public function isRented(): bool
    {
        return $this->rented;
    }

    public function setRented(bool $rented): void
    {
        $this->rented = $rented;
    }

    public function getAddBy(): int
    {
        return $this->add_by;
    }

    public function setAddBy(int $add_by): void
    {
        $this->add_by = $add_by;
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

    public function __construct()
    {
        parent::__construct();
        $this->pictures = $this->pictures();
        $this->user = $this->user()['name'];
        $this->modelMark = $this->modelMark()['title'];
    }

    /**
     * @return bool|array|Car_Pictures
     */
    public function pictures(): bool|array|Car_Pictures
    {
        $state = CONNECT->prepare("SELECT id, path FROM car_pictures WHERE car_id = $this->id");
        try {
            $rep = $state->execute();
        } catch (PDOException $exception){
            echo "Error : " . $exception->getMessage();
        }

        if ($rep) return $state->fetchAll(PDO::FETCH_CLASS,Car_Pictures::class);

        return false;
    }

    private function user()
    {
        $state = CONNECT->prepare("SELECT CONCAT(CONCAT(firstname, ' '), lastname) as name FROM user WHERE id = $this->add_by");
        try {
            $rep = $state->execute();
        } catch (PDOException $exception){
            echo "Error : " . $exception->getMessage();
        }
        if ($rep) return $state->fetch(PDO::FETCH_ASSOC);
        return false;
    }

    private function modelMark(){
        $sql = "SELECT CONCAT(CONCAT(m.name, ' '), m2.title) as title 
                FROM car c 
                    INNER JOIN mark m 
                    INNER JOIN model m2 
                WHERE c.mark_id = m.id AND c.model_id = m2.id";
        $state = CONNECT->prepare($sql);
        try {
            $rep = $state->execute();
        } catch (PDOException $exception){
            echo "Error : " . $exception->getMessage();
        }
        if ($rep) return $state->fetch(PDO::FETCH_ASSOC);
        return false;
    }

}