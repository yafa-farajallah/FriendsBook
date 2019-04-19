<?php
session_start();
require('conn.php'); 

$connection=$db->conn;

$friendid= $_GET['friendid'];
$userId=$_SESSION['userId'];

$done=$db->insert_notification($userId,$friendid);

?>