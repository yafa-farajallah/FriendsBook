<?php
    session_start();
    require('conn.php'); 
    $userId=$_SESSION['userId'];
    $postId=$_GET['postId'];
    $delete_likes ="DELETE FROM `likes` WHERE `postId`=$postId";
    $delete_comments="DELETE FROM `comments` WHERE `postId`=$postId";
    $delete_post = "DELETE FROM `posts` WHERE postId=$postId and userId=$userId";
    $query="SELECT  `userId` FROM `posts` WHERE `postId`=$postId";
    $result=$db->SelectData($query);
    $post_writer=mysqli_fetch_array($result);
    $post_writer=$post_writer[0];
    if($post_writer==$userId){
        $del1=$db->InsertData($delete_likes);
        $del2=$db->InsertData($delete_comments);
        $del3=$db->InsertData($delete_post);
        if($del3)
            echo 0;
        else
            echo 1;
    }
     else 
     echo 2;       
?>
