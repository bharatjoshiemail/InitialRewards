<?php
include_once('DependencyContainer.php');
include_once('StorageInDB.php');
include_once('StorageInFile.php');
class StorageFactory{
	
	private $storageClassType;
	
	public function getTypeOfStorage($storageType){
		if($storageType == 'db'){
			$di = new DependencyContainer;
			$this->storageClassType = new StorageInDB($di);
		}
		elseif($storageType == 'file'){
			$this->storageClassType = new StorageInFile();
		}
		else{
			echo 'Pls select storage type = DB | File';
		}
		return $this->storageClassType;
	}
}