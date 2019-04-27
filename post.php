<?php
session_start();
require('conn.php');
 $page=$_GET['page'];

			
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			    if($check !== false) {
			        echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } else {
			        echo "File is not an image.";
			        $uploadOk = 0;
			    }
			}
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
			    echo "Sorry, your file is too large.";
			    $uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			 echo "Sorry, your file was not uploaded.";
			 //if everything is ok, try to upload file

						} else {
			    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

			    } else {
			        echo "Sorry, there was an error uploading your file.";
			    }
			}
		
		$connection=$db->conn;
		$post=$connection->real_escape_string($_POST['post']);
		$userId=$_SESSION['userId'];
		if(isset($_GET['postId']))
		{
		  $postId=$_GET['postId'];
		  $query = "UPDATE posts SET postText='$post' WHERE  postId=$postId";
		}
		else
		{
			if($uploadOk == 1)
		  $query = "INSERT INTO posts (userid,postText,dateTimeCurrent,imageUrl)VALUES ('$userId','$post',curTime(),
			  $target_file)";

		else 
			$query = "INSERT INTO posts (userid,postText,dateTimeCurrent)VALUES ('$userId','$post',curTime())";
		}
		    if ($db->InsertData($query))
		      header("location:".$page);
		  

 ?>