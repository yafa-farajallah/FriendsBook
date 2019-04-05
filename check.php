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
			echo "failed";
			}
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
		    $user1=mysqli_fetch_array($result);
			
			if ($user1) { // if user exists
				header("location:register.php?RegisterFailed=true");
			}
			else {
			$query = "INSERT INTO userac (username,password,firstname, lastname,teleno,email,gender,birthdate)
				VALUES ('$username','$password','$firstname','$lastname','$teleno','$email',$gender,'$birthdate')";
			$result=$db->InsertData($query);
			header('location:login.php?LogInStatus=confirm');
			}
			}
	}
}


?>