<?php
session_start();
require('conn.php'); 

if($_GET["text"]!='')
{
$connection=$db->conn;
$reciever=substr($_GET["reciever"], 0, 32);
$userId=$_SESSION['userId'];
$sender=$db->FullName($userId);
$text=substr($_GET["text"], 0, 128);
//escaping is extremely important to avoid injections!
$recieverEscaped = htmlentities($connection->real_escape_string($reciever)); //escape reciever and limit it to 32 chars
$textEscaped = htmlentities($connection->real_escape_string($text)); //escape text and limit it to 128 chars

$query = "INSERT INTO `massages`( `sender`, `reciever`, `text`) VALUES ('$sender','$recieverEscaped','$textEscaped')";
$done=$db->InsertData($query);    
  }
 ?>