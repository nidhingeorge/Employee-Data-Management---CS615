<?php
   session_start();
   //Destroying the session to logout
   if(session_destroy()) {
      header("Location: login.php");
   }
?>