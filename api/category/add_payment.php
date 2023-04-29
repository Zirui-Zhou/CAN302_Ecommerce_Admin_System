<?php
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $data = json_decode(file_get_contents('php://input'), true);

    $pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);

    $platformMap = array(
        'option1' => 1,
        'option2' => 2,
        'option3' => 3
    );

    $platform = $platformMap[$data['platform']];

    $stmt = $pdo->prepare("
        INSERT INTO `payment`(`id`, `platform`, `account`, `is_default`, `user_id`)
        VALUES (:id, :platform, :account, :is_default, :user_id)
    ");
    $stmt->bindParam(":id", $data['id']);
    $stmt->bindParam(":platform", $platform);
    $stmt->bindParam(":account", $data['account']);
    $stmt->bindParam(":is_default", $data['is_default']);
    $stmt->bindParam(":user_id", $data['user_id']);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
?>
