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

	public function get_comments($postId){
		$qurey="SELECT * FROM comments WHERE postid=$postId order by dateCurrent DESC";
		return($this->SelectData($qurey));
	}

	public function get_comment($commentId){
		$qurey="SELECT * FROM comments WHERE commentId=".$commentId;
		$result=$this->SelectData($qurey);
		return mysqli_fetch_assoc($result);
	}

	public function FullName($userId){

		$result=$this->SelectData("SELECT firstName,lastName FROM userac WHERE userId=".$userId);
		$name= mysqli_fetch_assoc($result);
		return $name['firstName']." ".$name['lastName'];


	}

	public function get_comment_html($comment) {
		$comment_template = <<< COMMENT_HTML
	<div class="comment">
	<div class="commenter">
		<img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="media-object" width="30px">
	</div>
    <div  class="commenter" style="color: #de41b0; font-size:17px; ">{{name}}</div>

    <div class="" style=" font-size:15px;">{{comment_text}}</div>
    <div class="date" style=" font-size:10px;">{{comment_date}}</div>
	</div>
COMMENT_HTML;
    $comment_html = $comment_template;
    $comment_html = str_replace("{{name}}", $this->FullName($comment['userId']), $comment_html);
    $comment_html = str_replace("{{comment_text}}", $comment['CommentText'], $comment_html);
    $comment_html = str_replace("{{comment_date}}", $comment['dateCurrent'], $comment_html);
	return $comment_html;
	}
}
	
	$db = new DB();
    if(!$db) {
        echo $db->lastErrorMsg();
        die();
    }
?>
