<?php
   session_start();
   //Destroying the session
   if(session_destroy()) {
      header("Location: login.php");
   }
?>