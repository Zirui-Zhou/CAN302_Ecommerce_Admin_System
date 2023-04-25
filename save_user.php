<?php
  $pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);

  $id = $_POST["id"];
  $name = $_POST["name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $birthday = $_POST["birthday"];
  $role = $_POST["role"];
  $state = $_POST["state"];

  // Update the user table
  $stmt = $pdo->prepare("
    UPDATE user
    SET name = :name, role = :role, state = :state
    WHERE id = :id
  ");
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":role", $role);
  $stmt->bindParam(":state", $state);
  $stmt->execute();

  // Update the user_info table
  $stmt = $pdo->prepare("
    UPDATE user_info
    SET email = :email, phone = :phone, birthday = :birthday
    WHERE id = :id
  ");
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":phone", $phone);
  $stmt->bindParam(":birthday", $birthday);
  $stmt->execute();

  // Update the address table 
  $stmt = $pdo->prepare("
    UPDATE address
    SET phone = :phone, addressee = :name
    WHERE user_id = :id
  ");
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":phone", $phone);
  $stmt->bindParam(":name", $name);
  $stmt->execute();

  // Update the payment table 
  $stmt = $pdo->prepare("
    UPDATE payment
    SET account = :name
    WHERE user_id = :id
  ");
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":name", $name);
  $stmt->execute();
  echo "User information saved successfully.";
?>
