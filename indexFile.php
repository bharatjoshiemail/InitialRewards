<?php
	require_once('header.php');

	include_once('StorageInFile.php');
	$err = '';
	$storageObject = new StorageInFile;
	$data = $storageObject->read();
	echo "<h3>Users data from file</h3>";
	echo "<table class='table' border=1>";
	echo "<tr>
	<th>Username</th>
		<th>Title</th>
		<th>FirstName</th>
		<th>LastName</th>
		<th>MiddleInitial</th>
		<th>Gender</th>
		<th>Dob</th>		
		</tr>
		";
	if(is_array($data) and count($data)>0){
		foreach($data as $line){
			echo '<tr><td>';
			echo str_replace(',','</td><td>',$line);
			echo '</td></tr>';
		}
		echo "</table>";		
	}
	elseif(strlen($data)>0){
		echo '<tr><td>'.$data.'</td></tr></table>';
	}	
	else{
		$data = 'No data in file';
	}	

	require_once('footer.php');
?>