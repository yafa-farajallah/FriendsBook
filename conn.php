<?php
    class DB{
		public $conn;
        function __construct() {
			$conn = mysqli_connect("localhost","root","","friendsworld");
			if(!$conn){
				die("could not connect to database " . mysql_connect_error());
			   
			 
			}
		
		public function close(){
			return mysqli_close($this->$conn);
        }

		function GetUser($username,$password){
			$query ="SELECT * FROM userac where username='$username' and password='$password'";
			$result =mysqli_query($conn,$query);
			$user=mysqli_fetch_array($result);
			return $user;
		}

	}
	
	$db = new DB();
    if(!$db) {
        echo $db->lastErrorMsg();
        die();
    }
?>
