<?php
session_start();
require('conn.php'); 

$connection=$db->conn;

$friendid= $_GET['friendid'];
$userId=$_SESSION['userId'];

$query="INSERT INTO `notifications`( `forUserId`, `notificationType`, `userReqIdFrind`, `notificationContent`, `seen`, `dateCurrent`)
VALUES ($userId,0,$friendid,$userId.'sent request to you',0,curTime())";


$del=$db->InsertData($query);


//echo "success";

?>