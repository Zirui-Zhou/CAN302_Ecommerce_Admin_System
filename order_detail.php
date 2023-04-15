<?php
if(isset($_GET['id'])) {
  $order_id = $_GET['id'];
} else {
  header('Location: '."404.php");
  exit();
}

$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);
$stmt = $pdo->prepare("
    select
        id, state, address_id, payment_id, user_id,
        payment_time, payment_amount, remark
    from `order`
    where id = '{$order_id}'
");
$stmt->execute();
$order_info = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
    select
        user.id as id, name, state, phone, email
    from user left join user_info ui on user.id = ui.id
    where user.id = '{$order_info["user_id"]}'
");
$stmt->execute();
$user_info = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
    select
        id, addressee, phone, country, address
    from address
    where id = '{$order_info["address_id"]}'
");
$stmt->execute();
$address = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
    select
        id, platform, account
    from payment
    where id = '{$order_info["payment_id"]}'
");
$stmt->execute();
$payment = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
    select
        p.id as id, p.name as name, p.image_url as image_url,
        c.name as category, p.price as price, p.price_unit as price_unit,
        op.number as number
    from order_product_list op 
        left join product p on op.product_id = p.id
        left join category c on p.category = c.id
    where order_id = '{$order_info["id"]}'
");
$stmt->execute();
$product_list = $stmt->fetchAll();


require_once ("utils.php");
$user_state = getUserStateList();
$order_state = getOrderStateList();
$country = getCountryList();
$payment_platform = getPaymentPlatformList();
?>

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

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

  <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"
  />

</head>
<body class="sb-nav-fixed">
<?php require("top_nav.php") ?>
<div id="layoutSidenav">
  <?php require("side_nav.php") ?>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <h1 class="mt-4">Order Detail</h1>

        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-clipboard"></i>
            Order Information
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col col-8">
                <div class="row">
                  <div class="mb-3 row">
                    <label
                        for="inputOrderId"
                        class="col-sm-2 col-form-label">
                      ID:
                    </label>
                    <div class="col-sm-10">
                      <input
                          class="form-control"
                          id="inputOrderId"
                          disabled
                          value="<?php echo $order_info["id"] ?>"
                      >
                    </div>
                  </div>

                </div>

              </div>

            </div>
            <div class="row">
              <div class="col col-4">
                <div class="mb-3 row">
                  <label for="inputAmount" class="col-sm-4 col-form-label">State:</label>
                  <div class="col-sm-7">


                    <select class="selectpicker" id="inputRole">
                      <?php
                      foreach ($order_state as $key=>$value) {
                        $selected = $key===$order_info["state"] ? "selected" : "";
                        echo "
                        <option 
                            value='{$key}' {$selected} 
                            data-content='{$value->getBadge()->getBadgeHtml()}'
                        ></option>
                    ";
                      }
                      ?>

                    </select>

                  </div>
                </div>
              </div>
              <div class="col col-4">
                <div class="row">
                  <div class="mb-3 row">
                    <label
                        class="col-sm-4 col-form-label"
                    >
                      Time:
                    </label>
                    <div class="col-sm-8">
                      <input
                          class="form-control"
                          type="datetime-local"
                          value="<?php echo $order_info["payment_time"] ?>"
                      >
                    </div>
                  </div>

                </div>

              </div>

            </div>
            <div class="row">

              <div class="col col-8">
                <div class="row">
                  <label
                      for="inputRemark"
                      class="col-sm-2 col-form-label">
                    Remark:
                  </label>
                  <div class="col-sm-9">
                    <textarea
                        class="form-control"
                        id="inputRemark"
                        style="resize: none"
                        rows="3"><?php
                      echo $order_info["remark"]
                    ?></textarea>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-person-circle"></i>
            User Information
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col col-8">
                <div class="row mb-3">


                        <label
                            for="inputId"
                            class="col-sm-2 col-form-label"
                        >
                          ID:
                        </label>
                        <div class="col-sm-10">
                          <input
                              class="form-control"
                              id="inputId"
                              value="<?php echo $user_info["id"] ?>"
                          >
                        </div>



                </div>
                <div class="row">

                  <div class="col">
                    <div class="row">
                      <label for="inputName" class="col-sm-4 col-form-label">Name:</label>
                      <div class="col-sm-8">
                        <input
                            class="form-control"
                            id="inputName"
                            value="<?php echo $user_info["name"] ?>"
                            disabled
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="row">
                      <label for="inputPhoneNumber" class="col-sm-4 col-form-label">Phone:</label>
                      <div class="col-sm-8">
                        <input
                                class="form-control"
                                type="tel"
                                id="inputPhoneNumber"
                                name="phone"
                                pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}"
                                value="<?php echo $user_info["phone"] ?>"
                                onblur="reportValidity()"
                                disabled
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col col-4 d-flex justify-content-evenly" style="flex-direction: column">
                  <div class="row d-flex justify-content-evenly">
                    <button type="button" class="btn btn-secondary col-4">
                      <i class="bi bi-arrow-clockwise"></i>
                      Check
                    </button>
                    <button type="button" class="btn btn-primary col-4">
                      <i class="bi bi-check"></i>
                      Confirm
                    </button>
                  </div>
                </div>

            </div>
            <div class="row mt-3 ">
              <div class="col col-4">
                <div class="row">
                  <label for="inputAmount" class="col-sm-4 col-form-label">State:</label>
                  <div class="col-sm-8">


                    <select class="selectpicker" id="inputRole" disabled>
                      <?php
                      foreach ($user_state as $key=>$value) {
                        $selected = $key===$user_info["state"] ? "selected" : "";
                        echo "
                            <option
                                value='{$key}' {$selected}
                                data-content='{$value->getBadge()->getBadgeHtml()}'
                            ></option>
                        ";
                      }
                      ?>

                    </select>

                  </div>
                </div>

              </div>
              <div class="col col-8">
              <div class="row">
                <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-10">
                  <input
                      class="form-control"
                      id="inputEmail"
                      type="email"
                      value="<?php echo $user_info["email"] ?>"
                      onblur="reportValidity()"
                      disabled
                  >
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-truck"></i>
            Delivery Information
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col col-8">
                <div class="row mb-3">

                  <label
                      for="inputId"
                      class="col-sm-2 col-form-label"
                  >
                    ID:
                  </label>
                  <div class="col-sm-10">
                    <input
                        class="form-control"
                        id="inputId"
                        value="<?php echo $address["id"] ?>"
                    >
                  </div>



                </div>
                <div class="row">

                  <div class="col">
                    <div class="row">
                      <label
                          for="inputName"
                          class="col-sm-4 col-form-label">
                        Addressee:
                      </label>
                      <div class="col-sm-8">
                        <input
                            class="form-control"
                            id="inputName"
                            value="<?php echo $address["addressee"] ?>"
                            disabled
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="row">
                      <label
                          for="inputPhoneNumber"
                          class="col-sm-4 col-form-label">
                        Phone:
                      </label>
                      <div class="col-sm-8">
                        <input
                            class="form-control"
                            type="tel"
                            id="inputPhoneNumber"
                            name="phone"
                            pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}"
                            value="<?php echo $address["phone"] ?>"
                            onblur="reportValidity()"
                            disabled
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                  class="col col-4 d-flex justify-content-evenly"
                  style="flex-direction: column"
              >
                <div class="row d-flex justify-content-evenly">
                  <button type="button" class="btn btn-secondary col-4">
                    <i class="bi bi-arrow-clockwise"></i>
                    Check
                  </button>
                  <button type="button" class="btn btn-primary col-4">
                    <i class="bi bi-check"></i>
                    Confirm
                  </button>
                </div>
              </div>

            </div>
            <div class="row mt-3 ">
              <div class="col col-4">
                <div class="row">
                  <label
                      for="inputAmount"
                      class="col-sm-4 col-form-label">
                    Country:
                  </label>
                  <div class="col-sm-8">

                    <select class="selectpicker" disabled>
                      <?php
                      foreach ($country as $key=>$value) {
                        $selected = $key===$address["country"] ? "selected" : "";
                        $icon = strtolower($key);
                        echo "
                            <option
                                value='{$key}'
                                {$selected}
                                data-content='
                                    <span 
                                        class=\"fi fi-{$icon}\" 
                                        style=\"margin-right: 10px\">
                                    </span>
                                    {$value->getName()}'
                            ></option>
                        ";
                      }
                      ?>

                    </select>

                  </div>
                </div>

              </div>
              <div class="col col-8">
                <div class="row">
                  <label
                      class="col-sm-2 col-form-label">
                    Address:
                  </label>
                  <div class="col-sm-10">
                    <input
                        class="form-control"
                        value="<?php echo $address["address"] ?>"
                        disabled
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-credit-card-fill"></i>
            Payment Information
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col col-8">
                <div class="row mb-3">

                  <label
                      for="inputId"
                      class="col-sm-2 col-form-label"
                  >
                    ID:
                  </label>
                  <div class="col-sm-10">
                    <input
                        class="form-control"
                        id="inputId"
                        value="<?php echo $payment["id"] ?>"
                    >
                  </div>



                </div>
                <div class="row">

                  <div class="col">
                    <div class="row">
                      <label
                          class="col-sm-4 col-form-label">
                        Type:
                      </label>
                      <div class="col-sm-8">
                        <input
                            class="form-control"
                            value="<?php echo $payment_platform[$payment["platform"]]->getType() ?>"
                            disabled
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="row">
                      <label
                          for="inputAmount"
                          class="col-sm-4 col-form-label">
                        Platform:
                      </label>
                      <div class="col-sm-8">

                        <select class="selectpicker" disabled>
                          <?php
                          foreach ($payment_platform as $key=>$value) {
                            $selected = $key===$payment["platform"] ? "selected" : "";
                            $icon = strtolower($key);
                            echo "
                            <option
                                value='{$key}'
                                {$selected}
                                data-content='
                                    <i 
                                        class=\"{$value->getIcon()->getIcon()}\" 
                                        style=\"margin-right: 10px; color: {$value->getIcon()->getColor()}\">
                                    </i>
                                    {$value->getName()}'
                            ></option>
                        ";
                          }
                          ?>

                        </select>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                  class="col col-4 d-flex justify-content-evenly"
                  style="flex-direction: column"
              >
                <div class="row d-flex justify-content-evenly">
                  <button type="button" class="btn btn-secondary col-4">
                    <i class="bi bi-arrow-clockwise"></i>
                    Check
                  </button>
                  <button type="button" class="btn btn-primary col-4">
                    <i class="bi bi-check"></i>
                    Confirm
                  </button>
                </div>
              </div>

            </div>
            <hr>
            <div class="row mt-3 ">
              <div class="col col-4">
                <div class="row">
                  <label
                      class="col-sm-4 col-form-label">
                    Amount:
                  </label>
                  <div class="col-sm-8">
                    <input
                        class="form-control"
                        value="<?php echo $order_info["payment_amount"] ?>"
                    >
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-cart4"></i>
            Product List
          </div>
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
                <th >Image</th>
                <th >Category</th>
                <th >Price</th>
                <th >Number</th>
                <th >Amount</th>
                <th class="col-2">Operation</th>
              </tr>
              </thead>
              <tbody>
              <?php
              foreach ($product_list as $product) {
              ?>
              <tr>
                <td >
                  <label>
                    <input class="form-check-input" style="" type="checkbox" value="">
                  </label>
                </td>
                <td >
                  <?php echo $product["id"] ?>
                </td>
                <td >
                  <?php echo $product["name"] ?>
                </td>
                <td >
                  <img
                      src="<?php echo $product["image_url"] ?>"
                      alt="<?php echo $product["name"] ?>"
                      style="height: 80px"
                  >
                </td>
                <td >
                  <?php echo $product["category"] ?>
                </td>
                <td >
                  <?php echo "{$product["price"]} {$product["price_unit"]}" ?>
                </td>
                <td >
                  <?php echo $product["number"] ?>
                </td>
                <td >
                  <?php
                  $amount = $product["price"] * $product["number"];
                  echo "{$amount} {$product["price_unit"]}"
                  ?>
                </td>
                <td >
                  <button type="button" class="btn btn-primary btn-sm col-5 mx-auto">
                    Edit
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

        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-check-square"></i>
            Confirm Modification
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-evenly col-4 mx-auto" style="margin-bottom: 0">
              <button type="button" class="btn btn-primary">
                <i class="bi bi-save"></i>
                Save Changes
              </button>
              <button type="button" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Back
              </button>

            </div>

          </div>
        </div>

      </div>
    </main>
    <?php require("footer.php") ?>
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
    $('#inputPhoneNumber').keyup(function(){
      $(this).val($(this).val().replace(/(\d{3})\-?(\d{4})\-?(\d{4})/,'$1-$2-$3'))
    });
  });


</script>
</body>
</html>
