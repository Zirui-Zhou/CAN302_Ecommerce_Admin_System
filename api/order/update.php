<?php

global $pdo;
include("../../config.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'), true);

//var_dump($data);

foreach (["id", "state", "time", "remark", "user_id", "address_id", "payment_id", "amount"] as $key) {
    if (!isset($data[$key])) {
        echo "error";
        exit();
    }
}

$sql = "
        UPDATE `order`
        SET state='{$data["state"]}',
            payment_time='{$data["time"]}',
            remark='{$data["remark"]}',
            user_id='{$data["user_id"]}',
            address_id='{$data["address_id"]}',
            payment_id='{$data["payment_id"]}',
            payment_amount='{$data["amount"]}'
        WHERE id='{$data["id"]}'
";

$result = $pdo->query($sql);


echo json_encode($result);