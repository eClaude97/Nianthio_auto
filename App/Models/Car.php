<?php

namespace App\Models;

use App\AppModels;
use PDO;
use PDOException;
use Symfony\Component\VarDumper\Server\Connection;

class Car extends AppModels
{

    public array|false $pictures;
    private int $add_by;
    public mixed $user;
    public  mixed $modelMark;

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