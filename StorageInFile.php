<?php
include_once('iStorage.php');
class StorageInFile implements iStorage {
	private $filename;
	private $content;
	
	public function __construct(){		
			$this->filename = 'test.txt';//$_GET['filename'];
	}
	
	public function save($data){
		if(count($data)>0){
			$str = $data['username'].", ".$data['title'].", ".$data['firstName'].", ".$data['midInit'].",";
			$str .=	$data['lastName'].", ".$data['gender'].", ".$data['dob']."\r\n";
			file_put_contents($this->filename, $str, FILE_APPEND);
		}
	}

	/**
	*	read data from file
	*/
	public function read(){		
		$lines = file($this->filename);//file in to an array
		return $lines;
	}
	
	/**
	*	find data from file
	*	pass $data param
	*/
	public function find($data){
		// read a line from file
		$lines = file($this->filename);//file in to an array
		return $lines[$data]; //return selected line only
	}

	/**
	*	Delete data from file
	*	pass $data param
	*/
	public function delete($data){ //delete specific line from file
		file_put_contents($this->filename, str_replace($data . "\r\n", "", file_get_contents($this->filename)));
	}	
}