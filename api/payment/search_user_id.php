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
    payment.id as id, platform, account, is_default, pp.type as type
    FROM payment
    LEFT JOIN payment_platform pp on pp.id = payment.platform
    WHERE user_id='{$data["user_id"]}'
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

echo json_encode($result);