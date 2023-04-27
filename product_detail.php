<?php
 include_once('config.php'); //import database connection file
 
 //Read product classification information
 $stmt = $pdo->prepare(" select * from category ");
 $stmt->execute();
 $category_list = $stmt->fetchAll();
 
 //Read product status information
 $stmt = $pdo->prepare(" select * from product_state ");
 $stmt->execute();
 $product_state_list = $stmt->fetchAll();
 
 //
 
 $id = empty($_GET['id'])?0:$_GET['id']; //Get the product id that needs to be edited
 $act = empty($_GET['act'])?'add':$_GET['act']; //Whether to get an add operation or a modification operation
 $act = in_array($act,['add','edit'])?$act:'add'; //The operation can only be publish or modify
 if(!empty($id)&& $act=='edit'){
	 //If it is an editing operation, get the currently edited product information
	 $sql_where = "where id = '{$id}'";
	  $stmt = $pdo->prepare("
    select
        id, category, name, price, price_unit, state, stock, image_url
    from product
    {$sql_where}
");
	$stmt->execute();
	$product = $stmt->fetch();
	if(empty($product)){
		echo "<script>alert('Product information does not exist');location='product.php'</script>";
	}
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/datatables.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.html">Store System</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" >
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="bi bi-search"></i></button>
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Settings</a></li>
                <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="#!">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="index.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    <div class="sb-sidenav-menu-heading">Product</div>
                    <a class="nav-link" href="product.php">
                        <div class="sb-nav-link-icon"><i class="bi bi-bag"></i></div>
                        Product
                    </a>
                    <a class="nav-link" href="category.html">
                        <div class="sb-nav-link-icon"><i class="bi bi-grid"></i></div>
                        Category
                    </a>

                    <div class="sb-sidenav-menu-heading">Order</div>
                    <a class="nav-link" href="order.html">
                        <div class="sb-nav-link-icon"><i class="bi bi-clipboard"></i></div>
                        Order
                    </a>

                    <div class="sb-sidenav-menu-heading">User</div>
                    <a class="nav-link" href="user.html">
                        <div class="sb-nav-link-icon"><i class="bi bi-person"></i></div>
                        User
                    </a>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Zirui Zhou
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
		<form method="post" action="product_detail.php?act=<?php echo $act ?>&id=<?php echo $id ?>" enctype="multipart/form-data">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Product Detail</h1>

                <div class="card mb-4" style="height: 480px">

                    <div class="card-body d-flex justify-content-evenly flex-column">
<!--                        <div class="d-block w-100">-->
                        <div class="d-flex justify-content-evenly ">
                            <div class="col-5 ">
                                <div class="mb-3 row">
                                    <label for="inputName" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="inputName" value="<?php echo $product['name'] ?>" name="name">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputCategory" class="col-sm-3 col-form-label">Category</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" id="inputCategory" aria-label="Default select example" name="category">
											<?php foreach($category_list as $key=>$val){ ?>
											
                                            <option <?php if($product['category']==$val['id']) echo 'selected'; ?> value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
											<?php } ?>
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputPrice" class="col-sm-3 col-form-label">Price</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="inputPrice" value="<?php echo $product['price'] ?>" name="price">
                                            <span class="input-group-text">CNY</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row ">
                                    <label for="inputState" class="col-sm-3 col-form-label">State</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" id="inputState"  aria-label="Default select example" name="state">
											
											<?php foreach($product_state_list as $key=>$val){ ?>
											
											<option <?php if($product['state']==$val['id']) echo 'selected'; ?> value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
											<?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="inputStock" class="col-sm-3 col-form-label">Stock</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="inputStock" value="<?php echo $product['stock'] ?>" name="stock" >
                                    </div>
                                </div>
                            </div>
                            <div class="vr">
                            </div>
                            <div class="col-3">
								<div class="row">
									<div class="col-12 d-flex justify-content-evenly align-items-center">
										<span class="align-middle">Image Preview</span>
										<img
										        src="<?php echo empty($product['image_url'])?'uploads/image.png':$product['image_url']; ?>"
										        class="rounded"
										        style="height: 150px; width: 150px; border: 2px solid grey; object-fit: contain"
										        alt="..."
										>
									</div>
								</div>
								<div class="row" style="margin-top: 5px;">
									<div class="col-12">
										<input type="file" id="inputFile" name="image_url" style="display:none" onchange="changeAgentContent()" />
										<input type="text" value="" disabled id="inputFileAgent" />
										<input type="button" onclick="document.getElementById('inputFile').click()" value="choose..." />
										
									</div>
									
								</div>
                               
								
                            </div>
							
                        </div>

                        <hr/>

                        <div class="d-flex justify-content-evenly col-4 mx-auto" style="margin-bottom: 0">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i>
								<?php if($act=='add'){ echo 'Add Product';}else{ echo 'Save Changes'; } ?>
                               
                            </button>
                            <a  href="product.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i>
                                Back
                            </a>

                        </div>
<!--                        </div>-->
                    </div>
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                </div>

            </div>
        </main>
		</form>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Zirui Zhou 2023</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
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
	function changeAgentContent(){
	        document.getElementById("inputFileAgent").value = document.getElementById("inputFile").value;
	}
</script>
</body>
</html>

<?php
 $data = $_POST; //Get form submitted data
 if(!empty($data)){
	
	switch($act){
		//Product add operation
		case 'add':
		if($_FILES['image_url']['tmp_name']!=''){
			$image_url = upload_image('image_url');
		}else{
			$image_url = '';
		}
		$sql = "insert into product(id,name,price,price_unit,state,stock,category,image_url) values(?,?,?,?,?,?,?,?)";
		//Prepare sql template
		$stmt = $pdo->prepare( $sql );
		include_once('UUID.php');
		$uuid = uuid::v4();
		//binding parameters
		$id = $uuid;
		$stmt->bindValue( 1, $id );
		$stmt->bindValue( 2, $data['name'] );
		$stmt->bindValue( 3, $data['price'] );
		$stmt->bindValue( 4,'CNY' );
		$stmt->bindValue( 5, $data['state'] );
		$stmt->bindValue( 6, $data['stock'] );
		
		$stmt->bindValue( 7, $data['category'] );
		$stmt->bindValue( 8, $image_url );
		
		//execute prepared statement
		$stmt->execute();
		$affect_row = $stmt->rowCount();
		
		if ( $affect_row ) {
			echo "<script>alert('Add successfully');location='product.php'</script>";
		} else {
			echo "<script>alert('Add failed');location='product.php'</script>";
		}
		
		
		break;
		//Commodity modification operation
		case 'edit':
		
		if($_FILES['image_url']['tmp_name']!=''){
			$image_url = upload_image('image_url');
		}else{
			$image_url = $product['image_url'];
		}
		
		$stmt = $pdo->prepare("
		  UPDATE product
		  SET name = :name, price = :price, price_unit=:price_unit, state=:state, stock=:stock ,category=:category ,image_url=:image_url 
		  WHERE id = :id
		");
		$price_unit = 'CNY';
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":name", $data['name']);
		$stmt->bindParam(":price", $data['price']);
		$stmt->bindParam(":state", $data['state']);
		$stmt->bindParam(":price_unit",$price_unit);
		$stmt->bindParam(":stock", $data['stock']);
		
		$stmt->bindParam(":category", $data['category']);
		$stmt->bindParam(":image_url", $image_url);
		$stmt->execute();
		//echo $stmt->debugDumpParams();
		
		 $affect_row = $stmt->rowCount();
		 //echo $stmt->getlastsql();
		
		if ( $affect_row ) {
			
			echo "<script>alert('updated successfully');location='product.php'</script>";
		
		} else {
			
			echo "<script>alert('updated failed');location='product.php'</script>";
		
		}
		break;
		
		
	} 
	 
	 
 }
 ?>
