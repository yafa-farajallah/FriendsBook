<?php
    class DB{
		public $conn;
		public $error;
        function __construct() {
		    $this->connect();	
			}
			
		private function connect(){
			$this->conn = new mysqli("localhost","root","","friendsworld");
			
			if ($this->conn->connect_error) {
				$this->conn = FALSE;
				die("could not connect to database " . mysql_connect_error());
				}	
		}


		public function close(){
			return mysqli_close($this->conn);
        }

		function SelectData($query){
			$result =$this->conn->query($query);
			if($result->num_rows>=1){
				return $result;
			}else{
				$this->err = $this->conn->error;
				return FALSE;
			}
			$result->free();
		}

		public function InsertData($query){
			$this->conn->query($query);
			if($this->conn->affected_rows>=1){
			  return TRUE;
			}else{
			  $this->err = $this->conn->error;
			  return FALSE;
			}
		  }
}
	
	$db = new DB();
    if(!$db) {
        echo $db->lastErrorMsg();
        die();
    }
?>
