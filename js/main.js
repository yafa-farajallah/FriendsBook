
      function add_like(postId)
      {
          jQuery.ajax({
              type: "GET",
              url: "like.php?postid="+postId,
              success: function(data1) {
                var response = $.parseJSON(data1);
                $("#"+postId+ " .num-likes").html(response.no_likes);
                $("#"+postId+ " .like_color").css("color",response.color);
                
              }
          });
      }

      function add_comment(postId)
      {
          jQuery.ajax({
              type: "POST",
              url: "comment.php?postId="+postId,
              data: jQuery("#"+postId+" .add-comment-form").serialize(),
              success:function(data) {
                var responce = $.parseJSON(data);
                var Ncomments=responce.no_comments; 
                $("#"+postId+ " .num-comments").html(Ncomments);
                $("#"+postId+" .comments-area").prepend(responce.comment_html);
              //console.log("successed"+Ncomments+"#form"+postId); 
              }
          });
      }
      function load_unseen_notification(view='')
      {
        jQuery.ajax({
            url:"notification.php?view="+view,
            method:"GET",
            success:function(data)
            {
              var response = $.parseJSON(data);
              console.log(response);
              var notification =response[0];
              var unseen_notification =response[1];       
              $('#notification_menu').html(notification);
              if(unseen_notification >0)
              {
                $('.notification_count').html(unseen_notification);
              }
            }  
          });
      }
      function add_friends_req(friendId)
      {
          jQuery.ajax({
              type: "GET",
              url: "addfriends.php?friendid="+friendId,
              success:function(friend) {
              $("#"+friendId).html("Request Send");
              $("#"+friendId).css("background-color",'#eb8dd0');
                load_unseen_notification();
              }
          });
      }

      function accept_friend(senderId)
      {   
          jQuery.ajax({
              type: "GET",
              url: "addfriends.php?&status=accept&senderId="+senderId,
              success:function(friend) {
                $('#'+senderId).remove();
                load_unseen_notification();
              }
          });
      }

      function denay_friend(senderId)
      {
          jQuery.ajax({
              type: "GET",
              url: "addfriends.php?&status=denay&senderId="+senderId,
              success:function(friend) {
                $('#'+senderId).remove();
                load_unseen_notification();
              }
          });
      }



      function delete_post(postId)
      {
        jQuery.ajax({
              type: "GET",
              url: "delete_post.php?postId="+postId,
              
              success:function(data) {
                
                if (data ==! 2){
                  $('#'+postId).remove();}
                  else
                  alert("you dont have permission to delete this post");
                  
              }
          });

      }

      $(document).ready(function() {
        load_unseen_notification(); //this line Dynamicly change content 

          $(".LIKES").click(function() {
        
            var postId=$(this).parents(".post-panel").attr('id');
            add_like(postId); 
            });

            $(".COMMENTS").click(function() {
              //var postId = $(this).parents("ul").find('.LIKES').attr('id');
              var postId = $(this).parents(".post-panel").attr('id');
              $("#" + postId+" .comments-area").fadeIn();
              //console.log("comment added "+($(this).attr('id')));
                
          });

        $(".commentbtn").click(function() {
          var postId=$(this).parents(".post-panel").attr('id');
          //console.log("comment button clicked on post id " + postId);
          add_comment(postId); 
          //console.log("comment added");
          $("#"+postId+ " .add-comment-form textarea").val('');

          return false;
          
            });  

          

            $(".addfriend").click(function(event) {
            
          var friendId=$(this).attr('id');
          //console.log("add friend button clicked on friend id " + friendId);
            add_friends_req(friendId);
          
            return false; 
            });

            $(document).on('click','.accept',function(event) {
              event.preventDefault();
              console.log("senderID");
            var senderId=$(this).parents(".acceptFriend").attr('id');
              accept_friend(senderId);
              return false; 
              });  

              $(document).on('click','.denay',function(event) {
            
            var senderId=$(this).parents(".acceptFriend").attr('id');
              denay_friend(senderId);
              return false; 
              });  
        

          
          $("#notification").click(function(event) {
          $('.notification_count').html('');
          load_unseen_notification('yes');      
            });

          $(".delete_post").click(function(event) {
            var postId=$(this).parents(".post-panel").attr('id');
            console.log(postId);
            delete_post(postId);      
            
            });  

          setInterval(function(){ 
          load_unseen_notification();
          
            }, 4000);
      
      });

            

