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
    u.id as id, u.name as name, u.state as state, ui.phone as phone, ui.email as email
    FROM user u INNER JOIN user_info ui on u.id = ui.id
    WHERE u.id='{$data["id"]}'
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($result);