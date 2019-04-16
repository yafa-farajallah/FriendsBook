<!DOCTYPE html>
<html>
<?php
require('conn.php');
session_start();
if(isset($_SESSION['userId'])){
  $id=$_SESSION['userId'];
  $query ="SELECT * FROM userac where userId=$id";
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
  

?>
<head>
  <title>My Profile</title>
<link href="css/profile.css" rel="stylesheet">
<link rel="icon" href="images/caticon.png">
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
        <li><img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="media-object"></li>
        <li ><a style="color: white; padding-right: 0px;"href="profile.php"><?php echo $firstName." ".$lastName ?></a></li>
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
      <div class="col-md-12 text-center ">
        <div class="panel panel-default">
          <div class="userprofile social ">
            <div class="userpic"> <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="" class="userpicimg"> </div>
            <h3 class="username"><?php echo $firstName." ".$lastName ?></h3>
           
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
              <?php   $userid=$_SESSION['userId'];
             $qurey="SELECT COUNT(userId) FROM userac WHERE  userid  in ( SELECT USERID2 FROM FRIENDSHIP WHERE USERID=$userid) 
              or userid  in ( SELECT USERID FROM FRIENDSHIP WHERE USERID2=$userid) ";
              $friends=$db->SelectData($qurey);
 
            if($friends)
             $friendsA=mysqli_fetch_assoc($friends);
            ?>
                <h3><?php echo $friendsA['COUNT(userId)']; ?><br>
                  <small>Friends</small> </h3>
              </li>
              <li role="presentation">
                <?php   $userid=$_SESSION['userId'];
             $qurey="SELECT COUNT(postId) FROM posts WHERE userid=$userid ";
              $posts=$db->SelectData($qurey);
 
            if($posts)
             $PostsA=mysqli_fetch_assoc($posts);
            ?>
                <h3><?php echo $PostsA['COUNT(postId)']; ?><br>
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
              font-size: 20px;color: #607D8B;margin-left: 10px;">My Pictures</h4>
              <!-- when we know how to store pics in db we will select pics from db -->
              <div class="col-sm-3 col-xs-3"><img src="images/flower.jpg" class="" alt=""> </div>
              <div class="col-sm-3 col-xs-3"><img src="images/flower2.jpg" class="" alt=""> </div>
              <div class="col-sm-3 col-xs-3"><img src="images/flower3.jpg" class="" alt=""> </div>
              <div class="col-sm-3 col-xs-3"><img src="images/flower4.jpg" class="" alt=""> </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        
       
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="page-header small">My Friends</h1>
            <p class="page-subtitle small">You have recemtly connected with <?php echo $friendsA['COUNT(userId)']; ?></p>
          </div>
          <div class="col-md-12">
            <div class="memberblock">
              <?php 
              
            $userid=$_SESSION['userId'];
            $friends=$db->SelectData("SELECT firstName,lastName FROM userac WHERE  userid  in ( SELECT USERID2 FROM FRIENDSHIP WHERE USERID=$userid) 
              or userid  in ( SELECT USERID FROM FRIENDSHIP WHERE USERID2=$userid)
               ");
               foreach($friends as $Friend):?>
             <a href="" class="member"> <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="">
              <div class="memmbername"><?php echo $Friend['firstName']." ".$Friend['lastName']; ?></div>
              </a>
              <?php endforeach; ?>
                </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="col-md-8 col-sm-12 pull-left posttimeline">
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
                  <li><a class="LIKES" id="<?php echo $postId; ?>" style="color: #de41b0;cursor: pointer;"   title=""><i style="color: #de41b0;" class="glyphicon glyphicon-thumbs-up"></i> <?php echo $Nlikes['COUNT(likeId)']; ?></a></li>
                  <li><a style="color: #de41b0;"  title=""><i style="color: #de41b0;"  class=" glyphicon glyphicon-comment"></i><?php echo $Ncomments['COUNT(commentId)']; ?></a></li>
                  
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
</div>
</div>

</body>
</html>
<?php
}
else{
  header("location:login.php?loginStatus=notlogin");
}
?>