<?php
// 导入 utils.php 文件，里面包含了 getUserStateList 和 getUserRoleList 函数
require_once("utils.php");

// 获取数据库连接
$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);

// 获取用户搜索条件
$searchTerm = $_GET['searchTerm'];

// 构建 SQL 查询语句
$sql = "
    SELECT
        user.id as id, name, phone, role, state
    FROM
        user JOIN user_info ui ON user.id = ui.id
    WHERE
        user.id LIKE :searchTerm OR name LIKE :searchTerm
    ";

// 使用占位符来构建查询条件
$stmt = $pdo->prepare($sql);
$stmt->execute(['searchTerm' => "%$searchTerm%"]);

// 获取符合条件的用户列表
$users = $stmt->fetchAll();

// 获取用户状态列表和角色列表
$userStateList = getUserStateList();
$userRoleList = getUserRoleList();
?>

<!-- 在 HTML 中显示搜索结果 -->
<table class="table table-striped" style="vertical-align: middle; text-align: center" id="example">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Role</th>
            <th>State</th>
            <th class="col-2">Operation</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td>
                    <label>
                        <input class="form-check-input" style="" type="checkbox" value="">
                    </label>
                </td>
                <td>
                    <?= $user['id'] ?>
                </td>
                <td>
                    <?= $user['name'] ?>
                </td>
                <td>
                    <?= $user['phone'] ?>
                </td>
                <td>
                    <?= $userRoleList[$user['role']]->getBadge()->getBadgeHtml() ?>
                </td>
                <td>
                    <?= $userStateList[$user['state']]->getBadge()->getBadgeHtml() ?>
                </td>
                <td>
                    <button
                        type="button"
                        class="btn btn-primary btn-sm col-5 mx-auto"
                        onclick="location.href='user_detail.php?id=<?= $user['id'] ?>';"
                    >
                        Detail
                    </button>
                    <button type="button" class="btn btn-danger btn-sm col-5 mx-auto delete-btn">
                        Delete
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
