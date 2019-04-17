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

		public function count_likes($postId){
			$result=$this->SelectData("SELECT COUNT(likeId)  FROM likes WHERE postId=".$postId);
			$Nlikes=mysqli_fetch_assoc($result);
			return $Nlikes['COUNT(likeId)'];
		}

		public function count_comments($postId){
			$result=$this->SelectData("SELECT COUNT(commentId)  FROM comments WHERE postId=".$postId);
			$Ncomments=mysqli_fetch_assoc($result);
			return $Ncomments['COUNT(commentId)'];
		}

}
	
	$db = new DB();
    if(!$db) {
        echo $db->lastErrorMsg();
        die();
    }
?>
