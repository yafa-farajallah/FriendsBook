
    <?php
session_start();
require('conn.php'); 
$connection=$db->conn;


$query = "SELECT * FROM `massages` ORDER BY id ASC ";
$result=$db->SelectData($query); 
foreach($result as $row) {
    $sender=$row["sender"];
    $reciever=$row["reciever"];
    $text=$row["text"];
    $time=date('G:i', strtotime($row["date"])); //outputs date as # #Hour#:#Minute#
    
    if ($sender=="yafa farajallah")
    echo "<div class='outgoing_msg'>
              <div class='sent_msg'>
                <p>$text</p>
                <span class='time_date'>$time</span> </div>
            </div>";
    else 
    if($reciever=="yafa farajallh") 
    echo "<div class='incoming_msg'>
              <div class='incoming_msg_img'> 
              <img src='https://ptetutorials.com/images/user-profile.png' alt='sunil'> </div>
              <div class='received_msg'>
                <div class='received_withd_msg'>
                  <p>$text</p>
                  <span class='time_date'> $time</span></div>
              </div>
            </div>  ";     
}




 ?>