<?php

global $pdo;
include("../../config.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["user_id"])) {
    echo "error";
    exit();
}

$sql = "
    SELECT 
    id, addressee, phone, country, address, is_default
    FROM address
    WHERE user_id='{$data["user_id"]}'
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchALl();

echo json_encode($result);