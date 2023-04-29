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
    // 添加下拉菜单
    $role = $_POST["role"];
    $role_options = array("1" => "Option 1", "2" => "Option 2");
    $name = $_POST["name"];

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

    $stmt2 = $pdo->prepare("INSERT INTO user_info (id, email, phone) VALUES (:id, :email, :phone)");
    $stmt2->bindParam(':id', $id);
    $stmt2->bindParam(':email', $email);
    $stmt2->bindParam(':phone', $phone); 

    if ($stmt2->execute()) {
        echo "Data saved successfully!";
    } else {
        echo "An error occurred while saving data. Please try again later.";
    }
    
    
?>





