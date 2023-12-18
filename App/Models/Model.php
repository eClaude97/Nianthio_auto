<?php

namespace App\Models;

use App\AppModels;
use PDOException;

class Model extends AppModels{

    private int $id;
    private string $token;
    private string $title;
    private int $year;
    private int $mark_id;
    private string $create_at;
    private string $update_at;
    public mixed $mark;

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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getMarkId(): int
    {
        return $this->mark_id;
    }

    public function setMarkId(int $mark_id): void
    {
        $this->mark_id = $mark_id;
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

    public function getMark(): mixed
    {
        return $this->mark;
    }

    public function setMark(mixed $mark): void
    {
        $this->mark = $mark;
    }



    public function __construct(){
        parent::__construct();
        $this->mark = $this->mark();
    }

    /**
     * Cette Methode retour la mark du model
     * @return bool|Mark|null
     */
    private function mark(): bool|Mark|null
    {
        $state = CONNECT->prepare("SELECT id, token, name, logo FROM mark WHERE id = $this->mark_id");
        try {
            $rep = $state->execute();
        } catch (PDOException $exception){
            echo "Error : " . $exception->getMessage();
        }
        if ($rep) return $state->fetchObject(Mark::class);
        return false;
    }


}