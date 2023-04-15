<?php
$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);
$stmt = $pdo->prepare("SELECT * from user_state");
$stmt->execute();
$arr = $stmt->fetchAll();
var_dump($arr);
echo $arr[0]["badge"];
var_dump(json_decode($arr[0]["badge"], True));