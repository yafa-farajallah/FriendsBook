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


	}
	
	$db = new DB();
    if(!$db) {
        echo $db->lastErrorMsg();
        die();
    }
?>
