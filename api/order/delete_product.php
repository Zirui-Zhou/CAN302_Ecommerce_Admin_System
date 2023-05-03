<?php

global $pdo;
include("../../config.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["id"])) {
    echo "error";
    exit();
}


$sql = "
    DELETE FROM order_product_list WHERE id='{$data["id"]}'
";

$result = $pdo->query($sql);

echo json_encode($result);