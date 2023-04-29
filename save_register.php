<?php
    include("uuid.php");
    $dsn = "mysql:host=localhost:3316;dbname=can302_ass1";
    $username = "root";
    $password = null;

    $pdo = new PDO($dsn, $username, $password);

    $id = uuid::v4();
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $role = $_POST["role"];
    $role_options = array("1" => "Option 1", "2" => "Option 2");
    $name = $_POST["name"];
    $birthday = $_POST["birthday"];

    $stmt = $pdo->prepare("INSERT INTO user (id, name, password, role) VALUES (:id, :name, :password, :role)");
    
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role_option); 

    if ($stmt->execute()) {
        echo "Data saved successfully!";
    } else {
        echo "An error occurred while saving data. Please try again later.";
    }

    $stmt2 = $pdo->prepare("INSERT INTO user_info (id, email, phone, birthday) VALUES (:id, :email, :phone, :birthday)");
    $stmt2->bindParam(':id', $id);
    $stmt2->bindParam(':email', $email);
    $stmt2->bindParam(':phone', $phone); 
    $stmt2->bindParam(':birthday', $birthday); 

    if ($stmt2->execute()) {
        echo "Data saved successfully!";
    } else {
        echo "An error occurred while saving data. Please try again later.";
    }
    
    
?>





