<?php
session_start();
require('conn.php'); 
if(isset($_POST['post']))
{
$post=$_POST['post'];
$username=$_SESSION['username'];
$query ="SELECT userid FROM userac where username='$username'";
$result =mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);
$userid=$row[0];
	$query = "INSERT INTO posts (userid,postText)VALUES ('$userid','$post')";
      mysqli_query($conn,$query);
      header("location:index.php");
  }
 ?>