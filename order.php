<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Charts - SB Admin</title>

  <?php require ("dependency.php") ?>
</head>
<body class="sb-nav-fixed">
<?php require("top_nav.php") ?>
<div id="layoutSidenav">
  <?php require("side_nav.php")?>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <h1 class="mt-4">Order</h1>
        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-search"></i>
            Order Search
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

                  <input type="text" class="form-control" placeholder="Search Orders by Name or ID" aria-describedby="basic-addon1">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-clipboard-check"></i>
            Order Records
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-evenly col-3">

              <button id="top_add_btn" type="button" class="btn btn-primary col-5" disabled>
                <i class="bi bi-plus-circle"></i>
                Add
              </button>
              <div class="col-5"></div>
            </div>

            <hr/>

            <table class="table table-striped" style="vertical-align: middle; text-align: center" id="example2">
              <thead>
              <tr>
                <th ></th>
                <th >ID</th>
                <th >State</th>
                <th class="col-1">Customer</th>
                <th >Time</th>
                <th> Price</th>
                <th class="col-2">Remark</th>
                <th >Operation</th>
              </tr>
              </thead>
              <tbody>
              <?php

              require_once ("utils.php");
              $pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);
              $stmt = $pdo->prepare("
                select
                    `order`.id as id , `order`.state as state, payment_time, payment_amount, 
                    remark, user.name as username
                from `order`
                left join user on `order`.user_id = user.id
              ");
              $stmt->execute();
              $order_list = $stmt->fetchAll();
              $order_state = getOrderStateList();

              foreach ($order_list as $order) {
              ?>
                <tr>
                  <td >
                    <label>
                      <input class="form-check-input" style="" type="checkbox" value="">
                    </label>
                  </td>
                  <td>
                    <?php echo $order["id"] ?>
                  </td>
                  <td >
                    <?php echo $order_state[$order["state"]]->getBadge()->getBadgeHtml() ?>
                  </td>
                  <td>
                    <?php echo $order["username"] ?>
                  </td>
                  <td >
                    <?php echo $order["payment_time"] ?>
                  </td>
                  <td >
                    <?php echo $order["payment_amount"] ?> CNY
                  </td>
                  <td >
                    <?php echo $order["remark"] ?>
                  </td>

                  <td class="col-2">
                    <button
                        onclick=<?php echo "\"location.href = 'order_detail.php?id={$order['id']}';\"" ?>
                        type="button"
                        class="btn btn-primary btn-sm col-5 mx-auto"
                    >
                      Edit
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

<script src="./scripts/utils/requestUtils.js"></script>
<script src="./scripts/api/order.js"></script>
<script>
  $(document).ready(function () {
    refresh();
    console.log("b");
    // const Username=showUserInfo();
    $(".logout-btn").click(function () {
      console.log("a");
      logout();
    });
    $('#example2').DataTable({
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
  function refresh(){
    console.log(Cookies.get('token'));
    if(Cookies.get('token')==undefined){
      window.location.href="login.php";
    }
  }
  function logout(){
    console.log("b");
    Cookies.remove("token");
    refresh();
  }
</script>
</body>
</html>
