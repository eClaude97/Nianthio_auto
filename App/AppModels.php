<?php

namespace App;
use PDO;
use PDOException;
use stdClass;

/**
 * La Class generic pour les model de notre application
 */
class AppModels
{
    public int $id;

    public function __construct(){}


    /**
     * Cette methode permet de générer un token unique à pour chaque ligne de la table
     * @param array $datas Class::all([token], false)
     * @return string
     */
    public static function token(array $datas): string
    {
        $token = Functions::createToken();
        foreach ($datas as $data) {
            if ($data['token'] === $token) $token = Functions::createToken();
        }
        return $token;
    }

    /**
     * Cette methode retourne le nom de la class fille appelée
     * @return string
     */
    protected static function getClass() : string {
        $tab = explode('\\', get_called_class());
        return $tab[count($tab) - 1];
    }

    /**
     * Cette fonction permet d'insérer une ligne dans une table de la base de données
     * @param array $datas
     * @return bool
     */
    public static function create(array $datas = []) : bool
    {
        $class = strtolower(self::getClass());
        $placeholders = implode(', ', array_fill(0, count($datas), '?'));
        $columns = implode(', ', array_keys($datas));
        $state = CONNECT->prepare("INSERT INTO $class($columns) VALUES ($placeholders)");
        try {
            return $state->execute(array_values($datas));
        } catch (PDOException $e) {
            die("Erreur lors de l'insertion des données: " . $e->getMessage());
        }
    }

    /**
     * Cette fonction permet de faire la mise à jour d'une ligne de la table dans la base de données
     * @param array $datas
     * @return bool
     */
    public function update(array $datas = []) : bool
    {

        $class = strtolower(self::getClass());
        $updateString = implode(', ', array_map(function($key) {
            return "$key = ?";
        }, array_keys($datas)));

        $state = CONNECT->prepare("UPDATE $class SET $updateString WHERE id = $this->id ");
        try {
            return $state->execute(array_merge(array_values($datas)));
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour des données: " . $e->getMessage());
        }

    }

    /**
     * Cette methode permet de supprimer une ligne de la base de donnée
     * @param string $keyName Peut-être 'token' ou id par défaut
     * @return bool
     */
    public function delete(string $keyName = 'id') : bool
    {
        $table = strtolower(self::getClass());
        $state = CONNECT->prepare("DELETE FROM $table WHERE $keyName = ?");
        $state->bindParam(1, $this->id);
        return $state->execute();
    }

    /**
     * Cette methode permet de récupérer une instance du model dans la base de donnée
     * @param int|string $key
     * @param string[] $attributes
     * @param string $keyName Peut-être 'token' ou laisser sur 'id' par défaut
     * @param bool $object Mettre à false pour obtenir un PDO::FETCH_ASSOC
     * @return mixed return false on failure
     */
    public static function find(int|string $key, array $attributes = [],string $keyName = 'id', bool $object = true): mixed
    {
        $table = strtolower(self::getClass());
        $columns = (!empty($attributes)) ? implode(', ', $attributes) : '*';
        $state = CONNECT->prepare("SELECT $columns FROM $table WHERE $keyName = ?");
        $state->bindParam(1, $key);

        if ($state->execute()) if ($object) return $state->fetchObject(get_called_class());else {
            $state->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Cette fonction permet de retourner une ligne de la table avec de conditions
     * @param string[] $attributes la liste des colonnes de la table à récupérer
     * @param array $conditions les condition de la clause where ex: ['id' => 2, 'token' = $token]
     * @param bool $object mettre à false pour obtenir un tableau ASSOC
     * @return stdClass|bool|array|null
     */
    public static function findWhere(array $attributes = [],array $conditions = [], bool $object = true): mixed
    {
        $table = strtolower(self::getClass());
        $columns = (!empty($attributes)) ? implode(', ', $attributes) : '*';
        $updateConditions = implode(" AND ", array_map(function ($key){
            return "$key = ?";
        }, array_keys($conditions)));

        $state = CONNECT->prepare("SELECT $columns FROM $table WHERE $updateConditions");
        try {
            $rep = $state->execute(array_merge(array_values($conditions)));
        } catch (PDOException $exception){
            echo "Error : " .  $exception->getMessage();
        }

        if ($rep) {
            return $object ? $state->fetchObject(get_called_class()) : $state->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Cette fonction permet de récupérer les données dans la base de donnée
     * @param string[] $attributes
     * @param bool $class mettre à false pour retourner un tableau associatif
     * @return bool|array|stdClass
     */
    public static function all(array $attributes = [],bool $class = true): bool|array|stdClass
    {
        $table = strtolower(self::getClass());
        $columns = (!empty($attributes)) ? implode(', ', $attributes) : '*';

        $state = CONNECT->prepare("SELECT $columns FROM $table");
        $state->execute();

        if ($class) return $state->fetchAll(PDO::FETCH_CLASS, get_called_class());

        return $state->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cette fonction permet de récupérer les données dans la base de donnée
     * @param string[] $attributes
     * @param bool $class mettre à false pour retourner un tableau associatif
     * @param array $conditions
     * @return bool|array|stdClass
     */
    public static function allWhere(array $attributes = [],bool $class = true,array $conditions = []): bool|array|stdClass
    {
        $table = strtolower(self::getClass());
        $columns = (!empty($attributes)) ? implode(', ', $attributes) : '*';
        $updateConditions = implode(" AND ", array_map(function ($key){
            return "$key = ?";
        }, array_keys($conditions)));

        $state = CONNECT->prepare("SELECT $columns FROM $table WHERE $updateConditions");
        try {
            $state->execute(array_merge(array_values($conditions)));
        } catch (PDOException $exception){
            echo "Error : " . $exception->getMessage();
        }

        if ($class) return $state->fetchAll(PDO::FETCH_CLASS, get_called_class());

        return $state->fetchAll(PDO::FETCH_ASSOC);
    }

}