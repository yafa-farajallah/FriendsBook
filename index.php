<?php
require('conn.php');
if (isset($_GET['action']))
{
  DoAction($_GET['action']);
}

function DoAction($action)
{  global $db;
   $connection=$db->conn;
    switch($action)
   {  
    case 'login':{
    session_start();
    $username = $connection->real_escape_string($_POST['username']);
    $password = $connection->real_escape_string($_POST['password']);
    $query ="SELECT userId FROM userac where username='$username' and password='$password'";
    $result=$db->SelectData($query);
    $user=mysqli_fetch_array($result);

    if ($user)
    {
      $_SESSION['userId'] = $user[0];
        header("location:index.php");
    }
    else{
      die(header("location:login.php?LogInStatus=failed"));
    
      }
      break;
    }

    case 'register':{ 
      $username=$connection->real_escape_string($_POST['username']);
      $password=$connection->real_escape_string($_POST['password']);
      $firstname=$connection->real_escape_string($_POST['firstname']);
      $lastname=$connection->real_escape_string($_POST['lastname']);
      $teleno=$connection->real_escape_string($_POST['teleno']);
      $email=$connection->real_escape_string($_POST['email']);
      $gender=$connection->real_escape_string($_POST['gender']);
      $birthdate=$connection->real_escape_string($_POST['birthdate']);
      
      $query = "SELECT userId FROM userac WHERE username='$username'";
      $result=$db->SelectData($query);
        $user=mysqli_fetch_array($result);
      
      if ($user) { // if user exists
        header("location:register.php?RegisterFailed=true");
      }
      else {
      $query = "INSERT INTO userac (username,password,firstname, lastname,teleno,email,gender,birthdate)
        VALUES ('$username','$password','$firstname','$lastname','$teleno','$email',$gender,'$birthdate')";
      if ($db->InsertData($query))
      header('location:login.php?LogInStatus=confirm');
      }
      break;
      }

    case 'logout':{
      session_start();

      if(isset($_SESSION['userId']))
        unset($_SESSION['userId']);

      header("location:login.php");
              break;
    }
  }
}
session_start();
if(isset($_SESSION['userId'])){
  $id=$_SESSION['userId'];
  $query ="SELECT * FROM userac where userId=$id";
  $result=$db->SelectData($query);
  $user=mysqli_fetch_array($result);
  $firstName=$user[3];
  $lastName=$user[4];
?>
<!DOCTYPE html>
<html>
<head>
	<title>FriendsWorld</title>
	<link rel="icon" href="images/caticon.png">
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/index.css" rel="stylesheet" media="all">
  </head>
<body>

	
	<nav class=" navbar navbar-default pink">
  <div  class="container-fluid ">
    

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div  class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="media-object"></li>
        <li ><a style="color: white; padding-right: 0px;"href="index.php"><?php echo $firstName." ".$lastName ?></a></li>
        <li ><a style="color: white;margin-left: 20px;"href="index.php">Home Page</a></li>
        
        
      </ul>
    
      <ul class="nav navbar-nav navbar-right">
        <li><img src="images/whiteicon.png" style="margin-top: 12px;"></li>
        <li><a a style="color: white;"href="index.php?action=logout">logout</a></li>
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<div class="container">
<div class="row">
<div class="col-md-9 col-sm-12 pull-left posttimeline">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="status-upload nopaddingbtm">
              <form action="post.php" method="post">
                <input type="textarea" class="form-control" name="post"  placeholder="What are you doing right now?">
                <br>
                <ul class="nav nav-pills pull-left ">
                 
                  <li><a style="color: #de41b0;"title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Picture"><i class="glyphicon glyphicon-picture"></i></a></li>
                </ul>
                <input type="submit" name="share" value="Share" style="background-color:  #de41b0;border-color:#de41b0;"type="submit" class="btn btn-success pull-right">
              </form>
            </div>
            <!-- Status Upload  --> 
          </div>
        </div>
 <?php 
 
 $userid=$_SESSION['userId'];
 $qurey="SELECT * FROM posts WHERE userid=$userid 
or userid  in ( SELECT USERID2 FROM FRIENDSHIP WHERE USERID=$userid) 
or userid  in ( SELECT USERID FROM FRIENDSHIP WHERE USERID2=$userid)
order by datetimecurrent DESC";
$posts=$db->SelectData($qurey);
 
 if($posts)
  foreach($posts as  $row):?>
        <div class="panel panel-default">
          <div class="btn-group pull-right postbtn">
            <button type="button" class="dotbtn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="dots"></span> </button>
            <ul class="dropdown-menu pull-right" role="menu">
              <li><a href="javascript:void(0)">Hide this</a></li>
              <li><a href="javascript:void(0)">Report</a></li>
            </ul>
          </div>
          <div class="col-md-12">
            <div class="media">
              <div class="media-left"> <a href="javascript:void(0)"> <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="media-object"> </a> </div>
              <div class="media-body">
                <?php $result=$db->SelectData("SELECT firstName,lastName FROM userac WHERE userId=".$row['userId']);
                $name=mysqli_fetch_assoc($result);
                 ?>
                <h4 class="media-heading"> <?php echo $name['firstName']." ".$name['lastName'] ; ?> <br>
                  <small><i class="fa fa-clock-o"></i> <?php echo $row['dateTimeCurrent']; ?> </small> </h4>
                <p><?php echo $row['postText']; ?> </p>
                <?php  
                 $result=$db->SelectData("SELECT COUNT(likeId)  FROM likes WHERE postId=".$row['postId']);
                $Nlikes=mysqli_fetch_assoc($result);
                 $result=$db->SelectData("SELECT COUNT(commentId)  FROM comments WHERE postId=".$row['postId']);
                $Ncomments=mysqli_fetch_assoc($result);
                $postId=$row['postId'];
                ?>
                <ul class="nav nav-pills pull-left ">
                  <li><a id="like" style="color: #de41b0;"  href="like.php?postid=<?php echo $postId ?>" title=""><i style="color: #de41b0;" class="glyphicon glyphicon-thumbs-up"></i> <?php echo $Nlikes['COUNT(likeId)']; ?></a></li>
                  <li><a style="color: #de41b0;" href="" title=""><i style="color: #de41b0;"  class=" glyphicon glyphicon-comment"></i><?php echo $Ncomments['COUNT(commentId)']; ?></a></li>
                  
                </ul>
              </div>
            </div>
          </div>
          <div class=" panel-body col-md-12 border-top">
            <div class=" status-upload nopaddingbtm status-upload">

              
              <form action="comment.php?postId=<?php echo $row['postId']; ?>" method="post">
                  <label style="color: #de41b0;" >Comment</label>
                  <textarea name="commentText" class="form-control" placeholder="Comment here"></textarea>
                  <br>
                  
                  <button name="comment" style="background-color:  #de41b0;border-color:#de41b0;" type="submit" class="btn btn-success pull-right"> Comment</button>
                <br><br>
              </form>
                <?php 
 
                    
                    $qurey="SELECT * FROM comments WHERE postid=$postId order by dateCurrent DESC";
                    $comments=$db->SelectData($qurey);
                    
                    if($comments)
                      foreach($comments as  $comment):?>
                      <div class="comment">
                        <?php $result=$db->SelectData("SELECT firstName,lastName FROM userac WHERE userId=".$comment['userId']);
                          $name=mysqli_fetch_assoc($result);
                        ?>
                        <div class="commenter"><img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="media-object" width="30px"></div>
                        <div  class="commenter"  style="color: #de41b0; font-size:17px; "><?php echo $name['firstName']." ".$name['lastName'] ; ?></div>
                       
                        <div class="" style=" font-size:15px;"><?php echo $comment['CommentText']; ?></div>
                        <div class="date" style=" font-size:10px;"><?php echo $comment['dateCurrent']; ?> </div>
                      </div>
                      <?php endforeach; ?>
            </div>
            <!-- Status Upload  --> 
            
          </div>
        </div>
<?php endforeach; ?>
</div>


 <div class="col-md-3 col-sm-12 pull-right">
        <div class="panel panel-default">
          <div class="panel-heading">
            <p class="page-subtitle small"><b>people you may know at FriendsWorld </b>
            <img src="images/caticon.png" ></p>
          </div>
          
          <?php
          $userid=$_SESSION['userId'];
            $notfriends=$db->SelectData("SELECT firstName,lastName FROM userac where userId not in (SELECT userId2 FROM friendship where userId =$userid)");
               
                while($notFriend = mysqli_fetch_array($notfriends))
                {
                    echo '<div style="margin-bottom: 10px;margin-top: 3px;margin-left: 10px;" class="clearfix"> <b style="color: black;">' . $notFriend[0].' '.$notFriend[1].'</b><button  style=
                    " margin-left: 10px;margin-right: 10px; background-color: #de41b0; color:white; float:right;" class="btn btn--radius-2 btn--blue"
                     type="submit" name="addFriends">Add Friend</button></div>';
         }
          ?>
        

        </div>
        </div>
	
</div>
</div>
<?php

?>
<script type="text/javascript">

function add_like()
{
    jQuery.ajax({
        type: "POST",
        url: "like.php?postid=<?php echo $postId;?> ",
        data: {functionname: 'addlike'}, 
         success:function(data) {
        //alert(data); 
         }
    });
}
$(document).ready(function() {
    $("#like").click(function() { add_like(); });
});

  </script>
</body>
</html>

<?php
}
else{
	header("location:login.php?loginStatus=notlogin");
}
?>