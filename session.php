<?php
//PHP file to handle user session

//Including the config file
   include('config.php');
   session_start();
   
  if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
  if(isset($_SESSION['login_user'])){
   $user_check = $_SESSION['login_user'];

  //SQL query to look up the user details
   $sql = "select username, email from userdb where username = '$user_check'";
      
    $result = $pdo->query($sql);
      $row = $result->fetch();
     
      //$count = mysqli_num_rows($result);
       $count = $result->rowCount();
   
    //Setting the username and email to php variables
    $login_session = $row['username'];
    $login_email = $row['email'];
   
  }
   
?>