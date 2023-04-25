<?php
  if(isset($_GET['id'])) {
    $user_id = $_GET['id'];
  } else {
    header('Location: '."404.php");
    exit();
  }
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

  <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>

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
  <?php require("side_nav.php")?>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <h1 class="mt-4">User Detail</h1>
        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-person-circle"></i>
            Basic Information
          </div>
          <?php
            $pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);
            $stmt = $pdo->prepare("
                                      select
                                          user.id as id, name, phone, role, state, email, birthday
                                      from user join user_info ui on user.id = ui.id
                                      where user.id = '{$user_id}'
                                  ");
            $stmt->execute();
            $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

            require_once ("utils.php");
            $user_state = getUserStateList();
            $user_role = getUserRoleList();

          ?>
          <div class="card-body">
            <div class="row">
              <div class="col col-8">
                <div class="mb-3 row">
                  <label for="inputId" class="col-sm-2 col-form-label">ID:</label>
                  <div class="col-sm-6">
                    <input class="form-control" id="inputId" disabled value="<?php echo $user_info["id"] ?>">
                  </div>
                </div>
              </div>


            </div>
            <div class="row">
              <div class="col col-4">
                <div class="mb-3 row">
                  <label for="inputName" class="col-sm-4 col-form-label">Name:</label>
                  <div class="col-sm-8">
                    <input class="form-control" id="inputName" value="<?php echo $user_info["name"] ?>">
                  </div>
                </div>
              </div>
              <div class="col col-8">
                <div class="mb-3 row">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
                  <div class="col-sm-6">
                    <input class="form-control" id="inputEmail" type="email" value="<?php echo $user_info["email"] ?>" onblur="reportValidity()">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col col-4">
                <div class="mb-3 row">
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
                    >
                  </div>
                </div>
              </div>
              <div class="col col-4">
                <div class="mb-3 row">
                  <label for="inputBirth" class="col-sm-4 col-form-label">Birthday:</label>
                  <div class="col-sm-8">
                    <input class="form-control" id="inputBirth" type="date" value="<?php echo $user_info["birthday"] ?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col col-4">
                <div class="mb-3 row">
                  <label for="inputRole" class="col-sm-4 col-form-label">Role:</label>
                  <div class="col-sm-8">
                    <select class="selectpicker badge_select" id="inputRole">
                      <?php
                      foreach ($user_role as $key=>$value) {
                        $selected = $key===$user_info["role"] ? "selected" : "";
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
                <div class="mb-3 row">
                  <label for="inputState" class="col-sm-4 col-form-label">State:</label>
                  <div class="col-sm-8">
                    <select class="selectpicker badge_select" id="inputState">
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
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-geo-alt-fill"></i>
            Common Addresses
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-evenly col-3">
              <button type="button" class="btn btn-primary col-5" id = "add-address-btn">
                <i class="bi bi-plus-circle"></i>
                Add
              </button>
              <button type="button" class="btn btn-secondary col-5">
                <i class="bi bi-trash3"></i>
                Delete
              </button>
            </div>

            <hr>

            <table class="table table-striped" style="vertical-align: middle; text-align: center" id="example">
              <thead>
              <tr>
                <th ></th>
                <th >ID</th>
                <th >Addressee</th>
                <th >Phone</th>
                <th >Country</th>
                <th >Address</th>
                <th >Default</th>
                <th >Operation</th>
              </tr>
              </thead>
              <tbody>
              <?php
              $stmt = $pdo->prepare("
                select
                    *
                from address
                where user_id = '{$user_id}'
              ");
              $stmt->execute();
              $order_list = $stmt->fetchAll();

              $country = getCountryList();

              foreach ($order_list as $item) {
              ?>
              <tr>
                <td >
                  <label>
                    <input class="form-check-input" style="" type="checkbox" value="">
                  </label>
                </td>
                <td>
                  <?php echo $item["id"] ?>
                </td>
                <td >
                  <?php echo $item["addressee"] ?>
                </td>
                <td >
                  <span style="white-space: nowrap;">
                    <?php echo $item["phone"] ?>
                  </span>
                </td>
                <td class=" col-2" >
                    <select class="selectpicker" disabled id = "country-select">
                      <?php
                      foreach ($country as $key=>$value) {
                        $selected = $key===$item["country"] ? "selected" : "";
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
                </td>
                <td class="col-3">
                  <?php echo $item["address"] ?>
                </td>
                <td >

                    <input type="checkbox" class="form-check-input" <?php echo $item["is_default"] ? "checked" : "" ?> id="checkDefault" disabled>

                </td>
                <td class="col-2">
                  <button type="button" class="btn btn-primary btn-sm col-5 mx-auto" id = "address-edit-btn">
                    Edit
                  </button>
                  <button type="button" class="btn btn-danger btn-sm col-5 mx-auto" id = "address-delete-btn">
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
            <i class="bi bi-wallet2"></i>
            Payment Methods
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

            <table class="table table-striped" style="vertical-align: middle; text-align: center" id="example1">
              <thead>
              <tr>
                <th ></th>
                <th >ID</th>
                <th >Type</th>
                <th >Platform</th>
                <th >Account</th>
                <th >Last Use Date</th>
                <th >Default</th>
                <th >Operation</th>
              </tr>
              </thead>
              <tbody>
              <?php
              $stmt = $pdo->prepare("
                select
                    payment.id as id, platform, account, is_default, max(`order`.payment_time) as time
                from payment
                left join `order` on payment.id = `order`.payment_id
                where payment.user_id = '{$user_id}'
                group by payment.id
              ");
              $stmt->execute();
              $payment_list = $stmt->fetchAll();
              $payment_platform = getPaymentPlatformList();

              foreach ($payment_list as $payment) {
                $platform = $payment_platform[$payment["platform"]];
              ?>
              <tr>

                <td >
                  <label>
                    <input class="form-check-input" style="" type="checkbox" value="">
                  </label>
                </td>

                <td>
                  <?php echo $payment["id"] ?>
                </td>
                <td >
                  <?php echo $platform->getType() ?>
                </td>
                <td >
                  <?php
                  echo "
                    {$platform->getIcon()->getIconHtml()}
                    {$platform->getName()}
                  "
                  ?>
                </td>
                <td >
                  <?php echo $payment["account"] ?>
                </td>
                <td >
                  <?php echo $payment["time"] ? $payment["time"] : "Never used" ?>
                </td>
                <td >

                  <input
                      type="checkbox"
                      class="form-check-input"
                      <?php echo $payment["is_default"] ? "checked" : "" ?>
                      disabled
                  >

                </td>
                <td class="col-2">
                  <button type="button" class="btn btn-primary btn-sm col-5 mx-auto" id = "edit-btn">
                    Edit
                  </button>
                  <button type="button" class="btn btn-danger btn-sm col-5 mx-auto" id = "delete-btn">
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
              <button type="button" class="btn btn-primary" id="save-btn">
                <i class="bi bi-save"></i>
                Save Changes
              </button>
              <button type="button" class="btn btn-secondary" id="back-btn">
                <i class="bi bi-arrow-left"></i>
                Back
              </button>

            </div>

          </div>
        </div>

      </div>
    </main>
    <?php require("footer.php")?>
  </div>
</div>

<script>
$('#address-edit-btn').click(function() {
  // 找到当前点击的edit按钮所在的那一行（tr）
  var row = $(this).closest('tr');

  // 找到默认复选框，并将其设置为可选状态
  var defaultCheckbox = row.find('input[type="checkbox"]');
  defaultCheckbox.prop('disabled', false);

  var countrySelect =row.find('select.selectpicker');
  countrySelect.prop('disabled',false);
});

// 监听“Add”按钮的点击事件
$('#add-address-btn').on('click', function() {
  // 创建新的行
  var newRow = $('<tr></tr>');

  var cell1 = $('<td><label><input class="form-check-input" style="" type="checkbox" value=""></label></td>');
   newRow.append(cell1);
   var cell2 = $('<td><?php echo $item["id"] ?></td>');
   newRow.append(cell2);
   var cell3 = $('<td ><?php echo $item["addressee"] ?></td>');
   newRow.append(cell3);
   var cell4 = $('<td > <span style="white-space: nowrap;"><?php echo $item["phone"] ?></span></td>');
   newRow.append(cell4);
   var cell5 = $('<td class="col-2"></td>');
  var select = $('#country-select'); // 获取 ID 为 mySelect 的元素
  cell5.append(select);
  newRow.append(cell5);
  var cell6 = $('<td class="col-3"></td>');
  var input = $('<input type="text" class="form-control">');
  input.css({
  'height': '100px',
});
  cell6.append(input);
  newRow.append(cell6);
  var cell7 = $('<td><input type="checkbox" class="form-check-input" <?php echo $item["is_default"] ? "checked" : "" ?> id="checkDefault" ></td>');
  newRow.append(cell7);
  //var cell8 = $('<td class="col-2"></tc>');
  // 添加“Confirm”按钮和"delete"按钮
  
var confirmAddressBtn = $('<button type="button" class="btn btn-primary btn-sm col-5 mx-auto confirm-btn">Confirm</button>');
confirmAddressBtn.css('white-space', 'nowrap'); // 设置不换行
var deleteAddressBtn = $('<button type="button" class="btn btn-danger btn-sm col-5 mx-auto" id = "address-delete-btn">Delete</button>');
newRow.append($('<td class="col-2"></td>').append(confirmAddressBtn).append($('<span></span>').css('width', '10px')).append(deleteAddressBtn).css('margin-left', '10px'));
//var cell8 = $('<td class="col-2"><button type="button" class="btn btn-primary btn-sm col-5 mx-auto" id = "edit-btn">Edit</button><button type="button" class="btn btn-danger btn-sm col-5 mx-auto" id = "delete-btn">Delete</button></td>');

  // 在表格最后添加新行
  $('#example tbody').append(newRow);
});

// 监听“Confirm”按钮的点击事件
$('#address-table tbody').on('click', '.confirm-btn', function() {
  var newRow = $(this).closest('tr');
  var inputList = newRow.find('input');

  // 获取文本框中的值
  var addressee = inputList.eq(0).val();
  var phone = inputList.eq(1).val();
  var country = inputList.eq(2).val();
  var address = inputList.eq(3).val();
  var isDefault = inputList.eq(4).prop('checked');

  // 将地址保存到数据库中
  $.ajax({
    url: 'save_address.php',
    method: 'POST',
    data: {
      addressee: addressee,
      phone: phone,
      country: country,
      address: address,
      isDefault: isDefault
    },
    success: function(response) {
      // 更新表格中的数据
      newRow.find('td').eq(0).text(response.id);
      newRow.find('td').eq(1).text(addressee);
      newRow.find('td').eq(2).text(phone);
      newRow.find('td').eq(3).text(country);
      newRow.find('td').eq(4).text(address);
      newRow.find('td').eq(5).text(isDefault ? 'Yes' : 'No');

      // 将“Confirm”按钮改回“Edit”按钮
      var editBtn = $('<button type="button" class="btn btn-primary btn-sm col-5 mx-auto edit-btn">Edit</button>');
      newRow.find('td').last().empty().append(editBtn);
    }
  });
});

    document.getElementById("back-btn").addEventListener("click", function() {
    window.location.href = "user.php";
  });
  $(document).ready(function () {
    $('#example').DataTable({
      searching: false,
      ordering:  false,
      info: false,
      paginate: false,
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

    $('.selectpicker').selectpicker();
    //$('#countrypicker').countrypicker();

    $('#add-address-btn').on('click', function() {
  // 创建新的行
  var newRow = $('<tr></tr>');

  var cell1 = $('<td><label><input class="form-check-input" style="" type="checkbox" value=""></label></td>');
   newRow.append(cell1);
   var cell2 = $('<td><?php echo $item["id"] ?></td>');
   newRow.append(cell2);
   var cell3 = $('<td ><?php echo $item["addressee"] ?></td>');
   newRow.append(cell3);
   var cell4 = $('<td > <span style="white-space: nowrap;"><?php echo $item["phone"] ?></span></td>');
   newRow.append(cell4);
   var cell5 = $('<td class="col-2"></td>');
  var select = $('#country-select'); // 获取 ID 为 mySelect 的元素
  cell5.append(select);
  newRow.append(cell5);
  var cell6 = $('<td class="col-3"></td>');
  var input = $('<input type="text" class="form-control">');
  input.css({
  'height': '100px',
});
  cell6.append(input);
  newRow.append(cell6);
  var cell7 = $('<td><input type="checkbox" class="form-check-input" <?php echo $item["is_default"] ? "checked" : "" ?> id="checkDefault" ></td>');
  newRow.append(cell7);
  //var cell8 = $('<td class="col-2"></tc>');
  // 添加“Confirm”按钮和"delete"按钮
  
var confirmAddressBtn = $('<button type="button" class="btn btn-primary btn-sm col-5 mx-auto confirm-btn">Confirm</button>');
confirmAddressBtn.css('white-space', 'nowrap'); // 设置不换行
var deleteAddressBtn = $('<button type="button" class="btn btn-danger btn-sm col-5 mx-auto" id = "address-delete-btn">Delete</button>');
newRow.append($('<td class="col-2"></td>').append(confirmAddressBtn).append($('<span></span>').css('width', '10px')).append(deleteAddressBtn).css('margin-left', '10px'));
//var cell8 = $('<td class="col-2"><button type="button" class="btn btn-primary btn-sm col-5 mx-auto" id = "edit-btn">Edit</button><button type="button" class="btn btn-danger btn-sm col-5 mx-auto" id = "delete-btn">Delete</button></td>');

  // 在表格最后添加新行
  $('#example tbody').append(newRow);
});

    $("#save-btn").click(function() {
    // 获取表单数据
    var id = $("#inputId").val();
    var name = $("#inputName").val();
    var email = $("#inputEmail").val();
    var phone = $("#inputPhoneNumber").val();
    var birthday = $("#inputBirth").val();
    var role = $("#inputRole").val();
    var state = $("#inputState").val();
    // 获取 role 和 state 的选项值
    var selectedRole = $("#inputRole option:selected").val();
    var selectedState = $("#inputState option:selected").val();
    // 使用 AJAX 发送数据到服务器端
    $.ajax({
        url: "save_user.php",
        method: "POST",
        data: {
            id: id,
            name: name,
            email: email,
            phone: phone,
            birthday: birthday,
            role: selectedRole,
            state: selectedState
        },
        success: function(response) {
            console.log(response);
            alert("Data saved successfully!");
        },
        error: function(xhr, status, error) {
            console.log(error);
            alert("An error occurred while saving data. Please try again later.");
        }
    });
});


  });


</script>
</body>
</html>
