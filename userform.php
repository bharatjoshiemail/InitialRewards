<?php
	session_start();
	require_once('header.php');	
?>
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript">

function formValidation()  
		{  
		console.log('formvalidation');
		var username = document.userform.username;  
		var firstName = document.userform.firstName;  
		var lastName = document.userform.lastName;  
		var title = document.userform.title;  
		var midInit = document.userform.midInit;  
		var gender = document.userform.gender;  
		var dob = document.userform.dob;  
		var storageType = document.userform.storageType; 
		
		var errorMessage = '';
		
		if(!alphanumericWithHyphenAndUnderscore(username)){
			errorMessage += 'Username allowed alphanumeric with hyphen and underscore only: ' + username +'<br>';
		}
		if(!allLetter(firstName)){
			errorMessage += 'FirstName allows alphanumeric only: ' + firstName +'<br>';
		}
		if(!allLetterWithSpaceAndHyphen(lastName)){
			errorMessage += 'LastName allows alpha, space and hyphen only: ' + lastName +'<br>;
		}
		if(!oneAlphaOnly(midInit)){
			errorMessage += 'Mid Init allows one alphabet only: ' + midInit +'<br>';
		}
		if(storageType == ''){
			errorMessage += 'Please Storage type : ' + storageType +'<br>';
		}
		if(!errorMessage == ''){
			$('#error').val(errorMessage);
			return;
		}
	}
	
	function alphanumericWithHyphenAndUnderscore(username)  
	{   
		var letters = /^[0-9a-zA-Z_-]+$/;  
		if(username.value.match(letters))  
		{  
			return true;  
		}  
		else  
		{  
			username.focus();  
			return false;  
		}  
	}

	function allLetter(firstName)  
	{   
		var letters = /^[A-Za-z]+$/;  
		if(firstName.value.match(letters))  
		{  
			return true;  
		}  
		else  
		{ 
			firstName.focus();  
			return false;  
		}  
	}
	
	function allLetterWithSpaceAndHyphen(lastName)  
	{   
		var letters = /^[A-Za-z -]+$/;  
		if(lastName.value.match(letters))  
		{  
			return true;  
		}  
		else  
		{   
			firstName.focus();  
			return false;  
		}  
	}
	
	function oneAlphaOnly(midInit){
		if(midInit.length > 1){
			midInit.focus();  
			return false;
		}else{
			return true;
		}
	}
	
	function validDob(dateString) {
	  var regEx = /^\d{4}-\d{2}-\d{2}$/;
	  if(!dateString.match(regEx))
		return false;  // Invalid format
	  var d;
	  if(!((d = new Date(dateString))|0))
		return false; // Invalid date (or this could be epoch)
	  return d.toISOString().slice(0,10) == dateString;
	}
	

</script>

      <form class="form" id="userform" name="userform" method="post" action="dml.php" onSubmit="return formValidation()">		
		
		<?php 
			if(!empty($_GET['id']) and isset($_GET['id'])){
				$id = $_GET['id'];
				include_once('DependencyContainer.php');
				include_once('StorageInDB.php');
				$di = new DependencyContainer;
				$storageObject = new StorageInDB($di);
				$row = $storageObject->find($id); 
				echo '<h2 class="form-heading">Please edit User details</h2>';
			}else{
				echo '<h2 class="form-heading">Please Fill in User details</h2>';
			}
			
			
				?>
				<div>
					<span class="error" style="color:red;" id="error"><?php echo $_SESSION['err']; $_SESSION['err']='';?></span>
				</div>
				
		
		
		<div class="radio">
          <label>
            <input type="radio" name="storageType"  id='storageType_radio_0' value="file"> Store in File
          </label>
		  <label>
            <input type="radio" name="storageType"  id='storageType_radio_1' value="db"> Store in DB
          </label>
        </div>
		
        <label for="username" class="sr-only">Username</label>
        <input type="text" id="username" name="username" class="form-control" value="<?php if(isset($id)) echo $row['username']; ?>" placeholder="Please enter Username" required autofocus>

		<label for="title" class="sr-only">Title</label>        
		<select id="title" name="title" class="form-control" required>
			<option value="">Title</option>
			<option <?php if(isset($id)){ if($row['title']=='Mr'){ ?> selected="selected" <?php }} ?> value="Mr">Mr</option>
			<option <?php if(isset($id)){ if($row['title']=='Mrs'){ ?> selected="selected" <?php }} ?> value="Mrs">Mrs</option>
			<option <?php if(isset($id)){ if($row['title']=='Miss'){ ?> selected="selected" <?php }} ?> value="Miss">Miss</option>
			<option <?php if(isset($id)){ if($row['title']=='Ms'){ ?> selected="selected" <?php }} ?> value="Ms">Ms</option>
			<option <?php if(isset($id)){ if($row['title']=='Dr'){ ?> selected="selected" <?php }} ?> value="Dr">Dr</option>
			<option <?php if(isset($id)){ if($row['title']=='Professor'){ ?> selected="selected" <?php }} ?> value="Professor">Professor</option>
		</select>
		
		<label for="firstName" class="sr-only">First Name</label>
        <input type="text" id="firstName" name="firstName" class="form-control" value="<?php if(isset($id)) echo $row['firstName']; ?>" placeholder="First name" required>		
		
        <label for="midInit" class="sr-only">Middle Initial</label>
        <input type="text" id="midInit" name="midInit" class="form-control" value="<?php if(isset($id)) echo $row['middleInitial']; ?>" placeholder="Middle Initial">
		
        <label for="lastName" class="sr-only">Last Name</label>
        <input type="text" id="lastName" name="lastName" class="form-control" value="<?php if(isset($id)) echo $row['lastName']; ?>" placeholder="Last name" required>
		
		<label for="gender" class="sr-only">Gender</label>
        <select id="gender" name="gender" class="form-control" required>
			<option value="">Gender</option>
			<option  selected="selected"  value="M">Male</option>
			<option <?php if(isset($id)){ if($row['gender']=='F'){ ?> selected="selected" <?php }} ?> value="F">Female</option>
		</select>
        
		<label for="dob" class="sr-only">Date of Birth</label>
        <input type="text" id="dob" name="dob" class="form-control" value="<?php if(isset($id)) echo $row['dob']; ?>" placeholder="Date of Birth (YYYY-MM-DD)" required>
		<div>
			<a class="btn btn-lg btn-warning" href="javascript:history.back()">Back</a>
			<?php if(isset($id)) {?>
				<input type="hidden" name="flag" value="update">
				<input type="hidden" name="userid" value="<?php echo $id; ?>">
				<button class="btn btn-lg btn-success" id="submit" type="submit">Update</button>
			<?php }else	{	?>
				<button class="btn btn-lg btn-primary" id="submit" type="submit">Create</button>
			<?php }		?>
			
		</div>
      </form>
	  



<?php
	require_once('footer.php');
?>
    

