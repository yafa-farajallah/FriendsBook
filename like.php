<?php
session_start();
require('conn.php'); 

$connection=$db->conn;

$postId= $_GET['postid'];
$userId=$_SESSION['userId'];

$query1="SELECT * FROM LIKES WHERE postId=$postId and userId=$userId";
$query2="DELETE FROM LIKES WHERE postId=$postId and userId=$userId";
$query3="INSERT INTO LIKES (postId,userId,dateCurrent)VALUES ($postId,$userId,curTime())";

$response=[];
$result=$db->SelectData($query1);
if($result){
    
    $del=$db->InsertData($query2);
    $response['color']="black";
}
else{
    
    $add=$db->InsertData($query3);
    $response['color']=" #de41b0";
}

$response['no_likes']=$db->count_likes($postId);

echo json_encode($response);

?>