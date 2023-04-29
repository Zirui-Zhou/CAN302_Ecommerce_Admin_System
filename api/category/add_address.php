<?php
	$requestMethod = $_SERVER["REQUEST_METHOD"];
	$data = json_decode(file_get_contents('php://input'), true);

	$id = $data["id"];
	$phone = $data["phone"];
	$user_id = $data["user_id"];
	$addressee = $data["addressee"];
	$address = $data["address"];
	$country = $data["country"];
	$is_default = $data["is_default"];

	$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);

	$stmt = $pdo->prepare("
		INSERT INTO `address`(`id`, `phone`, `user_id`, `addressee`, `address`, `country`, `is_default`) 
		VALUES (:id, :phone, :user_id, :addressee, :address, :country, :is_default)
	");
	$stmt->bindParam(":id", $id);
	$stmt->bindParam(":phone", $phone);
	$stmt->bindParam(":user_id", $user_id);
	$stmt->bindParam(":addressee", $addressee);
	$stmt->bindParam(":address", $address);
	$stmt->bindParam(":country", $country);
	$stmt->bindParam(":is_default", $is_default);
	$stmt->execute();

	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);
?>
