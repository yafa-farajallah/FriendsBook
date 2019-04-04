<?php 
session_start();
require('conn.php');
		   $username=$_SESSION['username'];
           $posts_check_query = "SELECT * FROM posts WHERE userid=2 or userid  in ( SELECT USERID2 FROM FRIENDSHIP WHERE USERID=2) order by datetimecurrent DESC";
         $result = mysqli_query($conn, $posts_check_query);
         echo mysqli_error($conn);
         $posts = mysqli_fetch_assoc($result);
         $text=$posts['posttext'];
         echo "$text";
        ?>