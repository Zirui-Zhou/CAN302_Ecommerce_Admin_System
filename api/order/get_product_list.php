<?php

global $pdo;
include("../../config.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["id"])) {
    echo "error";
    exit();
}

$stmt = $pdo->prepare("
    select
        op.id as id, p.name as name, p.image_url as image_url,
        c.name as category, p.price as price, p.price_unit as price_unit,
        op.number as number, p.id as product_id
    from order_product_list op 
        left join product p on op.product_id = p.id
        left join category c on p.category = c.id
    where order_id = '{$data["id"]}'
");
$stmt->execute();
$product_list = $stmt->fetchAll();

echo json_encode($product_list);