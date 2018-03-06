<?php
	// PHP file used to create a new user

 // Include the dependent php files
   include("config.php");
   include("apppaths.php");
   $info= "";

	//Check if the http request is POST
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
     
		
      $username = $_POST['username'];
      $password = $_POST['password']; 
      $email = $_POST['email']; 

		 //Array to hold domain names of allowed email addresses
      $allowed = array('mumail.ie', 'gmail.com');

      // Validate input fields
      if(empty($username) || empty($password) || empty($email)){
          $info = 'Please enter all values.';     
      } 
      else{
				//All values are available

				//Checking for valid email address string
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        	// Valid email address

          $explodedEmail = explode('@', $email);
          $domain = array_pop($explodedEmail);

          //Checking for valid email address with proper domain address
          if (in_array($domain, $allowed))
          {

                 // Domain is valid
								// 
                $sql = "SELECT email FROM userdb WHERE email = '$email'";
                $result = $pdo->query($sql);


                //$count = mysqli_num_rows($result);
                 $count = $result->rowCount();

                // If result matched $email, table row must be 1 row

                if($count>0) {

                  $info = "Entered email address is already registered. Please try to login or reset password.";

                  // Close statement
                  unset($stmt);

                }else {

                    $sql = "SELECT username FROM userdb WHERE username = '$username'";
                    $result = $pdo->query($sql);

                    $count = $result->rowCount();

                    // If results matched $username, count must be 1

                    if($count > 0) {

                      $info = "Entered username is already registered!";

                      // Close statement
                      unset($sql);

                    }
                    else {
											//Generating random code to store in database which will then be used while sending the verification link to the user
                       $code = random_int ( 10000 , 100000 );
											
											//Inserting the new record to the users database
                       $sql = "INSERT INTO `userdb`(`username`, `password`, `active`, `email`, `code`) VALUES ('$username','$password','0','$email','$code')";
                       $result = $pdo->query($sql);

											//Loading the PHPMailer framework for sending emails
                      require 'PHPMailer/PHPMailerAutoload.php';

                      $mail = new PHPMailer;

                      $mail->isSMTP();                            // Set mailer to use SMTP
                      $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
                      $mail->SMTPAuth = true;                     // Enable SMTP authentication
                      $mail->Username = 'nidgtest@gmail.com';          // SMTP username
                      $mail->Password = 'qmayvhyqykbgdlic'; // SMTP password
                      $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
                      $mail->Port = 587;                          // TCP port to connect to

                      $mail->setFrom('nidgtest@gmail.com', 'Employee Data Management');
                      $mail->addReplyTo('nidgtest@gmail.com', 'Employee Data Management');
                      $mail->addAddress($email);   // Add a recipient
                      $mail->addBCC('nidgtest@gmail.com');

                      $mail->isHTML(true);  // Set email format to HTML

											//Creating the html email body content.
                      $bodyContent = '<h1>Account Creation</h1>';
                      $bodyContent .= '<p>Click on the below link to activate your account: </p>';
                      $bodyContent .= '<a href=http://'.$urladdr.'/verifyuser.php?username='.$username.'&code='.$code.'> Verify Email </a>';
                      //echo $urladdr.'/verifyuser.php?username='.$username.'&code='.$code;

                      $mail->Subject = 'Verify Email';
                      $mail->Body    = $bodyContent;

											//Sending the verification mail and checking for any errors
                      if(!$mail->send()) {

                          error_log('Mailer Error: ' . $mail->ErrorInfo, 0);
                      }   
                      else {
                        $info = "Please check your email for verification link.";
                      }
                  }
                  // Close statement
                  unset($sql);
                }
             }
            else {
							//Email address is having an invalid domain
              $info = "Email address is having an invalid domain!";
            }
        }
        else {
					//THe entered email address does not conform to email address pattern
          $info = "Invalid email address!";
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


<div class="jumbotron">
  <div class="container">
    <span class="glyphicon glyphicon-user"></span>
    <h2>Create User</h2>
    <div class="box">
			<form action = "" method = "post">
        <input type="text" placeholder="email (gmail or mumail id)" name = "email">
        <input type="text" placeholder="username" name = "username">
	    <input type="password" placeholder="password" name = "password">
	    <button class="btn btn-default full-width" type="submit"><span class="glyphicon glyphicon-ok"></span></button>
				</form>
      <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $info; ?></div>
    </div>
  </div>
</div>
   </body>
</html>