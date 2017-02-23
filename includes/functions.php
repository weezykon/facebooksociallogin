<?php
class Users {
	public $table_name = 'login';
	
	function __construct(){
		//database configuration
		$dbServer = 'localhost'; //Define database server host
		$dbUsername = 'root'; //Define database username
		$dbPassword = ''; //Define database password
		$dbName = 'social_login'; //Define database name
		
		//connect databse
		$con = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
		if(mysqli_connect_errno()){
			die("Failed to connect with MySQL: ".mysqli_connect_error());
		}else{
			$this->connect = $con;
		}
	}
	
	function checkUser($oauth_provider,$oauth_uid,$fname,$lname,$email,$gender,$locale,$picture){
		
		$prev_query = mysqli_query($this->connect,"SELECT * FROM ".$this->table_name." WHERE oauth_provider = '".$oauth_provider."' AND token = '".$oauth_uid."'") or die(mysql_error($this->connect));
		if(mysqli_num_rows($prev_query)>0){
			$update = mysqli_query($this->connect,"UPDATE $this->table_name SET oauth_provider = '".$oauth_provider."', token = '".$oauth_uid."', firstname = '".$fname."', lastname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$oauth_provider."' AND token = '".$oauth_uid."'");
		}else{
			$insert = mysqli_query($this->connect,"INSERT INTO $this->table_name SET oauth_provider = '".$oauth_provider."', token = '".$oauth_uid."', firstname = '".$fname."', lastname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'");
		}
		
		$query = mysqli_query($this->connect,"SELECT * FROM $this->table_name WHERE oauth_provider = '".$oauth_provider."' AND token = '".$oauth_uid."'");
		$result = mysqli_fetch_array($query);
		return $result;
	}
}
?>