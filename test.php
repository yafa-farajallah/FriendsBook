<?php 
session_start();
require('conn.php');
$db;
$connection=$db->conn;
$userid=$_SESSION['userId'];
$posts_check_query = "SELECT * FROM posts WHERE userid=$userid 
or userid  in ( SELECT USERID2 FROM FRIENDSHIP WHERE USERID=$userid) 
order by datetimecurrent DESC";
$result = mysqli_query($connection, $posts_check_query);
echo mysqli_error($connection);
foreach ($result as  $row) {
echo $row['postText']. "<br>";
}
        ?>