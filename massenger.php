<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<html>
<head>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
<link href="css/massenger.css" rel="stylesheet" media="all">
</head>
<body>
    <?php 

    session_start();
    require('conn.php');

$userid=$_SESSION['userId'];
  $name=$db->FullName($userid);
  $userimage=$db->GetImage($userid);
?>
  
  <nav class=" navbar navbar-default ">
  <div  class="container-fluid ">
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div  class="collapse navbar-collapse navbar-fixed-top pink " id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><img src="<?php echo $userimage?>" onerror="this.src='uploads/user-icon.png';" class="media-object"></li>
        <li ><a style="color: white; padding-right: 0px;"href="profile.php"><?php echo $name ?></a></li>
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
<h3 class=" text-center">Messaging</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Recent</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <input id="user_name" type="text" class="search-bar"  placeholder="Search" >
                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span>
              </div>
            </div>
          </div>
          <div class="inbox_chat">
            <div class="chat_list active_chat">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>adel amro <span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>
            <?php
            $notfriends=$db->get_not_friends($userid);
            foreach($notfriends as $notFriend):{
            $notfriendId=$notFriend['userId'];
            $name=$db->FullName($notfriendId);
  
            ?>
            <div class="chat_list">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5><?php echo $name ;?><span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>
            <?php }endforeach;?>
            
          </div>
        </div>
        <div class="mesgs">
          <div class="msg_history">
            <div class="incoming_msg">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>Test which is a new approach to have all
                    solutions</p>
                  <span class="time_date"> 11:01 AM    |    June 9</span></div>
              </div>
            </div>
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p>Test which is a new approach to have all
                  solutions</p>
                <span class="time_date"> 11:01 AM    |    June 9</span> </div>
            </div>
           
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" placeholder="Type a message" />
              <button id="send" class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>
      
      
      
    </div></div>
    <script type="text/javascript">

        function sendMessage() 
        {
            var RecieveUserName = $("#user_name").val();
            var text = $(".write_msg").val();

            /*jQuery.ajax({
                type: "GET",
                url: "write.php",
                success: function(data) {
               
                 }
            });*/$
            $.get("./write_massege.php?reciever="+RecieveUserName+"&text="+text);
          
            
            $("#user_name").val("");
            $(".write_msg").val("");
            retrieveMessages();
        }

        function retrieveMessages() {
        $.get("./read_masseges.php", function(data) {
            $(".msg_history").html(data); //Paste content into chat output
        });
    }
        
        $(document).ready(function() {
          retrieveMessages();
          
            $("#send").click(function() {
               sendMessage();
           });
       
           setInterval(function() {
               retrieveMessages();
           }, 250);
        
           
         
        });
        
        
          </script>

    
   
    </body>
    </html>