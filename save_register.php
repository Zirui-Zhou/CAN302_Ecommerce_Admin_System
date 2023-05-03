<?php
    include("uuid.php");
    $dsn = "mysql:host=localhost:3306;dbname=can302_ass1";
    $username = "root";
    $password = null;

    $pdo = new PDO($dsn, $username, $password);

    $salt = random_bytes(32);
    $encoded_salt = base64_encode($salt);

    $id = uuid::v4();

    $email = $_POST["email"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];

    
    $role = 1;

    $name = $_POST["name"];
    $birthday = $_POST["birthday"];

    $hashed_password = md5($password . $salt);
    $stmt = $pdo->prepare("INSERT INTO user (id, name, password, salt, role, state) VALUES (:id, :name, :password,:salt, :role, 1)");
    
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':role', $role); 
    $stmt->bindParam(':salt', $encoded_salt);

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
        echo "User info saved successfully!";
    } else {
        echo "An error occurred while saving data. Please try again later.";
    }
?>



