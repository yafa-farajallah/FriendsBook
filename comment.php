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
    if ($db->InsertData($query))
      header("location:index.php");
  }
  else {echo mysqli_error($db->conn);
  header("location:index.php");}
 ?>