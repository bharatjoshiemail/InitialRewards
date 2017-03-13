<?php
session_start();
include_once("StorageFactory.php");

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if (empty($_POST["storageType"])) {
		$err .= "storageType is required<br>";
    } else {
		$storageType = test_input($_POST["storageType"]);
    }
  
  if (empty($_POST["username"])) {
		$err .= "Username is required\n";
  } else {
		$username = test_input($_POST["username"]);
		// check if name only contains Alphanumeric with hyphen and underscore
		if (!preg_match("/^[a-zA-Z0-9_-]*$/",$username)) {
		  $err .= "Username : Only Alphanumeric with hyphen and underscore allowed\n";
		}
  }
  
  if (empty($_POST["firstName"])) {
		$err .= "FirstName is required\n";
  } else {
		$firstName = test_input($_POST["firstName"]);
		// check if Only Alphanumeric, no spaces
		if (!preg_match("/^[a-zA-Z]*$/",$firstName)) {
		$err .= "FirstName : Only Alpha, no spaces\n";
    }
  }     

  if (empty($_POST["midInit"])) {
		$midInit = "";
  } else {
		$midInit = test_input($_POST["midInit"]);
  }
  
  if (empty($_POST["lastName"])) {
		$err .= "LastName is required\n";
  } else {
		$lastName = test_input($_POST["lastName"]);
		// check if name only Alpha, spaces and hyphens
		if (!preg_match("/^[a-zA-Z -]*$/",$lastName)) {
			$err .= "LastName : Only Alpha, spaces and hyphens allowed\n";
		}
  }

  if (empty($_POST["gender"])) {
		$err .= "Gender is required\n";
  } else {
		$gender = test_input($_POST["gender"]);
		if(strlen($gender)>1){
			$err .= "Gender : Only Alpha, 1 character allowed\n";
		}
  }
  
  if (empty($_POST["dob"])) {
		$err .= "Date of Birth is required";
  } else {
		$dob = $_POST["dob"];
		if (!preg_match('/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/',$dob)) {
		  $err .= "Date of Birth : Only YYYY-MM-DD format allowed\n";
		}
  }    
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (isset($_GET["flag"]) and $_GET['flag'] == 'delete') {
		$storageType = test_input($_GET["storageType"]);
		
	}
}
if($err == ''){	
		$storageFactory = new StorageFactory();
		$storageTypeSelected = $storageFactory->getTypeOfStorage($storageType);  
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$message = $storageTypeSelected->save($_POST);
			if($message){
				header("Location: indexDB.php");
			}else{
				$err = $message;
			}
			
		}
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			$message = $storageTypeSelected->delete($_GET['id']);
			if($message){
				header("Location: indexDB.php");
			}else{
				$err = $message;
			}
			
		}
		if(!$err == ''){
			$_SESSION['err'] = $err;
			header("Location: userform.php");
		}			
		
	}else{
		$_SESSION['err'] = $err;
		header("Location: userform.php");
	}
	
	




