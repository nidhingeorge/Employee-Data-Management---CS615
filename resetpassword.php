<?php
//PHP file to handle the Reset Password request

//Including the config file
   include("config.php");
//Including the apppaths.php file to fetch application url
   include("apppaths.php");

   $info= "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // email sent from form 
		
      $email = $_POST['email'];
		 
		 //Array to hold allowed email domains
      $allowed = array('mumail.ie', 'gmail.com');

      // Validate input fields
      if(empty($email)){
          $info = 'Please enter the email address!';     
      } 
      else{

				//email field is not empty
				
				//Checking for valid email id string
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Valid email address

          $explodedEmail = explode('@', $email);
          $domain = array_pop($explodedEmail);

          //If valid email address with proper domain address
          if (in_array($domain, $allowed))
          {

                 // Domain is valid

                $sql = "SELECT email FROM userdb WHERE email = '$email' and active='1'";

                $result = $pdo->query($sql);

                 $count = $result->rowCount();

                // If result matched $email, count must be 1.

                if($count == 1) 
								{
                   	//Generating random code to include in the reset password link and also insert in the db
                       $code = random_int ( 100000 , 900000 );
                       $sql = "UPDATE `userdb` SET code='$code', resetpwd='1' WHERE email='$email'";
                       $result = $pdo->query($sql);

										//Adding PHPMailer framework fr sending emails
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
                      //$mail->addCC('cc@example.com');
                      $mail->addBCC('nidgtest@gmail.com');

                      $mail->isHTML(true);  // Set email format to HTML

									//Constructing the html email body content
                      $bodyContent = '<h1>Reset Password</h1>';
                      $bodyContent .= '<p>Click on the below link to reset our password: </p>';
                      $bodyContent .= '<a href='.constant('URLADDR').'newpassword.php?email='.$email.'&code='.$code.'> Reset Password </a>';
                      //echo $urladdr.'/verifyuser.php?username='.$username.'&code='.$code;

                      $mail->Subject = 'Employe Data Management - Reset Password';
                      $mail->Body    = $bodyContent;

									//Sending the email
                      if(!$mail->send()) {

                          error_log('Mailer Error: ' . $mail->ErrorInfo, 0);
                      }   
                      /*else {
                        $info = "Please check your email for verification link.";
                      }*/
                  
                  // Close statement
                  unset($sql);
                }
             }
            else {
              $info = "Email address is having an invalid domain!";
            }
        }
        else {
          $info = "Invalid email address!";
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
<link rel="stylesheet" href="resources/css/style.css">

<style>

body {
	/* Background image */
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
	<!-- Application Name  -->
 <div class="sidebar-header" style="font-weight:bold; font-size:72; color:#ffffff;margin-top: 200px;margin-left: 100px;" width="250px">
    <a href='login.php'> Employee <br>Data<br> Management </a>
</div>         

<?php
		 
		 //PHP code to handle the page content after user submits the email
		 if($_SERVER["REQUEST_METHOD"] == "POST") { 
			 
			 echo '<div style = "font-size:20px; color:#ffffff; margin-top:10px; margin-left: 100px;">If the email is associated with a user account, you will receive a Reset Password link.</div>';
			 
		 }
		 
		 //PHP code to handle the page content when Reset Password page is loaded initially - Contains input field for email
		 else {
			echo '<div class="jumbotron">';
  		echo '<div class="container">';
    	echo '<span class="glyphicon glyphicon-user"></span>';
    	echo '<h2>Reset Password</h2>';
   	 	echo '<div class="box">';
			echo '<form action = "" method = "post">';
      echo '  <input type="text" placeholder="email (gmail or mumail id)" name = "email">';
	    echo '<button class="btn btn-default full-width" type="submit"><span class="glyphicon glyphicon-ok"></span></button>';
			echo '	</form>';
      echo '<div style = "font-size:11px; color:#cc0000; margin-top:10px">';
      echo $info; 
      echo '</div>';
    echo '</div>';
  echo '</div>';
echo '</div>';
}?>
   </body>
</html>