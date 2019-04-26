<?php
session_start();
require('conn.php'); 

$connection=$db->conn;
$userId=$_SESSION['userId'];

if(isset($_GET['friendid'])){
$friendid= $_GET['friendid'];
$done=$db->insert_notification($userId,$friendid);
}

if(isset($_GET['senderId'])){
    $senderId= $_GET['senderId'];
    $db->remove_notification($senderId,$userId);
    $status=$_GET['status'];
    if($status=='accept')
      $done=$db->accept_request($senderId,$userId);
    
}

?>