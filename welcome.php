<?php
//PHP file for showing username and logout button 

//Including the seesion related code
   include('session.php');

?>
<html>
   
   <head>
      <title> </title>
   </head>
   <!-- User Pane with username and Logout link-->
   <body>
     <p align="right" >
       <?php echo "<span style='color:#445082; font-weight: bold'>". $login_session . "</span>";?> &nbsp; <a href = "logout.php">Logout</a>  </p>
   </body>
   
</html>
