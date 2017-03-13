<?php
include_once('iStorage.php');
include_once('DependencyContainer.php');
class StorageInDB implements iStorage {
	
	private $dbh;
	
	public function __construct(DependencyContainer $di){		
			$this->dbh = $di->getDb();
			//echo 'Connected to Database<br/>';
	}
	
	/**
	*	save and update data from users
	*	pass $data param
	*/
	
	public function save($data){
		// Update data
		if(isset($data['flag']) and $data['flag'] == 'update'){
			$sql = "update users set
			username = :username,
			title = :title,
			firstName = :firstName,
			middleInitial = :midInit,
			lastName = :lastName,
			gender = :gender,
			dob = :dob
			where id = :id";
			$stmt = $this->dbh->prepare($sql);
			
			try {
				if($stmt->execute(array('username' => $data['username'],
								'title'  => $data['title'],
								'firstName'  => $data['firstName'],
								'midInit' => $data['midInit'],
								'lastName' => $data['lastName'],
								'gender' => $data['gender'],
								'dob' => $data['dob'],
								'id' => $data['userid']
								))){
									return true;
								}else{
									return false;
								}
				} catch (PDOException $e) {
					return 'Connection failed: ' . $e->getMessage();
				}
		}else{
			// Insert data			
			
			$sql = "INSERT INTO users ( username, title, firstName, middleInitial, lastName, gender, dob) 
			VALUES (:username, :title, :firstName, :midInit, :lastName, :gender, :dob);";
			$stmt = $this->dbh->prepare($sql);
			try {
				if($stmt->execute(array('username' => $data['username'],
								'title'  => $data['title'],
								'firstName'  => $data['firstName'],
								'midInit' => $data['midInit'],
								'lastName' => $data['lastName'],
								'gender' => $data['gender'],
								'dob' => $data['dob']
								))){
									return true;
								}else{
									return false;
								}
			} catch (PDOException $e) {
				return 'Connection failed: ' . $e->getMessage();
			}				
								
		}	 		
	}

	/**
	*	Read data from users
	* 	return result
	*/
	public function read(){
		$sql = "SELECT * FROM users order by id desc";
		$stmt = $this->dbh->prepare($sql);		 
		$stmt->execute();
		return $stmt->fetchAll();		
	}
	
	/**
	*	Find data from users
	*	pass $data param
	* 	return result
	*/
	public function find($data){
		$sql = "SELECT * FROM users where id= :id";
		$stmt = $this->dbh->prepare($sql);		 
		$stmt->execute(array('id' => $data));
		return $stmt->fetch();
	}
	
	/**
	*	Delete data from users
	*	pass $data param
	*/
	public function delete($data){
		$sql = "delete from users where id = :id";
		$stmt = $this->dbh->prepare($sql);		 
		try {
			if($stmt->execute(array('id' => $data))){
									return true;
								}else{
									return false;
								}
		} catch (PDOException $e) {
			return 'Connection failed: ' . $e->getMessage();
		}
	}	
}