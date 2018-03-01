<?php
   include('config.php');
   session_start();
   
  if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
  if(isset($_SESSION['login_user'])){
   $user_check = $_SESSION['login_user'];
   
  /* $ses_sql = mysqli_query($pdo,"select username from userdb where username = '$user_check'");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);*/

   $sql = "select username from userdb where username = '$user_check'";
      /*$result = mysqli_query($pdo,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];*/
      
    $result = $pdo->query($sql);
      $row = $result->fetch();
     
      //$count = mysqli_num_rows($result);
       $count = $result->rowCount();
   
    $login_session = $row['username'];
   
  }
   
?>