<!DOCTYPE html>
<html>

<head>
    <title>login to FriendsWorld</title>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="icon" href="images/caticon.png">
    <script src="login.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>

    <div class="wrapper wrapper1 fadeInDown">
        <div id="formContent">

            <form action="index.php?action=login" method="post">

                <div class="login100-form-title" style=" border-radius:10px 10px 0 0 ; background-image: url(images/friends.jpg);">
                    <h1 class="login100-form-title-1">FriendsWorld</h1>

                </div>

                <input type="text" id="login" class="fadeIn second" name="username" placeholder="username" required>
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="password" required>
                <input type="submit" class="fadeIn fourth" value="LogIn">

                <?php if(isset($_GET["LogInStatus"])){
                        switch($_GET["LogInStatus"])
                        { case 'confirm':
                       echo '<h5 class="myclass">Please Confirm Your LogIn With your new account !</h5>';
                       break;
                       case 'failed':
                            echo '<h5 class="myclass">No existing user or Invalid Username or Password</h5>';
                       break;
                       
                       case 'notlogin':
                       echo '<h5 class="myclass">Please LogIn With your account !</h5>';
                       break; 
                       
                   }
               }
                      ?>

            </form>
            <div id="formFooter">
                <p class="message">Not registered? <a class="underlineHover" href="register.php">Create an account</a></p>

            </div>
            <ul class="colorlib-bubbles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
  </div>

</body>

</html>