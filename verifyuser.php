<?php
   include("config.php");
   include("apppaths.php");
   $info= "";
   if($_SERVER["REQUEST_METHOD"] == "GET") {
      // username and password sent from form 
     
		
      $username = $_GET['username'];
      $code = $_GET['code']; 

      
      // Validate input fields
    if(empty($username) ||  empty($code)){
        $info = 'Invalid Request! ';     
    } 
     else{           
               // Dmain is valid
        
              $sql = "SELECT email FROM userdb WHERE username = '$username' and code= '$code' and active='0'";
              /*$result = mysqli_query($pdo,$sql);
              $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
              $active = $row['active'];*/

              $result = $pdo->query($sql);


              //$count = mysqli_num_rows($result);
               $count = $result->rowCount();

              // If result matched $email, table row must be 1 row

              if($count == 0) {

                $info = "Invalid Request! ";

                // Close statement
                unset($sql);

              }else {
                
                 $sql = "UPDATE `userdb` SET `active`='1' WHERE username='$username'";
               
                 $result = $pdo->query($sql);   
                
                 $info = "User account activated! Click here to <a href='login.php'> Login </a>.";
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
      <title>Create User</title>
      

   <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="style.css">

<style>

body {
    background: url("bg.png") no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
}

.jumbotron {
	text-align: center;
	width: 30rem;
	border-radius: 0.5rem;
	right: 0;
	top: 150;
  bottom: 0;
  left: 550;
	position: absolute;
	margin: 4rem auto;
	background-color: #fff;
	padding: 2rem;
	height: 550;
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
	
  <div class="sidebar-header" style="font-size:72; color:#ffffff;margin-top: 200px;margin-left: 100px;" width="250px">
    <a href='login.php'> Employee <br>Data<br> Management </a>
</div>     

<div style = "font-size:20px; color:#ffffff; margin-top:10px; margin-left: 100px;"><?php echo $info; ?></div>

   </body>
</html>