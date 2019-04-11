<?php
session_start();
require('conn.php'); 
if(isset($_POST['post']))
{
$post=$_POST['post'];
$userId=$_SESSION['userId'];
	$query = "INSERT INTO posts (userid,postText,dateTimeCurrent)VALUES ('$userId','$post',curTime())";
    if ($db->InsertData($query))
      header("location:index.php");
  }
 ?>