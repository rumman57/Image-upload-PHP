<?php 
include 'lib/Database.php';
$db = new Database();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Image Uploading</title>
	<link href="style.css" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
   <div class="main_content">
   <div class="upload_image">
<?php
   
   if($_SERVER["REQUEST_METHOD"]=="POST")
   {
   	 $fileformat = array('jpg','jpeg','png','gif');
   	 $file_name = $_FILES['image']['name'];
   	 $file_size = $_FILES['image']['size'];
   	 $file_temp = $_FILES['image']['tmp_name'];

   	$div = explode('.', $file_name);
   	$file_extension = strtolower(end($div));
   	$unique_name_image = substr(md5(time()),0,10).'.'.$file_extension;
   	$uploaded_directory_Imagename = "images/".$unique_name_image;

   	if(empty($file_name)){
   		echo "<span class ='error' >Filled Should Not be Empty </span>";
   	}elseif($file_size>1048576){
   		echo "<span class ='error' >File Size Not More Than 1MB </span>";
   	}elseif(in_array($file_extension, $fileformat)===false){
   		echo "<span class ='error' >You Can Upload Only : ".implode(' , ', $fileformat)."</span>";
   	}else{

		   	move_uploaded_file($file_temp, $uploaded_directory_Imagename);
		   	$query="INSERT INTO table_image (image) VALUES ('$uploaded_directory_Imagename')";
		   	$result = $db->insert($query);
		   	if($result){
		   		echo "<span class ='success' >Image Inserted Successfully</span>";
		   		header("Refresh:0");
		   	}else{
		   		echo "<span class ='error' >Image Not Inserted </span>";
		   	}
	  }
   } 

?>

  <br>

     <form action="" method="post" enctype="multipart/form-data">
      <div class="table">
       			<label class="image">Upload Image File : 
       			<input type="file" name="image">
       			</label>
       			
       		
       		<input type="submit" name="submit" value="submit">
       	</div>
     </form>
   </div>

<div class="show_data">
<h2>Image From Database</h2>
     
       <table>
       	 <tr>
       	 	<th>No. </th>
       	 	<th> Image</th>
       	 	<th>Action</th>
       	 </tr>
       	 <?php
  if(isset($_GET['delete']) && $_GET['delete']!=NULL){
        $id = $_GET['delete'];
      //Folder Theke Delete---Start--**
     
       $delfolquery= "select * from table_image where id=$id";
	   $delfolresult = $db->select($delfolquery);
	   if($delfolresult) {
	   	while ($delfolvalue = $delfolresult->fetch_assoc()) {
	   		$delfolvalue = $delfolvalue['image'];
	   		unlink($delfolvalue);
	   } }

      //Folder Theke Delete---End--**
	  	$deletequery = "delete  from table_image where id = $id";
	  	$deresult = $db->delete($deletequery);
	  	if($deresult){
	  		echo "<script>alert('Image Deleted Successfully...')</script>";
	  		header("Location:index.php");
	  	}else{
	  		echo "<script>alert('Image Not Deleted')</script>";
	  	}
	  }
 
?>
<?php
   $query = "select * from table_image";
   $result = $db->select($query);
   if($result) {
   	$i =0;
   	while ($value = $result->fetch_assoc()) {
   		$i++;
?>
       	  <tr>
       	 	<td><?php echo $i;?></td>
       	 	<td> <img src="<?php echo $value['image'];?>" height="50px" width="50px"></td>
       	 	<td><a href="?delete=<?php echo $value['id'];?>">Delete</a></td>
       	 </tr>

       	  <?php }} ?>
       </table>
    
</div>
    

   </div>
  </div>
</body>
</html>
