<?php
session_start();
require('conn.php'); 
$page=$_GET['page'];
if(isset($_POST['post']) && $_POST['post']!='')
{
$connection=$db->conn;
$post=$connection->real_escape_string($_POST['post']);
$userId=$_SESSION['userId'];
if(isset($_GET['postId']))
{
  $postId=$_GET['postId'];
  $query = "UPDATE posts SET postText='$post' WHERE  postId=$postId";
}
else
{
  $query = "INSERT INTO posts (userid,postText,dateTimeCurrent)VALUES ('$userId','$post',curTime())";
}
    if ($db->InsertData($query))
      header("location:".$page);
  }
  else {echo mysqli_error($db->conn);
    header("location:".$page);}

 ?>