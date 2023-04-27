<?php
error_reporting(0);
//connect to the database information
$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null); //dbname、username、code


/*
*function to upload images
*$file The name of the upload control
*/
function upload_image($file){

$old_flie_name = $_FILES[$file]['name'];//The original name of the uploaded file
//Get the extension name of the file
$ext_name = substr($old_flie_name,strrpos($old_flie_name,'.')+1);
$ext_name = strtolower($ext_name);
$image_type = ['bmp','jpg','gif','png','jpeg'];
//Verify the file type of a file upload
if(!in_array($ext_name,$image_type)){
	echo "<script>alert('The uploaded file is not an image type');history.back();</script>";
	die();
}
//Determine file size
if($_FILES[$file]['size']>2*1024*1024){
	echo "<script>alert('Uploaded pictures are not allowed to exceed 2M');history.back();</script>";
	die();
}

$filename = $_FILES[$file]['tmp_name']; //Path to temporary storage of uploaded files
$file_name = time().rand(10000,99999).rand(1000,9999).'.'.$ext_name;
$destination  ='uploads/images/'.$file_name ; //Where to upload the file to the server [include file]
move_uploaded_file($filename,$destination);
$save_name = 'uploads/images/'.$file_name; //Values need to be written to the datatable
return $save_name;

}
