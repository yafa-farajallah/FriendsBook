<?php
require('conn.php'); 
session_start();
if(isset($_SESSION['userId'])){
$userId=$_SESSION['userId'];

$name=$db->FullName($userId);

$postId=$_GET['postId'];
$query="SELECT  * FROM `posts` WHERE `postId`=$postId";

    $result=$db->SelectData($query);
    
    $post=mysqli_fetch_array($result);

    $post_writer=$post[1];
    $text=$post[2];
   

    if($post_writer==$userId){
      $text=$post[2];
      $form_submit="post.php?page=index.php&postId=$postId";
    }
     else {
     $text="you cant edit your friends post";
     $form_submit="index.php";
     }
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
          <ul  id="notification_menu" class="dropdown-menu ">
          <?php $db->get_notification($userid); ?>
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
<div class="col-md-7 col-sm-12 pull-center posttimeline ">
        <div class="panel panel-default" >
          <div class="panel-body" >
            <div class="status-upload nopaddingbtm">
              <form action="<?php echo $form_submit?>" method="post">
                <textarea style="height:100px;" name="post" class="form-control" ><?php echo $text?></textarea>
                <br>
                <ul class="nav nav-pills pull-center ">
                 
                  <li><a style="color: #de41b0;"title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Picture"><i class="glyphicon glyphicon-picture"></i></a></li>
                </ul>
                <input type="submit" name="share" value="Edit Post" style="background-color:  #de41b0;border-color:#de41b0;"type="submit" class="btn btn-success pull-right">
              </form>
            </div>
            <!-- Status Upload  --> 
          </div>
        </div>

   </body>
   </html>     
<?php }
?>
 