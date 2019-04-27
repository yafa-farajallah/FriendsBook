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
  $userid=$_SESSION['userId'];
  $name=$db->FullName($userid);
?>
<!DOCTYPE html>
<html>
<head>
	<title>FriendsWorld</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<link rel="icon" href="images/caticon.png">
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/index.css" rel="stylesheet" media="all">
  </head>
<body>

	
	<nav class=" navbar navbar-default ">
  <div  class="container-fluid ">
    

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div  class="collapse navbar-collapse navbar-fixed-top pink " id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="media-object"></li>
        <li ><a style="color: white; padding-right: 0px;"href="profile.php"><?php echo $name ?></a></li>
        <li ><a style="color: white;margin-left: 20px;"href="index.php">Home Page</a></li>
        
        
      </ul>
     
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a id="notification" class="dropdown-toggle"  data-toggle="dropdown" style=" cursor:pointer; font-size:18px; color:white;">
            <span class="label label-pill label-danger count notification_count" style="border-radius:10px;"></span>
            Notification</a>
          <ul  id="notification_menu" class="dropdown-menu " role="navigation" aria-labelledby="dLabel">

           </ul>
        </li>
          
        <li >
          <a href="massenger.php"  >
            <span class="label label-pill label-danger count" style="border-radius:10px;"></span>
            <span class="glyphicon glyphicon-envelope" style="font-size:18px; color:white;margin-left: 20px;"></span></a>
          
        </li>

        <li><img src="images/whiteicon.png" style="margin-top: 12px;margin-left:100px; "></li>
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
              <form action="post.php?page=index.php" method="post">
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
 
$posts=$db->my_friends_posts($userid);
 
 if($posts)
  foreach($posts as  $row):
    $postId=$row['postId'];?>
        <div id="<?php echo $postId ; ?>" class="panel panel-default post-panel">
          <div class="btn-group pull-right postbtn">
            <button type="button" class="dotbtn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="dots"></span> </button>
            <ul class="dropdown-menu pull-right" role="menu">
              <li><a href="edit_post.php?postId=<?php echo $postId;?>"  style="cursor:pointer;" class="edit_post">Edit Post</a></li>
              <li><a style="cursor:pointer;" class="delete_post" >Delete Post</a></li>
            </ul>
          </div>
          <div class="col-md-12">
            <div class="media">
              <div class="media-left"> <a href="javascript:void(0)"> <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="media-object"> </a> </div>
              <div class="media-body">
                <?php 
                $name=$db->FullName($row['userId']);
                ?>
                <h4 class="media-heading"> <?php echo $name ; ?> <br>
                  <small><i class="fa fa-clock-o"></i> <?php echo $row['dateTimeCurrent']; ?> </small> </h4>
                <p><?php echo $row['postText']; ?> </p>
                <?php  
                

                $Nlikes=$db->count_likes($postId);
                $Ncomments=$db->count_comments($postId);
                $like_color=$db->like_color($postId,$userid);
                ?>
                <ul class="nav nav-pills pull-left ">
                  <li>
                    <a class="LIKES"  style="color: #de41b0;cursor: pointer;"   title="">
                      <i style="color: <?php echo $like_color; ?>" class="like_color glyphicon glyphicon-thumbs-up"></i>
                      <span class="num-likes"><?php echo $Nlikes ?></span>
                    </a>
                  </li>
                  <li>
                    <a class="COMMENTS"  style="color: #de41b0;cursor: pointer;"  title="">
                      <i style="color: #de41b0;"  class=" glyphicon glyphicon-comment"></i>
                      <span class="num-comments"><?php echo $Ncomments; ?></span>
                    </a>
                  </li>
                  
                </ul>
              </div>
            </div>
          </div>
          <div class=" panel-body col-md-12 border-top">
            <div class=" status-upload nopaddingbtm status-upload">

              
              <form class="add-comment-form">
                  <label style="color: #de41b0;" >Comment</label>
                  <textarea name="commentText" class="form-control" placeholder="Comment here" required></textarea>
                  <br>
                  
                  <button  style="background-color:  #de41b0;border-color:#de41b0;"
                    class="commentbtn btn btn-success pull-right"> Comment</button>
                <br><br>
              </form>
              <div class="comments-area" >
                <?php 
                    $comments=$db->get_comments($postId); 
                    if($comments)
                      foreach($comments as $comment):
                        echo $db->get_comment_html($comment);
                      endforeach;
                  ?>
             </div>
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
            $notfriends=$db->get_not_friends($userid);
            foreach($notfriends as $notFriend):{
            $notfriendId=$notFriend['userId'];
            $request_status=$db->request_status($userid,$notfriendId);
            ?>
                
            <div style="margin-bottom: 10px;margin-top: 3px;margin-left: 10px;" 
            class="clearfix"> <b style="color: black;"><?php echo $db->FullName($notfriendId); ?> </b>
            <button  id="<?php echo $notfriendId; ?>"
            class="btn btn--radius-2 btn--blue addfriend" style=" margin-left: 10px;
              margin-right: 10px;
              background-color: #de41b0;
              color:white; 
              float:right;"
                       
                      name="addFriends"><?php echo $request_status; ?></button></div>
         <?php }endforeach; ?>
        

        </div>
        </div>
	
</div>
</div>
<?php

?>
<script src="main.js">


  </script>
</body>
</html>

<?php
}
else{
	header("location:login.php?loginStatus=notlogin");
}
?>