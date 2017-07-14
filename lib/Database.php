<?php
include 'config/config.php';
/**
* 
*/
class Database
{
	public $host   = DB_HOST;
	public $user   = DB_USERNAME;
	public $pass   = DB_PASSWORD;
	public $dbname = DB_NAME;
	
	public $link;
	public $error;

	function __construct()
	{
		$this->ConnectDB();
	}

	private function ConnectDB(){
		$this->link = new mysqli($this->host,$this->user,$this->pass,$this->dbname);
		if(!$this->link)
		{
           $this->error = "Connection Failed...".$this->link->connect_error;
           return false;
		}
	}

	//Select Data
	public function select($data)
	{
		$result = $this->link->query($data) or die($this->link->error.__LINE__);
		if($result->num_rows>0){
			return $result;
		}
		else{
			return false;
		}
	}

	//Insert Data

	public function insert($data)
	{
		$insert_row = $this->link->query($data) or die($this->link->error.__LINE__);
		if($insert_row){
			return $insert_row;
		}else{
			return false;
		}
	}

	//Upadate Data

	public function update($data)
	{
		$updata_row = $this->link->query($data) or die($this->link->error.__LINE__);
		if($updata_row){
			return $updata_row;
		}else{
			return false;
		}

	}

	//Delete Data

	public function delete($data)
	{
		$delete_row = $this->link->query($data) or die($this->link->error.__LINE__);
		if($delete_row){
			return $delete_row;
		}else{
			return false;
		}

	}

}


?>