<?php
	include_once('config.php');
	//batch deletion
	if(!empty($_GET['act'])&&$_GET['act']=='batch'){
		if(empty($_POST['id'])){
			echo "<script>alert('Select at least one product');location='product.php'</script>";die();
			die();
		}
		$ids = $_POST['id']; //get the checked product id
		foreach($ids as $key=>$val){
			$stmt = $pdo->prepare("DELETE FROM product WHERE id = ?");
			$stmt->execute([$val]);
		}
		
		echo "<script>alert('Successfully deleted');location='product.php'</script>";die();
		die();
	}else{
		
		 // get the deleted product id
		 $id = $_GET["id"];
			// prepare SQL language
		 $stmt = $pdo->prepare("DELETE FROM product WHERE id = ?");
		 $stmt->execute([$id]);
		echo "<script>alert('Successfully deleted');location='product.php'</script>";die();
	}
	
   
?>
