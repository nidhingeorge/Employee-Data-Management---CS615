<?php
   include("config.php");
   session_start();
   $error= "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
     
		
      $myusername = $_POST['username'];
      $mypassword = $_POST['password']; 
      
		  if(is_string($myusername) && is_string($mypassword)) {
				$sql = "SELECT id FROM userdb WHERE username = '$myusername' and password = '$mypassword' and active='1'";
				/*$result = mysqli_query($pdo,$sql);
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				$active = $row['active'];*/

			 $result = $pdo->query($sql);


				//$count = mysqli_num_rows($result);
				 $count = $result->rowCount();

				// If result matched $myusername and $mypassword, table row must be 1 row

				if($count == 1) {
					 $_SESSION['myusername']="myusername";
					 //session_register("myusername");
					 $_SESSION['login_user'] = $myusername;

					 header("location: index.php");
				}else {
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
      

   <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		 <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>



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
		Employee <br>Data<br> Management
</div>

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
			
			
		<a href="createuser.php" class="btn btn-default full-width" style="background-color: #71c5a5; font-weight:bold;" >Create New User</a>
		<a href="resetpassword.php" class="btn btn-default full-width" style="background-color: #a28b64; font-weight:bold;" >Reset Password</a>
			<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
    </div>
  </div>
</div>
   </body>
</html>