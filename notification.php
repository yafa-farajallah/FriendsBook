<?php
	session_start();
	require('conn.php'); 
	$userId=$_SESSION['userId'];

	if(isset($_GET['view']))
	{
		
		if($_GET['view'] == 'yes')
		{
			$update_query = "UPDATE notifications SET seen=1 WHERE seen=0 and userReqIdFrind=$userId";
			$done=$db->InsertData($update_query);
		}
		
	$notification=$db->get_notification($userId);
	echo json_encode($notification);
	#echo json_encode(['test'=>'test value']);
	}
?>