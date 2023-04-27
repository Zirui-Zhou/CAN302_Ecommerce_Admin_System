<?php
include_once('config.php');
//get the key word
$keyword = empty($_GET["keyword"])?'':$_GET["keyword"];


$stmt = $pdo->prepare("
    select
        id, name, description
    from category
");
$stmt->execute();
$category_list = $stmt->fetchAll();

$sql_where = ' 1 ';
$sql_where .= !empty($_GET["category"]) ? " and  category = '{$_GET["category"]}'" : " ";
$sql_where .= !empty($_GET["keyword"]) ? " and   name like '%{$keyword}%'  " : " ";
$stmt = $pdo->prepare("
    select
        id, category, name, price, price_unit, state, stock, image_url
    from product where 
    {$sql_where}
");
$stmt->execute();
$product_list = $stmt->fetchAll();

require_once ("utils.php");
$product_state = getProductStateList();
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
  

</head>
<body class="sb-nav-fixed">
<?php require("top_nav.php") ?>
<div id="layoutSidenav">
  <?php require("side_nav.php") ?>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <h1 class="mt-4">Product</h1>
        <div class="card mb-4">
          <div class="card-header">
            <i class="bi bi-search"></i>
            Product Search
          </div>
          <div class="card-body">
			<form action="product.php" method="get">
            <div class="row">
              <div class="col d-flex justify-content-evenly align-items-center">
                <div class="col-5">Product Category:</div>
                <div class="dropdown col-5">
                  <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    All Categories
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					  <?php foreach($category_list as $key=>$val){ ?>
					  
					  
					   <a class="dropdown-item" href="product.php?category=<?php echo $val['id'] ?>&keyword=<?php echo $keyword ?>"><?php echo $val['name'] ?></a>
					  <?php } ?>
                   
                  </div>
                </div>
              </div>
              <div class="col">
              </div>
              <div class="col d-flex justify-content-evenly align-items-center">

                <div class="input-group ">

                  <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-search"></i>
                  </span>

                  <input type="text" class="form-control" placeholder="Search Products by Name or ID" aria-describedby="basic-addon1" name="keyword">
                </div>
              </div>
            </div>
            </form>
		  </div>
        </div>

        <div class="card mb-4">

          <div class="card-body">
            <div class="d-flex justify-content-evenly col-3">
              <a type="button" class="btn btn-primary col-5" href="product_detail.php?act=add">
                <i class="bi bi-plus-circle"></i>
                Add
              </a>
              <button type="button" class="btn btn-secondary col-5" onclick="document.getElementById('table_Form').submit()">
                <i class="bi bi-trash3"></i>
                Delete
              </button>
            </div>

            <hr/>
            <form action="product_delete.php?act=batch" method="post" id="table_Form">
            <table class="table table-striped" style="vertical-align: middle; text-align: center" id="example">
              <thead>
              <tr>
                <th ></th>
                <th >ID</th>
                <th >Name</th>
                <th class="col-1">Image</th>
                <th >Category</th>
                <th >Price</th>
                <th >Stock</th>
                <th >Status</th>
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
                    <input class="form-check-input" name="id[]" style="" type="checkbox" value="<?php echo $product["id"] ?>">
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
                  <?php
                  $i = array_search($product["category"], array_column($category_list, 'id'));
                  echo $category_list[$i]["name"]
                  ?>
                </td>
                <td >
                  <?php
                  echo "{$product["price"]} {$product["price_unit"]}";
                  ?>
                </td>
                <td >
                  <?php echo $product["stock"] ?>
                </td>
                <td >
                  <?php echo $product_state[$product["state"]]->getBadge()->getBadgeHtml() ?>
                </td>
                <td >
                  <a  href="product_detail.php?act=edit&id=<?php echo $product["id"] ?>" class="btn btn-primary btn-sm col-5 mx-auto">
                    Detail
                  </a>
                  <a href="product_delete.php?act=delete&id=<?php echo $product["id"] ?>" class="btn btn-danger btn-sm col-5 mx-auto">
                    Delete
                  </a>
                </td>
              </tr>
              <?php
              }
              ?>
              </tbody>
            </table>
			</form>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
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

  });
  
  
  
</script>
</body>
</html>
