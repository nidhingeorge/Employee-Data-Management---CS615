<?php
//PHP file for entering new password during Reset Password process

   include("config.php");
	
	//Including apppaths.php to access applicaton url
   include("apppaths.php");
   $info= "";
   $resetFlag = false;

	//Code to handle the first time loading when arriving from email link
   if($_SERVER["REQUEST_METHOD"] == "GET") {
      // email and code sent from URL 
     
      $email = $_GET['email']; 
      $code = $_GET['code']; 
		 //Checking for empty email and code in the url
      if(empty($email) || empty($code)){
        $info = 'Invalid Request. Please try again.';
      }
     
   }

//Code to handle the POST request containing the new password
    if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      
      $email = $_POST['email']; 
      $code = $_POST['code']; 
      $verifypassword = $_POST['verifypassword'];
      $password = $_POST['password']; 
      
      // Validate input fields
			//Check for empty password fields
      if(empty($verifypassword) || empty($password)){
          $info = 'Please enter all values in all fields.';     
      } 
			//Check for empty email and unique code
      else if(empty($email) || empty($code)){
        $info = 'Invalid Request. Please try again.';
      }
			//Check if passwords are matching
      else if(!($verifypassword === $password)){
        $info = "Passwords don't match!";
      }
      else {
        			//Query to search for user in db
        
              $sql = "SELECT email FROM userdb WHERE email = '$email' and code= '$code'";
              $result = $pdo->query($sql);
              $count = $result->rowCount();

              // If result matched $email, table row must be 1 row

              if($count == 0) {
								//No user available with the email address
                $info = "Invalid Request! ";

                // Close statement
                unset($sql);

              }else if($count == 1){
                //User account exists in db
                 $sql = "UPDATE `userdb` SET `password`='$password' WHERE email='$email'";
               
								//Updating the password
                 $result = $pdo->query($sql);   
                
								//Setting the info message
                 $info = "Password has been reset! Click here to <a href='login.php'> Login </a>.";
                 $resetFlag = true;
                // Close statement
                unset($sql);
              }
           
          
            
       //Close the connection
        unset($pdo);
     }
   }
?>
<html>
   
   <head>
      <title>Reset Password</title>
      

   <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="style.css">

<style>

body {
    background: url("resources/bg.png") no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
}

.jumbotron {
	text-align: center;
	width: 30rem;
	border-radius: 0.5rem;
	right: 250;
	top: 150;
  bottom: 0;
  
	position: absolute;
	margin: 4rem auto;
	background-color: #fff;
	padding: 2rem;
	height: 520;
  left:750;
}

.container .glyphicon-user {
	font-size: 10rem;
	margin-top: 3rem;
	color: #6d7fcc;
}

input {
	width: 100%;
	margin-bottom: 1.4rem;
	padding: 1rem;
	background-color: #ecf2f4;
	border-radius: 0.2rem;
	border: none;
}
h2 {
	margin-bottom: 3rem;
	font-weight: bold;
	color: #ababab;
}
.btn {
	border-radius: 0.2rem;
}
.btn .glyphicon {
	font-size: 3rem;
	color: #fff;
}
.full-width {
	background-color: #8eb5e2;
	width: 100%;
	-webkit-border-top-right-radius: 0;
	-webkit-border-bottom-right-radius: 0;
	-moz-border-radius-topright: 0;
	-moz-border-radius-bottomright: 0;
	border-top-right-radius: 0;
	border-bottom-right-radius: 0;
}

.box {
	position: absolute;
	bottom: 0;
	left: 0;
	top: 250; 
	margin-bottom: 3rem;
	margin-left: 3rem;
	margin-right: 3rem;
}
</style>
    

   
   </head>
   
   <body bgcolor = "#FFFFFF">
	
 <div class="sidebar-header" style="font-weight:bold; font-size:72; color:#ffffff;margin-top: 200px;margin-left: 100px;" width="250px">
    <a href='login.php'> Employee <br>Data<br> Management </a>
</div>         

<?php
		 
		 //PHP code to show the info message after user submits the new password
		 if($_SERVER["REQUEST_METHOD"] == "POST" && $resetFlag) { 
			 
			 echo '<div style = "font-size:20px; color:#ffffff; margin-top:10px; margin-left: 100px;">';
       echo $info;
       echo '</div>';
			 
		 }
		 
		 //PHP code to show the input fields on initial page load
		 else if($_SERVER["REQUEST_METHOD"] == "GET"){
        echo '<div class="jumbotron">';
        echo '<div class="container">';
        echo '<span class="glyphicon glyphicon-user"></span>';
        echo '<h2>Reset Password</h2>';
        echo '<div class="box">';
			  echo '<form action = "" method = "post">';
        echo '<input type="password" placeholder="new password" name = "password">';
	      echo '<input type="password" placeholder="verify password" name = "verifypassword">';
        echo '<input type="hidden" name = "email" value='.$email.'>';
        echo '<input type="hidden" name = "code" value='.$code.'>';
	      echo '<button class="btn btn-default full-width" type="submit"><span class="glyphicon glyphicon-ok"></span></button>';
				echo '</form>';
        echo '<div style = "font-size:11px; color:#cc0000; margin-top:10px">';
        echo $info; 
        echo '</div></div>';
        echo '</div>';
        echo '</div>';

}?>
   </body>
</html>