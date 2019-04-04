<?php


require('conn.php');
$db = new DB();
if (isset($_GET['action']))
{
	$action=$_GET['action'];
	DoAction($action);
}
function DoAction($action)
{
   switch( $action )
   {
	  case 'login':
	  session_start();
	  $username = $_POST['username'];
	  $password = $_POST['password'];
	  
	  $query ="SELECT userid FROM userac where username='$username' and password='$password'";
	  $result =mysqli_query($conn,$query);
	  $user=mysqli_fetch_array($result);
	  $id=$user[0];
	  if (!$user)
	  {
		  die(header("location:login.php?loginFailed=true"));
	  }
	  
	  else{
	  $_SESSION['userId'] = $id;
		  header("location:index.php");
	  }

      case 'register':
	  session_start();
	  require('conn.php');
	  
	  if (isset($_POST['username'])) {
		$username=mysqli_real_escape_string($conn,$_POST['username']);
		$password=mysqli_real_escape_string($conn,$_POST['password']);
		$firstname=mysqli_real_escape_string($conn,$_POST['firstname']);
		$lastname=mysqli_real_escape_string($conn,$_POST['lastname']);
		$teleno=mysqli_real_escape_string($conn,$_POST['teleno']);
		$email=mysqli_real_escape_string($conn,$_POST['email']);
		$gender=$_POST['gender'];
		$birthdate=mysqli_real_escape_string($conn,$_POST['birthdate']);
		
		$user_check_query = "SELECT userid FROM userac WHERE username='$username'";
		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);
		
		if ($user) { // if user exists
			header("location:register.php?RegisterFailed=true");
	  
		}
		else {
		  $query = "INSERT INTO userac (username,password,firstname, lastname,teleno,email,gender,birthdate)
			VALUES ('$username','$password','$firstname','$lastname','$teleno','$email',$gender,'$birthdate')";
		  mysqli_query($conn, $query);
		  $_SESSION['username'] = $username;
		  header('location:index.php');
		}
		}
   }
}


?>