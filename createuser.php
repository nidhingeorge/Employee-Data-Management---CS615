<?php
	// PHP file used to create a new user

 // Include the dependent php files
   include("config.php");
   include("apppaths.php");

//Initialising te string variables
   $info= "";
	 $submitComplete = false;

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

                $count = $result->rowCount();

                // If result matched $email, table rows returned must be 1 row

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
                       $code = random_int ( 100000 , 900000 );
											
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
											
											$bodyContent .= '<a href='.constant('URLADDR').'verifyuser.php?username='.$username.'&code='.$code.'> Verify Email </a>';
                      //$bodyContent .= '<a href=http://'.$urladdr.'/verifyuser.php?username='.$username.'&code='.$code.'> Verify Email </a>';
                      //echo $urladdr.'/verifyuser.php?username='.$username.'&code='.$code;

                      $mail->Subject = 'Verify Email';
                      $mail->Body    = $bodyContent;

											//Sending the verification mail and checking for any errors
                      if(!$mail->send()) {

                          error_log('Mailer Error: ' . $mail->ErrorInfo, 0);
                      }   
                      else {
                        $info = "Please check your email for verification link.";
												$submitComplete = true;
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
      

   <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
<link rel="stylesheet" href="resources/css/style.css">

<style>

body { 
	/* Styling for the html body  */
    background: url("resources/bg.png") no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
}

.jumbotron { 
	/* Styling for the create user fields form including the icon  */
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
	/* Styling for the div containing the input fields */
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
		 
		 
//Check if the http request is POST
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
     
		 // Validate input fields
      if(empty($username) || empty($password) || empty($email)){
          $info = 'Please enter all values.';   
					
      } 		
      
		 //Check if user creation submit process as complete or not
      if($submitComplete){
				//Show the info message
			 echo '<div style = "font-size:20px; color:#ffffff; margin-top:10px; margin-left: 100px;">';
       echo $info;
       echo '</div>';
			}
						
	}
		 //Check if user creation submit process as complete or not
		 if(!$submitComplete) {
			 //Render the data entry form
				echo '<div class="jumbotron">';
				echo '<div class="container">';
				echo '<span class="glyphicon glyphicon-user"></span>';
				echo '<h2>Create User</h2>';
				echo '<div class="box">';
				echo '<form action = "" method = "post">';
				echo '<input type="text" placeholder="email (gmail or mumail id)" name = "email">';
				echo '<input type="text" placeholder="username" name = "username">';
				echo '<input type="password" placeholder="password" name = "password">';
				echo '<button class="btn btn-default full-width" type="submit"><span class="glyphicon glyphicon-ok"></span></button>';
				echo '</form>';
				echo '<div style = "font-size:11px; color:#cc0000; margin-top:10px">';
				echo $info; 
				echo '</div></div>';
				echo '</div>';
				echo '</div>';
			}
 

?>
   </body>
</html>