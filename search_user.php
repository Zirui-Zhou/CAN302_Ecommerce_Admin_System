<?php
// ���� utils.php �ļ������������ getUserStateList �� getUserRoleList ����
require_once("utils.php");

// ��ȡ���ݿ�����
$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);

// ��ȡ�û���������
$searchTerm = $_GET['searchTerm'];

// ���� SQL ��ѯ���
$sql = "
    SELECT
        user.id as id, name, phone, role, state
    FROM
        user JOIN user_info ui ON user.id = ui.id
    WHERE
        user.id LIKE :searchTerm OR name LIKE :searchTerm
    ";

// ʹ��ռλ����������ѯ����
$stmt = $pdo->prepare($sql);
$stmt->execute(['searchTerm' => "%$searchTerm%"]);

// ��ȡ�����������û��б�
$users = $stmt->fetchAll();

// ��ȡ�û�״̬�б�ͽ�ɫ�б�
$userStateList = getUserStateList();
$userRoleList = getUserRoleList();
?>

<!-- �� HTML ����ʾ������� -->
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
