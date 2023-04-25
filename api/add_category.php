<?php

include ("../uuid.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'), true);

var_dump($data);

if(!isset($data["name"])) {
    echo "error";
    exit();
}

if(!isset($data["desc"])) {
    echo "error";
    exit();
}

$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);

$uuid = uuid::v4();

$sql = "
    INSERT INTO category (id, name, description)
    VALUES ('{$uuid}', '{$data["name"]}', '{$data["desc"]}');
";

$result = $pdo->query($sql);

echo json_encode($result);