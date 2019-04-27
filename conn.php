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

	public function count_friends ($userid){
		$qurey="SELECT COUNT(userId) FROM userac WHERE  userid  in 
		( SELECT USERID2 FROM FRIENDSHIP WHERE USERID=$userid) 
         or userid  in ( SELECT USERID FROM FRIENDSHIP WHERE USERID2=$userid) ";
        $friends=$this->SelectData($qurey);
 
            if($friends)
              {   $Nfriends=mysqli_fetch_assoc($friends);
            	return  $Nfriends['COUNT(userId)'];
              }
	}

	public function count_posts($userid)
	{
        $qurey="SELECT COUNT(postId) FROM posts WHERE userid=$userid ";
        $posts=$this->SelectData($qurey);
         if($posts)
            { $NPosts=mysqli_fetch_assoc($posts);
            	return $NPosts['COUNT(postId)'];
            }           
	}

	public function my_friends($userid)
	{
	    $friends=$this->SelectData("SELECT firstName,lastName FROM userac WHERE  userid  in 
	    ( SELECT USERID2 FROM FRIENDSHIP WHERE USERID=$userid) 
         or userid  in ( SELECT USERID FROM FRIENDSHIP WHERE USERID2=$userid) ");
	    return $friends;
    }

    public function my_posts($userid)
    {
     $qurey="SELECT * FROM posts WHERE userid=$userid 
     order by datetimecurrent DESC";
     $posts=$this->SelectData($qurey);
     return $posts;
    }
    
    public function my_friends_posts($userid)
    {
    $qurey="SELECT * FROM posts WHERE userid=$userid 
    or userid  in ( SELECT USERID2 FROM FRIENDSHIP WHERE USERID=$userid) 
    or userid  in ( SELECT USERID FROM FRIENDSHIP WHERE USERID2=$userid)
    order by datetimecurrent DESC";
    $posts=$this->SelectData($qurey);
    return $posts;
  }
  public function like_color($postId,$userId){
		$query="SELECT * From likes where userId=$userId and postId=$postId"	;
		if($this->SelectData($query))
		return "#de41b0";
		else
		return "black";
	   }
	    public function get_not_friends($userid){
		return $this->SelectData("SELECT userId,firstName,lastName FROM userac
		 where userId not in (SELECT userId2 FROM friendship where userId =$userid) and userId!=$userid");
	}

 	public function request_status($userId,$notfriendId){
	 $query="SELECT * From notifications where forUserId=$userId and userReqIdFrind=$notfriendId"	;
	 if($this->SelectData($query))
	 return "Request Sent";
	 else
	 return "Add Friend";
	} 

 	public function insert_notification($userId,$friendId){
		$query="INSERT INTO notifications ( forUserId, notificationType, userReqIdFrind, notificationContent, seen, dateCurrent)
		VALUES ($userId,0,$friendId,$userId,0,curTime())";
		return $this->InsertData($query);
	}

	public function accept_request($senderId,$userId){
		$query="INSERT INTO `friendship`( `userId`, `userId2`, `dateCurrent`) VALUES ($senderId,$userId,curTime())";
		return $this->InsertData($query);	
	}

	public function remove_notification($senderId,$userId){
		$query="DELETE FROM `notifications` WHERE `forUserId`=$senderId and `userReqIdFrind`=$userId";
		$done= $this->InsertData($query);	
	}
	
  public function get_notification($userid)
  {
  	$query="SELECT * FROM notifications WHERE userReqIdFrind=$userid  
     order by dateCurrent DESC";
     $result =$this->SelectData($query);
	 $output="";
	 $count=0;
		if($result)
		{
			foreach($result as $row)
				  {
					  if ($row['seen']==0)
					  $count=$count+1;
					$senderId=$row['forUserId'];  
                   $senderName=$this->FullName($senderId);
				   $output =$output. "
				   <li id='$senderId' class='acceptFriend'>
				    <a>
				     <strong>".$senderName." send a friend request</strong><br />
					 <small><em>
					   <button 
					   class='accept btn btn--radius-2 btn--blue addfriend' style=' margin-left: 10px;
					   margin-right: 10px;
					   background-color: #de41b0;
					   color:white; 
					   margin-top:10px;
					  '
								name='Accept'>Accept</button>
						<button 
						class='denay btn btn--radius-2 btn--blue addfriend' style=' margin-left: 10px;
						margin-right: 10px;
						background-color: #de41b0;
						color:white; 
						margin-top:10px;
						'
									name='Denay'>Denay</button>		
					 </em></small>
				    </a>
				   </li>
				   <li class='divider'></li>
				   ";
				  }
		}
		else
		{
			$output=$output."<li><a class='text-bold text-italic'>No Notification Found</a></li>";
		}
		 return [$output,$count];
  }

}
	
	$db = new DB();
    if(!$db) {
        echo $db->lastErrorMsg();
        die();
    }
?>

