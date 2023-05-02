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
SELECT
product.id as id, product.name as name, image_url, price, price_unit, c.name as category
FROM product 
LEFT JOIN category c on product.category = c.id
WHERE product.id='{$data["id"]}'
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($result);