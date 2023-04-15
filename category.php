<?php
$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);
$stmt = $pdo->prepare("
  select
      c.id as id, c.name as name, description, COUNT(p.id) as count 
  from category c right join product p on c.id = p.category
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

  <link href="css/styles.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/datatables.min.css" rel="stylesheet"/>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/datatables.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

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

                  <input type="text" class="form-control" placeholder="Search Categories by Name or ID" aria-describedby="basic-addon1">
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
                <th >Description</th>
                <th >Products</th>
                <th >Operation</th>
              </tr>
              </thead>
              <tbody>
              <?php
              foreach ($category_list as $category) {
              ?>
              <tr>
                <td >
                  <label>
                    <input class="form-check-input" style="" type="checkbox" value="">
                  </label>
                </td>
                <td >
                  <?php echo $category["id"] ?>
                </td>
                <td >
                  <?php echo $category["name"] ?>
                </td>
                <td >
                  <?php echo $category["description"] ?>
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
                  <button type="button" class="btn btn-primary btn-sm col-5 mx-auto">
                    Detail
                  </button>
                  <button type="button" class="btn btn-danger btn-sm col-5 mx-auto">
                    Delete
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
