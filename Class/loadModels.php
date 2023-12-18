<?php
use App\DbConfig;

require "../vendor/autoload.php";
define("CONNECT", (new DbConfig())->Connect());

// Récupération de la marque sélectionnée depuis la requête GET
$id = $_GET['markId'];

$query = CONNECT->prepare("SELECT id, title FROM model WHERE mark_id = :id");
$query->bindParam(':id', $id);
$query->execute();
$models = $query->fetchAll(PDO::FETCH_ASSOC);

// Retournez les résultats au format JSON
echo json_encode($models);

