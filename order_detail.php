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
        id, addressee, phone, country, address, is_default
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

  <?php require ("dependency.php") ?>

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


                    <select class="selectpicker" id="order_state_input">
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
                          id="order_time_input"
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
                      for="order_remark_input"
                      class="col-sm-2 col-form-label">
                    Remark:
                  </label>
                  <div class="col-sm-9">
                    <textarea
                        class="form-control"
                        id="order_remark_input"
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
                            for="user_id_input"
                            class="col-sm-2 col-form-label"
                        >
                          ID:
                        </label>
                        <div class="col-sm-10">
                          <input
                              class="form-control"
                              id="user_id_input"
                              value="<?php echo $user_info["id"] ?>"
                          >
                        </div>



                </div>
                <div class="row">

                  <div class="col">
                    <div class="row">
                      <label for="user_name_input" class="col-sm-4 col-form-label">Name:</label>
                      <div class="col-sm-8">
                        <input
                            class="form-control"
                            id="user_name_input"
                            value="<?php echo $user_info["name"] ?>"
                            disabled
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="row">
                      <label for="user_phone_input" class="col-sm-4 col-form-label">Phone:</label>
                      <div class="col-sm-8">
                        <input
                                class="form-control"
                                type="tel"
                                id="user_phone_input"
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
                    <button type="button" class="btn btn-secondary col-4 user_check_btn">
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
                  <label for="user_state_input" class="col-sm-4 col-form-label">State:</label>
                  <div class="col-sm-8">


                    <select class="selectpicker col-sm-12" id="user_state_input" disabled>
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
                <label for="user_email_input" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-10">
                  <input
                      class="form-control"
                      id="user_email_input"
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
              <div class="col  col-8">
                <div class="row mb-3">

                  <label
                      for="address_id_input"
                      class="col-sm-2 col-form-label"
                  >
                    ID:
                  </label>
                  <select
                      class="selectpicker col-sm-10"
                      id="address_id_input"
                  >
                  </select>


                </div>
              </div>
                <div class="col  col-12">
                <div class="row">
                  <div class="col">
                    <div class="row">
                      <label
                          for="address_addressee_input"
                          class="col-sm-4 col-form-label">
                        Addressee:
                      </label>
                      <div class="col-sm-8">
                        <input
                            class="form-control"
                            id="address_addressee_input"
                            value="<?php echo $address["addressee"] ?>"
                            disabled
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="row">
                      <label
                          for="address_phone_input"
                          class="col-sm-4 col-form-label">
                        Phone:
                      </label>
                      <div class="col-sm-8">
                        <input
                            class="form-control"
                            type="tel"
                            id="address_phone_input"
                            name="phone"
                            pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}"
                            value="<?php echo $address["phone"] ?>"
                            onblur="reportValidity()"
                            disabled
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="row">
                      <label
                          for="address_default_input"
                          class="col-sm-4 col-form-label">
                        Default:
                      </label>
                      <div class="col-sm-8">
                        <input
                            type="checkbox"
                            id="address_default_input"
                            data-toggle="toggle"
                            data-width="100"
                            data-onlabel="Yes"
                            data-offlabel="No"
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>


            </div>
            <div class="row mt-3 ">
              <div class="col col-4">
                <div class="row">
                  <label
                      for="address_country_input"
                      class="col-sm-4 col-form-label">
                    Country:
                  </label>
                  <div class="col-sm-8">

                    <select class="selectpicker col-sm-12" id="address_country_input" disabled>
                      <?php
                      foreach ($country as $key=>$value) {
                        $icon = strtolower($key);
                        echo "
                            <option
                                value='{$key}'
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
                      for="address_address_input"
                      class="col-sm-2 col-form-label"
                  >
                    Address:
                  </label>
                  <div class="col-sm-10">
                    <input
                        class="form-control"
                        id="address_address_input"
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
                      for="payment_id_input"
                      class="col-sm-2 col-form-label"
                  >
                    ID:
                  </label>
                  <select
                      class="selectpicker col-sm-10"
                      id="payment_id_input"
                  >
                  </select>
                </div>
                <div class="row  mb-3">
                  <div class="col">
                    <div class="row">
                      <label
                          for="payment_type_input"
                          class="col-sm-4 col-form-label">
                        Type:
                      </label>
                      <div class="col-sm-8">
                        <input
                            id="payment_type_input"
                            class="form-control"
                            disabled
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="row">
                      <label
                          for="payment_platform_input"
                          class="col-sm-4 col-form-label">
                        Platform:
                      </label>
                        <select
                            id="payment_platform_input"
                            class="selectpicker col-sm-8"
                            disabled
                        >
                          <?php
                          foreach ($payment_platform as $key=>$value) {

                            $icon = strtolower($key);
                            echo "
                            <option
                                value='{$key}'
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
                <div class="row">
                  <div class="col">
                    <div class="row">
                      <label
                          for="payment_account_input"
                          class="col-sm-4 col-form-label">
                        Account:
                      </label>
                      <div class="col-sm-8">
                        <input
                            id="payment_account_input"
                            class="form-control"
                            disabled
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="row">
                      <label
                          for="payment_default_input"
                          class="col-sm-4 col-form-label">
                        Default:
                      </label>
                      <input
                          type="checkbox"
                          id="payment_default_input"
                          data-toggle="toggle"
                          data-width="100"
                          data-onlabel="Yes"
                          data-offlabel="No"
                      >
                    </div>
                  </div>
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
                        id="payment_amount_input"
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
            <div class="d-flex justify-content-evenly col-3 mb-3">
              <button id="top_add_btn" type="button" class="btn btn-primary col-5">
                <i class="bi bi-plus-circle"></i>
                Add
              </button>
              <button type="button" class="btn btn-secondary col-5">
                <i class="bi bi-trash3"></i>
                Delete
              </button>
            </div>

            <hr/>

            <table
                class="table table-striped"
                style="vertical-align: middle; text-align: center"
                id="product_table"
            >
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
              <button id="save_btn" type="button" class="btn btn-primary">
                <i class="bi bi-save"></i>
                Save Changes
              </button>
              <button id="back_btn" type="button" class="btn btn-secondary">
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

<script src="./scripts/utils/requestUtils.js"></script>
<script src="./scripts/utils/commonUtils.js"></script>
<script src="./scripts/api/user.js"></script>
<script src="./scripts/api/address.js"></script>
<script src="./scripts/api/payment.js"></script>
<script src="./scripts/api/product.js"></script>
<script src="./scripts/api/order.js"></script>
<script>
  let address_list = []
  let payment_list = []
  let product_list = []
  let product_table = null


  $(document).ready(async function () {
    await initialize()
    product_table = $('#product_table').DataTable({
      searching: false,
      ordering: false,
      lengthMenu: [5, 10, 20],
      orderFixed: [0, "desc"],
      ajax: {
        url: "api/order/get_product_list.php",
        type: "POST",
        data: ()=>JSON.stringify({
          "id": getUrlParameter("id")
        }),
        dataSrc: function(d){
          product_list = d
          return d;
        },
        "datatype": "jsonp"
      },
      columns: [
        {
          "data": null,
          "render": function (data, type, row, meta) {
            return $('<input>')
                .attr("class", "form-check-input")
                .attr("type", "checkbox")
                .prop("outerHTML")
          }
        },
        {
          "data": "product_id"
        },
        {
          "data": "name"
        },
        {
          "data": null,
          "render": function (data, type, row, meta) {
            // console.log(data)
            return $('<img>')
                .attr("src", data["image_url"])
                .attr("alt", data["name"])
                .attr("style", "height: 80px")
                .prop("outerHTML")
          }
        },
        {
          "data": "category"
        },
        {
          "data": null,
          "render": function (data, type, row, meta) {
            return `${data["price"]} ${data["price_unit"]}`
          }
        },
        {
          "data": "number"
        },
        {
          "data": null,
          "render": function (data, type, row, meta) {
            return `${data["price"]*data["number"]} ${data["price_unit"]}`
          }
        },
        {
          "data": null,
          "render": function (data, type, row, meta) {
            return `
              <td>
                <button type="button" class="btn btn-danger btn-sm col-5 mx-auto" onclick="delete_product_item('${data['id']}')">
                  Delete
                </button>
              </td>
          `
          }
        },
      ],
      columnDefs: [
        // Center align the header content of column 1
        {className: "dt-head-center", targets: "_all"},
        {orderable: false, targets: 0}
      ]
    });

    console.log(product_table.rows().data().toArray())

    $("#product_table").find("thead").after(
        `<tbody>
        <tr id="new_item_input_tr">
        <td >
        <label>
        <input class="form-check-input" style="" type="checkbox" value="" disabled>
    </label>
  </td>
    <td >
      <div class="input-group">
        <input type="text" class="form-control" style="text-align:center" id="new_product_id_input">
          <div class="input-group-append">
            <button type="button" class="btn btn-secondary" id="new_product_check_btn">
              <i class="bi bi-arrow-clockwise"></i>
            </button>
          </div>
      </div>

    </td>
    <td >
      <input id="new_product_name_input" type="text" class="form-control name_input" disabled>
    </td>
    <td >
      <img
          id="new_product_image_input"
          src=""
          alt=""
          class="img-fluid"
          style="height: 80px"
          disabled
      >
    </td>
    <td>
      <input type="text" id="new_product_category_input" class="form-control" disabled>
    </td>
    <td >
      <input type="text" id="new_product_price_input" class="form-control" disabled>
    </td>
    <td >
      <input type="number" id="new_product_number_input" min="1" class="form-control" >
    </td>
    <td >
      <input type="text" id="new_product_amount_input" class="form-control" disabled>
    </td>
    <td>
      <button id="new_product_confirm_btn" type="button" class="btn btn-primary btn-sm col-6 mx-auto">
        Confirm
      </button>
      <button id="new_product_cancel_btn" type="button" class="btn btn-danger btn-sm col-5 mx-auto">
        Cancel
      </button>
    </td>
  </tr>
    </tbody>`
    )

    $("#new_item_input_tr").hide();

    $('.user_check_btn').click(async function () {
      const userinfo = await search_user_by_id($("#user_id_input").val())
      $("#user_name_input").val(userinfo["name"])
      $("#user_phone_input").val(userinfo["phone"])
      $("#user_state_input").val(userinfo["state"])
      $("#user_email_input").val(userinfo["email"])

      const address_data = await search_address_by_user_id(userinfo["id"])
      address_list = Object.fromEntries(address_data.map(x => [x.id, x]));
      select_change_options($("#address_id_input"), Object.keys(address_list))
      refresh_address_info()

      const payment_data = await search_payment_by_user_id(userinfo["id"])
      payment_list = Object.fromEntries(payment_data.map(x => [x.id, x]));
      select_change_options($("#payment_id_input"), Object.keys(payment_list))
      refresh_payment_info()
    })

    $("#new_product_check_btn").click(async function () {
      const product_info = await search_product_in_order_by_id($("#new_product_id_input").val())
      refresh_new_product_info(product_info)
    })

    $("#address_id_input").on("change", function () {
      refresh_address_info(address_list[$(this).find(":selected").val()])
    })

    $("#payment_id_input").on("change", function () {
      refresh_payment_info(payment_list[$(this).find(":selected").val()])
    })

    $("#top_add_btn").click(function () {
      change_elem_visible($("#new_item_input_tr"))
    })

    $("#new_product_confirm_btn").click(function () {
      add_product(
          getUrlParameter("id"),
          $("#new_product_number_input").val(),
          $("#new_product_id_input").val(),
      )
      change_elem_visible($("#new_item_input_tr"))
      product_table.ajax.reload()
    })

    $("#new_product_cancel_btn").click(function () {
      change_elem_visible($("#new_item_input_tr"))
    })

    $("#save_btn").click(function () {
      update_order(
          getUrlParameter("id"),
          $("#order_state_input").val(),
          $("#order_time_input").val(),
          $("#order_remark_input").val(),
          $("#user_id_input").val(),
          $("#address_id_input").val(),
          $("#payment_id_input").val(),
          $("#payment_amount_input").val(),
      )
      location.href="order.php"
    })
    $("#back_btn").click(function () {
      location.href="order.php"
    })
  });

  async function initialize() {
    $('#address_default_input').bootstrapToggle();

    product_list = await get_product_list(getUrlParameter("id"))
    console.log(product_list)

    const address_data = await search_address_by_user_id("<?php echo $user_info["id"] ?>")
    address_list = Object.fromEntries(address_data.map(x => [x.id, x]));
    select_change_options($("#address_id_input"), Object.keys(address_list), "<?php echo $address["id"] ?>")
    refresh_address_info(address_list["<?php echo $address["id"] ?>"])

    const payment_data = await search_payment_by_user_id("<?php echo $user_info["id"] ?>")
    payment_list = Object.fromEntries(payment_data.map(x => [x.id, x]));
    select_change_options($("#payment_id_input"), Object.keys(payment_list), "<?php echo $payment["id"] ?>")
    refresh_payment_info(payment_list["<?php echo $payment["id"] ?>"])
  }

  function refresh_address_info(address_info=null) {
    $("#address_id_input").val(address_info ? address_info["id"] : null)
    $("#address_id_input").selectpicker('refresh');
    $("#address_addressee_input").val(address_info ? address_info["addressee"] : null)
    $("#address_phone_input").val(address_info ? address_info["phone"] : null)
    const address_default_input = $('#address_default_input')
    address_default_input.bootstrapToggle('enable')
    address_default_input.bootstrapToggle(address_info!==null && address_info["is_default"] ? 'on' : 'off');
    address_default_input.bootstrapToggle('disable')
    $("#address_country_input").val(address_info ? address_info["country"] : null)
    $("#address_country_input").selectpicker('refresh');
    $("#address_address_input").val(address_info ? address_info["address"] : null)
  }

  function refresh_payment_info(payment_info=null) {
    $("#payment_id_input").val(payment_info ? payment_info["id"] : null)
    $("#payment_id_input").selectpicker('refresh');
    $("#payment_type_input").val(payment_info ? payment_info["type"] : null)
    $("#payment_platform_input").val(payment_info ? payment_info["platform"] : null)
    $("#payment_platform_input").selectpicker('refresh');
    $("#payment_account_input").val(payment_info ? payment_info["account"] : null)
    const payment_default_input = $('#payment_default_input')
    payment_default_input.bootstrapToggle('enable')
    payment_default_input.bootstrapToggle(payment_info!==null && payment_info["is_default"] ? 'on' : 'off');
    payment_default_input.bootstrapToggle('disable')
  }

  function refresh_new_product_info(order_info=null) {
    $("#new_product_name_input").val(order_info ? order_info["name"] : null)
    $("#new_product_image_input").attr("src", order_info ? order_info["image_url"] : null)
    $("#new_product_category_input").val(order_info ? order_info["category"] : null)
    $("#new_product_price_input").val(order_info ? order_info["price"] : null)
    $("#new_product_number_input").val(null)
    $("#new_product_amount_input").val(null)
  }

  function delete_product_item(id) {
    delete_product(id)
    product_table.ajax.reload()
  }

  function select_change_options(select, options, selected=null) {
    select.empty();
    options.forEach((value) => {
      select.append(
          `<option value="${value}">${value}</option>`
      )
    })
    if(selected) {
      select.val(selected)
    }
    select.selectpicker('refresh');
  }

  function change_elem_visible(elem) {
    if(elem.is(":visible")) {
      elem.hide();
    } else {
      elem.show();
    }
  }

</script>
</body>
</html>
