
<?php
	//PHP file for login page
   include("config.php");
   session_start();
   $error= "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // Getting the username and password sent from form 
     
		
      $myusername = $_POST['username'];
      $mypassword = $_POST['password']; 
      
		 //Checking whether the entered values are string
		  if(is_string($myusername) && is_string($mypassword)) {
				//Creating the sql query - criteria checks whether user is activated ot not
				$sql = "SELECT id FROM userdb WHERE username = '$myusername' and password = '$mypassword' and active='1'";

			 $result = $pdo->query($sql);

				 $count = $result->rowCount();

				// If result matched $myusername and $mypassword and active=1, count must be 1

				if($count == 1) {
					//Setting the session variables
					 $_SESSION['myusername']="myusername";
					 //session_register("myusername");
					 $_SESSION['login_user'] = $myusername;

					 header("location: index.php");
				}else {
					//Error message
					 $error = "Your Username or Password is invalid!";
				}
				
				// Close statement
    		unset($sql);
				//Close the connection
				unset($pdo);
		 }
   }
?>
<html>
   
   <head>
      <title>Employee Data Management  - Login</title>
      

   <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>



<link rel="stylesheet" href="resources/css/style.css">
<style>

body {
	/*  Background image  */
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
	background-color: #425a75;
	width: 100%;
	-webkit-border-top-right-radius: 0;
	-webkit-border-bottom-right-radius: 0;
	-moz-border-radius-topright: 0;
	-moz-border-radius-bottomright: 0;
	border-top-right-radius: 0;
	border-bottom-right-radius: 0;
}
	
.full-width:hover {
	/* CSS to style the button on mouse hover */
	background-color: #7ca5d4;
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
	
 <!-- Application Name -->     
 <div class="sidebar-header" style="font-weight:bold; font-size:72; color:#ffffff;margin-top: 200px;margin-left: 100px;" width="250px">
		Employee <br>Data<br> Management
</div>
<!-- Login form -->
<div class="jumbotron">
  <div class="container">
    <span class="glyphicon glyphicon-user"></span>
    <h2>Login</h2>
    <div class="box">
			<form action = "" method = "post">
        <input type="text" placeholder="username" name = "username">
	    <input type="password" placeholder="password" name = "password">
	    <button class="btn btn-default full-width" type="submit"><span class="glyphicon glyphicon-ok"></span></button>
				</form>
			
	<!-- Buttons with custom styling -->		
		<a href="createuser.php" class="btn btn-default full-width" style="background-color: #71c5a5; color:#fff;" >Create New User</a>
		<a href="resetpassword.php" class="btn btn-default full-width" style="background-color: #a28b64; color:#fff;" >Reset Password</a>
			<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
    </div>
  </div>
</div>
   </body>
</html>