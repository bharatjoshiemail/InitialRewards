<?php
	require_once('header.php');
?>
	<script>
		function editUser(id){
			alert(id);
		}
		function deleteUser(id){
			alert(id);
		}
	</script>
<?php
	include_once('DependencyContainer.php');
	include_once('StorageInDB.php');
	$err = '';
	$di = new DependencyContainer;
	$storageObject = new StorageInDB($di);
	$data = $storageObject->read();
	echo "<h3>Users data from Database</h3>";
	echo "<table class='table' border=1>";
	echo "<tr><th>ID</th>
		<th>Username</th>
		<th>Title</th>
		<th>FirstName</th>
		<th>LastName</th>
		<th>MiddleInitial</th>
		<th>Gender</th>
		<th>Dob</th>
		<th colspan=2><center>Manage</center></th>
		</tr>
		";
	foreach($data as $row){
		echo "<tr>
		<td>{$row['id']}</td>
		<td>{$row['username']}</td>
		<td>{$row['title']}</td>
		<td>{$row['firstName']}</td>
		<td>{$row['lastName']}</td>
		<td>{$row['middleInitial']}</td>
		<td>{$row['gender']}</td>
		<td>{$row['dob']}</td>
		<td><a href='userForm.php?id=".$row['id']."&err=".$err."'>EDIT</a></td>
		<td><a href='dml.php?id=".$row['id']."&flag=delete&storageType=db'>DELETE</a></td>
		</tr>";
	}
	echo "</table>";
?>

<?php
	require_once('footer.php');
?>
    

