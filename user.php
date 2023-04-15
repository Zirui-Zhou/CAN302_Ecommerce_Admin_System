<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Charts - SB Admin</title>

    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/datatables.min.css" rel="stylesheet"/>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/datatables.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</head>
<body class="sb-nav-fixed">
<?php require("top_nav.php") ?>
<div id="layoutSidenav">
    <?php require("side_nav.php")?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">User</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-search"></i>
                        User Search
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">

                            </div>
                            <div class="col">
                            </div>
                            <div class="col d-flex justify-content-evenly align-items-center">

                                <div class="input-group ">

                  <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-search"></i>
                  </span>

                                    <input type="text" class="form-control" placeholder="Search Users by Name or ID" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">

                    <div class="card-body">
                        <div class="d-flex justify-content-evenly col-3">
                            <button type="button" class="btn btn-primary col-5">
                                <i class="bi bi-plus-circle"></i>
                                Add
                            </button>
                            <button type="button" class="btn btn-secondary col-5">
                                <i class="bi bi-trash3"></i>
                                Delete
                            </button>
                        </div>

                        <hr/>

                        <table class="table table-striped" style="vertical-align: middle; text-align: center" id="example">
                            <thead>
                            <tr>
                                <th ></th>
                                <th >ID</th>
                                <th >Name</th>
                                <th >Phone Number</th>
                                <th >Role</th>
                                <th >State</th>
                                <th class="col-2">Operation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);
                                $stmt = $pdo->prepare("
                                    select
                                        user.id as id, name, phone, role, state
                                    from user join user_info ui on user.id = ui.id
                                ");
                                $stmt->execute();
                                $lists = $stmt->fetchAll();

                                require_once ("utils.php");
                                $user_state = getUserStateList();
                                $user_role = getUserRoleList();

                            ?>
                            <?php
                                foreach($lists as $item){
                            ?>
                            <tr>
                                <td >
                                    <label>
                                        <input class="form-check-input" style="" type="checkbox" value="">
                                    </label>
                                </td>
                                <td >
                                    <?php
                                        echo $item["id"];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                        echo $item["name"];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                        echo $item["phone"];
                                    ?>
                                </td>
                                <td >
                                    <?php
                                        echo $user_role[$item["role"]]->getBadge()->getBadgeHtml();
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    echo $user_state[$item["state"]]->getBadge()->getBadgeHtml();
                                    ?>
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm col-5 mx-auto"
                                        onclick=<?php echo "\"location.href = 'user_detail.php?id={$item['id']}';\"" ?>
                                    >
                                        Detail
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm col-5 mx-auto">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </main>
        <?php require("footer.php")?>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            searching: false,
            ordering:  false,
            lengthMenu: [5, 10, 20],
            orderFixed: [ 0, "desc" ],
            columnDefs: [
                // Center align the header content of column 1
                { className: "dt-head-center", targets: "_all" },
                { orderable: false, targets: 0 }
            ]
        });

    });
</script>
</body>
</html>
