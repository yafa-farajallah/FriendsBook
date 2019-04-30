<!DOCTYPE html>
<html>
<?php
require('conn.php');
session_start();
if(isset($_GET['friendId'])and isset($_SESSION['userId'])){
  $userid=$_GET['friendId'];
  $ownerid=$_SESSION['userId'];
  if($userid==$ownerid)
  header("location:profile.php");
  $query ="SELECT * FROM userac where userId=$userid";
  $result=$db->SelectData($query);
  $user=mysqli_fetch_array($result);
  $username=$user[1];
  $firstName=$user[3];
  $lastName=$user[4];
  $teleNo=$user[5];
  $email=$user[6];
  if($user[7]==1)
    $gender="Male";
  else
    $gender="Female";
  $birthdate=$user[9];
  
$userimage=$db->GetImage($userid);
$ownerimage=$db->GetImage($ownerid);
?>
<head>
  <title><?php echo $db->FullName($userid);?>  Profile</title>
<link href="css/profile.css" rel="stylesheet">
<link rel="icon" href="images/caticon.png">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/index.css" rel="stylesheet" media="all">
</head>
<body>
  <nav class=" navbar navbar-default ">
  <div  class="container-fluid ">
    

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div  class="collapse navbar-collapse navbar-fixed-top pink" id="bs-example-navbar-collapse-1" >
      <ul class="nav navbar-nav ">
        <li><img style="height: 50px;width: 50px;"  src="<?php echo $ownerimage;?>" onerror="this.src='uploads/user-icon.png';" class="media-object"></li>
        <li ><a style="color: white; padding-right: 0px;"href="profile.php"><?php echo $db->FullName($ownerid); ?></a></li>
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
      <div class="col-md-12 text-center ">
        <div class="panel panel-default">
          <div class="userprofile social ">
            <div class="userpic"> <img  style="height: 100%;width: 100%;"src="<?php echo $userimage?>" onerror="this.src='uploads/user-icon.png';" class="userpicimg"> </div>
            <h3 class="username"><?php echo $db->FullName($userid) ?></h3>
           
            <p><?php echo $username ?></p>
            <div class="socials tex-center"> <a href="" class="btn btn-circle btn-primary ">
            <i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger ">
            <i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info ">
            <i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a>
            </div>
          </div>
          <div class="col-md-12 border-top border-bottom">
            <ul class="nav nav-pills pull-left countlist" role="tablist">
              <li role="presentation">
              
                <h3><?php echo $db->count_friends($userid); ?><br>
                  <small>Friends</small> </h3>
              </li>
              <li role="presentation">
                <h3><?php echo $db->count_posts($userid); ?><br>
                  <small>Posts</small> </h3>
              </li>
              
            </ul>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <!-- /.col-md-12 -->
      <div class="col-md-4 col-sm-12 pull-right">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="page-header small">Personal Details</h1>
            <p class="page-subtitle small"><?php echo $teleNo ; ?></p>
            <p class="page-subtitle small"><?php echo $email ; ?></p>
            <p class="page-subtitle small"><?php echo $gender ; ?></p>
            <p class="page-subtitle small"><?php echo "Born in ".$birthdate ; ?></p>
          </div>
          <div class="col-md-12 photolist ">
            <div class="row">
              <h4 class="page-header small " style="position: relative;line-height: 22px; font-weight: 400;
              font-size: 20px;color: #607D8B;margin-left: 10px;"><?php echo $db->FullName($userid);?> Pictures</h4>
              <!-- when we know how to store pics in db we will select pics from db -->
             <?php $myimages=$db->MyImages($userid); 
             if($myimages){
             foreach ($myimages as $image):
             ?>
              <div class="col-sm-3 col-xs-3 "><img src="<?php echo $image['imageUrl'] ?>" > </div>

             <?php  endforeach;} ?>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        
       
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="page-header small"><?php echo $db->FullName($userid);?> Friends</h1>
            <p class="page-subtitle small"><?php echo $db->FullName($userid);?> have recently connected with <?php echo $db->count_friends($userid); ?></p>
          </div>
          <div class="col-md-12">
            <div class="memberblock">
              <?php 
              
              $friends=$db->my_friends($userid);
              if($friends):
              foreach($friends as $Friend):
                $friendId=$Friend['userId'];
             $friendimage=$db->GetImage($friendId);?>

             <a href="friends_profile.php?friendId=<?php echo $friendId;?>" class="member"> <img height="65px"src="<?php echo $friendimage ?>"  onerror="this.src='uploads/user-icon.png';">
              <div class="memmbername"><?php echo $db->FullName($friendId); ?></div>
              </a>
              <?php endforeach; ?>
             <?php endif?>
                </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="col-md-8 col-sm-12 pull-left posttimeline">

<?php 
$posts=$db->my_posts($userid);
 
 if($posts)
  foreach($posts as  $row):
    $postId=$row['postId'];
    $userimage=$db->GetImage($row['userId']);
    $postimage=$db->GetPostImage($postId);?>
        <div id="<?php echo $postId ; ?>" class="panel panel-default post-panel">
          <div class="col-md-12">
            <div class="media">
              <div class="media-left"> <a href="javascript:void(0)"> <img  style="height: 50px;width: 50px;" onerror="this.src='uploads/user-icon.png';" src="<?php echo $userimage?>" onerror="this.src='uploads/user-icon.png';" class="media-object"> </a> </div>
              <div class="media-body">
                <?php 
                $name=$db->FullName($row['userId']);
                ?>
                <h4 class="media-heading"> <?php echo $name ; ?> <br>
                  <small><i class="fa fa-clock-o"></i> <?php echo $row['dateTimeCurrent']; ?> </small> </h4>
                <p><?php echo $row['postText']; ?> </p>
                <div><img src="<?php echo $postimage?>"    style="
                  padding: 5px;
                  width: 50% !important ;margin-left: auto;
                   margin-right: auto; display: block;" ></div>
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
</div>
</div>

  <script src="js/main.js">

  </script>
</body>
</html>
<?php
}
else{
  header("location:login.php?loginStatus=notlogin");
}
?>