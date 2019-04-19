<?php
session_start();
require('conn.php');

if(isset($_POST['commentText']) && $_POST['commentText']!='')
{
    $connection=$db->conn;
    $comment_text=$connection->real_escape_string($_POST['commentText']);
    $postId= $_GET['postId'];
    $userId=$_SESSION['userId'];
    $query = "INSERT INTO comments (postId,userId,dateCurrent,CommentText)VALUES ($postId,$userId,curTime(),'$comment_text')";
    $result = $db->InsertData($query);
    $comment_id = mysqli_insert_id($db->conn);
    $comment=$db->get_comment($comment_id);
$responce=[];
$responce['comment_html']=$db->get_comment_html($comment);
$responce['no_comments']=$db->count_comments($postId) ;

    echo json_encode($responce);
}

 ?>