<?php

global $pdo;
include("../../config.php");
include("../../uuid.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["name"])) {
    echo "error";
    exit();
}

if(!isset($data["desc"])) {
    echo "error";
    exit();
}

$uuid = uuid::v4();

$sql = "
    INSERT INTO category (id, name, description)
    VALUES ('{$uuid}', '{$data["name"]}', '{$data["desc"]}');
";

$result = $pdo->query($sql);

echo json_encode($result);