<?php
global $pdo;

include("./config.php");

$search_key = "";
$sql_search = "";
if(isset($_GET['search'])) {
  $search_key = $_GET['search'];
  $sql_search = "
    where (
      c.id LIKE '%{$search_key}%'
      OR c.name LIKE '%{$search_key}%'
    )
  ";
}

$stmt = $pdo->prepare("
  select
      c.id as id, c.name as name, description, COUNT(p.id) as count 
  from category c left join product p on c.id = p.category
  {$sql_search}
  group by c.id
");
$stmt->execute();
$category_list = $stmt->fetchAll();
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

  <?php require ("dependency.php")?>

</head>
<body class="sb-nav-fixed">
<?php require("top_nav.php") ?>
<div id="layoutSidenav">
  <?php require("side_nav.php") ?>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <h1 class="mt-4">Category</h1>
        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-search"></i>
            Category Search
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col ">


              </div>
              <div class="col">
              </div>
              <div class="col d-flex justify-content-evenly align-items-center">

                <div class="input-group ">

                  <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-search"></i>
                  </span>

                  <input
                      type="text"
                      class="form-control search_input"
                      placeholder="Search Categories by Name or ID"
                      aria-describedby="basic-addon1"
                      value="<?php echo $search_key ?>"
                  >
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-4">

          <div class="card-body">
            <div class="d-flex justify-content-evenly col-3">
              <button type="button" class="btn btn-primary col-5 top_add_btn">
                <i class="bi bi-plus-circle"></i>
                Add
              </button>
              <button type="button" class="btn btn-secondary col-5 top_delete_btn">
                <i class="bi bi-trash3"></i>
                Delete
              </button>
            </div>

            <hr/>

            <table class="table table-striped" style="vertical-align: middle; text-align: center" id="example">
              <thead>
              <tr>
                <th ></th>
                <th>ID</th>
                <th class="col-2">Name</th>
                <th class="col-2">Description</th>
                <th >Products</th>
                <th >Operation</th>
              </tr>
              </thead>
              <tbody>
              <tr id="new_item_input_tr">
                <td >
                  <label>
                    <input class="form-check-input" style="" type="checkbox" value="" disabled>
                  </label>
                </td>
                <td >
                  <input type="text" class="form-control" style="text-align:center" value="Auto Generated" disabled>
                </td>
                <td >
                  <input type="text" class="form-control name_input" >
                </td>
                <td >
                  <textarea type="text" class="form-control desc_input" style="resize: none" rows="2"></textarea>
                </td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm mx-auto" disabled>
                    Search 0 item(s)
                  </button>
                </td>
                <td class="col-2">
                  <button type="button" class="btn btn-primary btn-sm col-5 mx-auto new_add_btn">
                    Confirm
                  </button>
                  <button type="button" class="btn btn-danger btn-sm col-5 mx-auto new_cancel_btn">
                    Cancel
                  </button>
                </td>
              </tr>
              <?php
              foreach ($category_list as $category) {
              ?>
              <tr class="table_item_row">
                <td >
                  <input class="form-check-input item_check" type="checkbox">
                </td>
                <td >
                  <span class="id_span"><?php echo $category["id"] ?></span>
                </td>
                <td >
                  <span class="name_span"><?php echo $category["name"] ?></span>
                  <input type="text" class="form-control name_input" value="<?php echo $category["name"] ?>">
                </td>
                <td >
                  <span class="desc_span"><?php echo $category["description"] ?></span>
                  <textarea type="text" class="form-control desc_input" style="resize: none" rows="2"><?php echo $category["description"] ?></textarea>
                </td>
                <td>
                  <button
                      onclick=<?php echo "\"location.href = 'product.php?c={$category['id']}';\"" ?>
                      type="button"
                      class="btn btn-primary btn-sm mx-auto"
                  >
                    <?php echo "Search {$category["count"]} item(s)" ?>
                  </button>
                </td>
                <td class="col-2">
                  <button type="button" class="btn btn-primary btn-sm col-5 mx-auto edit_btn">
                    Edit
                  </button>
                  <button type="button" class="btn btn-danger btn-sm col-5 mx-auto delete_btn" <?php echo $category["count"] ? "disabled": "" ?>>
                    Delete
                  </button>
                  <button type="button" class="btn btn-primary btn-sm col-5 mx-auto confirm_btn">
                    Confirm
                  </button>
                  <button type="button" class="btn btn-danger btn-sm col-5 mx-auto cancel_btn">
                    Cancel
                  </button>
                </td>
              </tr>
              </tbody>
              <?php
              }
              ?>
            </table>

          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

      </div>
    </main>
    <?php require("footer.php") ?>
  </div>
</div>

<script src="./scripts/utils/requestUtils.js"></script>
<script src="./scripts/api/category.js"></script>
<script>
  $(document).ready(function () {
    initialize();
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
    $(".search_input").keypress(function (e) {
      if (e.which === 13) {
        const search_key = $(this).val()
        if(search_key) {
          window.location.href = `category.php?search=${search_key}`;
        } else {
          window.location.href = `category.php`;
        }
      }
    })
    $(".top_add_btn").click(function() {
      change_elem_visible($("#new_item_input_tr"))
    })
    $(".top_delete_btn").click(function() {
      $(".table_item_row").each(function() {
        if($(this).find(".item_check").is(":checked")) {
          delete_category($(this).find(".id_span").text())
        }
      });
      location.reload();
    })
    $(".new_add_btn").click(function() {
      const new_item_input = $("#new_item_input_tr")
      add_category(
          new_item_input.find(".name_input").val(),
          new_item_input.find(".desc_input").val()
      )
      location.reload();
    })
    $(".new_cancel_btn").click(function() {
      change_elem_visible($("#new_item_input_tr"))
    })
    $(".edit_btn").click(function() {
      console.log(this)
      change_table_item_visible($(this).closest('.table_item_row'))
    })
    $(".delete_btn").click(function() {
      delete_category($(this).closest('.table_item_row').find(".id_span").text());
      location.reload();
    });
    $(".confirm_btn").click(function() {
      const table_item_row = $(this).closest('.table_item_row')
      update_category(
          table_item_row.find(".id_span").text(),
          table_item_row.find(".name_input").val(),
          table_item_row.find(".desc_input").val()
      )
      location.reload();
    });
    $(".cancel_btn").click(function() {
      change_table_item_visible($(this).closest('.table_item_row'))
    })
  });

  function initialize() {
    $("#new_item_input_tr").hide()
    $(".table_item_row").each(function() {
      $(this).find(".name_input").hide()
      $(this).find(".desc_input").hide()
      $(this).find(".confirm_btn").hide()
      $(this).find(".cancel_btn").hide()
    });
  }

  function change_elem_visible(elem) {
    if(elem.is(":visible")) {
      elem.hide();
    } else {
      elem.show();
    }
  }

  function change_table_item_visible(item) {
    [
        ".name_input",
        ".desc_input",
        ".name_span",
        ".desc_span",
        ".edit_btn",
        ".delete_btn",
        ".confirm_btn",
        ".cancel_btn",
    ].forEach((value) => {
      change_elem_visible(item.find(value));
    })
  }

</script>
</body>
</html>
