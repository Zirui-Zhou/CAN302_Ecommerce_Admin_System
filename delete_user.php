<?php
    // 获取需要删除的用户的id
    $id = $_POST["id"];
    // 连接数据库
    $pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);

    // 准备 SQL 语句
    $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
    $stmt->execute([$id]);

    $stmt = $pdo->prepare("DELETE FROM user_info WHERE id = ?");
    $stmt->execute([$id]);

    // 返回操作结果
    //echo json_encode(["success" => true]);
?>
<script>
    console.log("hello");
</script>
<?php
    // 返回操作结果
    echo json_encode(["success" => true]);
?>