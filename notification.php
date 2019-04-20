<?php
?>
	<script > console.log("notification");</script>
	<?php
session_start();
require('conn.php'); 
$userId=$_SESSION['userId'];
 
if(isset($_POST['view']))
{

	if($_POST['view'] != '')
      {
		  $update_query = "UPDATE notifications SET seen=1 WHERE seen=0";
		  $db->InsertData($update_query);
	  }
$notification=$db->get_notification($userId);
echo json_encode($notification);
}
?>