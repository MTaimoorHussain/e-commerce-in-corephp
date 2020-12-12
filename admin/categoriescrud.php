<?php

function open_dbj(){
	$conn = mysqli_connect('localhost','root','','categoriescrud');
	
	if(!$conn){
		die('error in connection');
	}
	return $conn;
}

if(isset($_GET['delete'])){
	$cn = open_dbj();
	$id = $_GET['delete'];
	
	$q = "DELETE FROM tableedit WHERE id = $id";
	$result = mysqli_query($cn, $q);
	
	if($result){
		echo"record successfully deleted<a href='edit_fform.php?view_all'><b>GO BACK</b></a>";
	}else{
		echo"delete query is not working";
	}
}




if(isset($_POST['submit-btn'])){
	
	$conn = open_dbj();
	
	$flname = $_POST['fstname'];
	$llname = $_POST['lstname'];
	$eename = $_POST['emlname'];
	$file_name = "$eename.jpg";
	$p_pname = $_FILES['propname'];
	
	$query = "SELECT * FROM tableedit WHERE email = '$eename' ";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	
	if($row){
		echo"<p>form already submit</p>";
		echo"<a href='categoriescrud.php' style='text-decoration:none'><Go back</a>";
		return; 
	}
	move_uploaded_file($p_pname['tmp_name'],"profilepic/".$file_name);
	$query = "INSERT INTO tableedit(firstname, lastname, email, profilepicture)
	VALUE('$flname','$llname','$eename','$file_name')";
	
	$q = mysqli_query($conn, $query);
	
	if($q){
		echo"<p>email registered successfully</p>";
		echo"<a href='categoriescrud.php' style='text-decoration:none'><Go back</a>";
	}else{
		die('something went wrong');
	}
	
}

if(isset($_GET['view_all'])){
	$conn = open_dbj();
	
	$query = "SELECT * FROM tableedit";
	$query = mysqli_query($conn, $query);
	
	?>
	
<table border="1" cellpadding="2" cellspacing="4" width="500" bgcolor="lightgray">
<thead>
<tbody>
<th>id</th>
<th>profilepicture</th>
<th>firstname</th>
<th>lastname</th>
<th>email</th>
<th>Action</th>
<th>Edit</th>




</thead>

	
	

<?php



while($user = mysqli_fetch_array($query)){
	
	$user_id = $user['id'];
	$pro_name = "profilepic/".$user['profilepicture'];
	$first_name = $user['firstname'];
	$last_name = $user['lastname'];
	$ema_il = $user['email'];
	
	echo"<tr id='".$user_id."'>";
	echo"<td>".$user_id."</td>";
	echo"<td><img src='".$pro_name."' width='120'></td>";
	echo"<td>".$first_name."</td>";
	echo"<td>".$last_name."</td>";
	echo"<td>".$ema_il."</td>";
	echo"<td><a href='edit_fform.php?delete=".$user_id."'>delete</a></td>";
	echo"<td><a href='edit_fform.php?edit_profile=".$user_id."'>edit profile</a></td>";
	echo"</tr>";
	
	
}
?>

<tr colspan="5">
<td>
<a href="categoriescrud.php"><b>GO back</b></a>
</td>

</tr>


</tbody>
</table>
<?php

}

if(isset($_GET['edit'])){
	$con = open_db();
	$user_id = $_GET['edit'];
	
	$query = "SELECT * FROM tableedit WHERE id = $user_id ";
	$result = mysqli_query($con, $query);
	$user = mysqli_fetch_assoc($result);
	
	?>
	
<form action="categoriescrud.php?update_profile=<?php echo $user['id']?>" method="post" enctype="multipart/form-data">
<div>
<h1>edit your profile</h1>
</div>
<br>
<label for="">
<b>firstname</b>
<input type="text" name="fstname" value="<?php echo $user['firstname']?>">
</label>
<br>
<label for="">
<b>lastname</b>
<input type="text" name="lstname" value="<?php echo $user['lastname']?>">
</label>
<br>
<label for="">
<b>email</b>
<input type="email" name="emlname" value="<?php echo $user['email']?>"> 
</label>
<br>
<label for="">
<b>profilepicture</b>
<input type="file" name="propname" value="<?php echo $user['profilepicture']?>">
</label>
<br>
<br>
<button class="submit" value="">Update</button> <button class="back" value='".$user_id."'><b>GO back</b></button>
</br>



</form>	
	
<?php	
	
}

if(isset($_GET['edit_profile'])){
	$conn = open_dbj();
	$user_id = $_GET['edit_profile'];
	
	$query = "SELECT * FROM tableedit WHERE id = $user_id";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	
	?>
	
<form>
<input type="text" name="frname" value="<?php echo $row['firstname']?>">
<input type="text" name="lrname" value="<?php echo $row['lastname']?>">
<input type="email" name="ellname" value="<?php echo $row['email']?>">
<input type="file" name="ppfname" value="<?php echo $row['profilepicture']?>">
<input type="submit" value="UPdate" name="upsub">

</form>	
	
	
<?php

	
}

?>