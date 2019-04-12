<?php
session_start();
require('conn.php'); 
if(isset($_POST['post']))
{
$connection=$db->conn;
$post=$connection->real_escape_string($_POST['post']);
$userId=$_SESSION['userId'];
	$query = "INSERT INTO posts (userid,postText,dateTimeCurrent)VALUES ('$userId','$post',curTime())";
    if ($db->InsertData($query))
      header("location:index.php");
  }
  else {echo mysqli_error($db->conn);}
 ?>