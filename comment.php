<?php
session_start();
require('conn.php'); 

if(isset($_POST['commentText']) && $_POST['commentText']!='')
{
$connection=$db->conn;
$comment=$connection->real_escape_string($_POST['commentText']);
$postId= $_GET['postId'];
$userId=$_SESSION['userId'];
	$query = "INSERT INTO comments (postId,userId,dateCurrent,CommentText)VALUES ($postId,$userId,curTime(),'$comment')";
    $result=$db->InsertData($query);
   echo $db->count_comments($postId) ;  
}

 ?>