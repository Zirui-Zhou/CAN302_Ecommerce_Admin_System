<?php

$requestMethod = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'), true);

var_dump($data);

if(!isset($data["id"])) {
    echo "error";
    exit();
}

$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);

$id = trim($data["id"]);
//$sql = "DELETE FROM user WHERE id='{$id}'";
//$sql = "DELETE FROM user_info WHERE id='{$id}; 'DELETE FROM user WHERE id='{$id}' ";
$sql = "DELETE FROM address WHERE user_id='{$id}'; DELETE FROM payment WHERE user_id='{$id}'; DELETE FROM user_info WHERE id='{$id}'; DELETE FROM user WHERE id='{$id}'";


$result = $pdo->query($sql);

echo json_encode($result);
