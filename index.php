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
      <li ><a style="color: white;"href="index.php"><?php echo $firstName." ".$lastName ?></a></li>
        <li ><a style="color: white;" href="#">My Profile<span class="sr-only">(current)</span></a></li>
        <li ><a style="color: white;"href="index.php">Home Page</a></li>
        
        
      </ul>
    
      <ul class="nav navbar-nav navbar-right">
        <li><img src="images/whiteicon.png" style="margin-top: 12px;"></li>
        <li><a a style="color: white;"href="index.php?action=logout">log out</a></li>
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<div class="container">
<div class="row">
<div class="col-md-10 col-sm-12 pull-left posttimeline">
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
                <h4 class="media-heading"> Lucky Sans<br>
                  <small><i class="fa fa-clock-o"></i> Yesterday, 2:00 am</small> </h4>
                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio. </p>
                <ul class="nav nav-pills pull-left ">
                  <li><a style="color: #de41b0;"  href="" title=""><i style="color: #de41b0;" class="glyphicon glyphicon-thumbs-up"></i> 2015</a></li>
                  <li><a style="color: #de41b0;" href="" title=""><i style="color: #de41b0;"  class=" glyphicon glyphicon-comment"></i> 25</a></li>
                  
                </ul>
              </div>
            </div>
          </div>
          <div class=" panel-body col-md-12 border-top">
            <div class=" status-upload nopaddingbtm status-upload">
              <form>
                <label style="color: #de41b0;" >Comment</label>
                <textarea class="form-control" placeholder="Comment here"></textarea>
                <br>
                
                <button  style="background-color:  #de41b0;border-color:#de41b0;" type="submit" class="btn btn-success pull-right"> Comment</button>
              </form>
            </div>
            <!-- Status Upload  --> 
            
          </div>
        </div>


</div>


 <div class="col-md-2 col-sm-12 pull-right">
        <div class="panel panel-default">
          <div class="panel-heading">
            <p class="page-subtitle small"><b>people you may know</b></p>
          </div>
          
          <div class="clearfix">diana mujahed</div>
          <div class="clearfix">deema mujahed</div>

        </div>
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