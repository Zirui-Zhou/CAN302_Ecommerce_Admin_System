<?php

global $pdo;
include("../../config.php");
include("../../uuid.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["order_id"])) {
    echo "error";
    exit();
}

if(!isset($data["product_id"])) {
    echo "error";
    exit();
}

if(!isset($data["number"])) {
    echo "error";
    exit();
}

$uuid = uuid::v4();

$sql = "
    INSERT INTO order_product_list (id, order_id, number, product_id)
    VALUES ('{$uuid}', '{$data["order_id"]}', '{$data["number"]}', '{$data["product_id"]}');
";

$result = $pdo->query($sql);

echo json_encode($result);