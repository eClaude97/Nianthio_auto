<?php

namespace App\Models;

use App\AppModels;
use PDO;
use PDOException;
use stdClass;

class Model extends AppModels{

    public int $mark_id;

    public mixed $mark;

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