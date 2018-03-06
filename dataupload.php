<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height-device-height, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Upload</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
   <link rel="stylesheet" href="style.css">
    <style type="text/css"> 
     
      .container-fluid{
        margin-left:0;
        width:100%;
        height:100%
      }
      .wrapper{
        height:100%;
      }
    html { height: 100%; } body { min-height: 100%; height:100vh;}
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
      <!-- Sidebar Holder -->
           <nav id="sidebar">
                <div class="sidebar-header">
                    <a href='index.php'> <h3>Employee Data Management</h3></a>
                </div>

                <ul class="list-unstyled components">
                    <li>
                        <a href="index.php">Dashboard</a>
                        
                    </li>    
                   <li>
                        <a href="create.php">Add Employee</a>
                        
                    </li>
                    <li  class="active">
                        <a href="dataupload.php">Data Upload</a>
                    </li>
                  
                </ul>

                
            </nav>
       
   
   <div class="container-fluid">
           <?php 
     //Including the config and user info
     include('welcome.php'); ?>
     <div class="page-header">
                        <h2>Data Upload</h2>
                    </div>
     <table width="600">
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

<tr>
  Load data from CSV file. <br><br>Download the Template here : <a href="/resources/dataloadtemplate.csv" style="color:#425a75" download> datauploadtemplate.csv</a><br><br>
  </tr>
 <tr height = 20px></tr>
<tr>
<td width="20%">Select file</td>
<td width="80%">
  <label class="btn btn-default btn-file">
    <input type="file"  name="file" id="file" accept=".csv" >
    </td>
</label>
</tr>
       <tr><td><br></td></tr>
<tr>
<td></td>
<td> <label class="btn btn-primary">Submit<input type="submit" style="display: none;"  name="submit" /></td></label>
</tr>

</form>
</table>
  <br>


<?php

$errorDetected = false;
//Checking whether the page load is part of submit
if ( isset($_POST["submit"]) ) {

   if ( isset($_FILES["file"])) {

        //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            $info = "Check if file is selected properly!" . "<br />";

        }
        else {
                 //Reading and parsing the csv file
                $tmpName = $_FILES['file']['tmp_name'];
                $csvAsArray = array_map('str_getcsv', file($tmpName));
         
                //Validating header values in the uploaded file
                if(count($csvAsArray[0])==5  && !empty($csvAsArray[0][0]) && $csvAsArray[0][0]==='Emp Id' 
                   && !empty($csvAsArray[0][1]) && $csvAsArray[0][1]==='Name' && !empty($csvAsArray[0][2]) && $csvAsArray[0][2]==='Role'
                  && !empty($csvAsArray[0][3]) && $csvAsArray[0][3]==='Address' && !empty($csvAsArray[0][4]) && $csvAsArray[0][4]==='Salary')  {
                  
                  //Iterating through each row
                 foreach($csvAsArray as &$row) {
                  
                   //Checking whether the datatype is correct
                  if(is_numeric($row[0]) && is_string($row[1]) && is_string($row[2]) && is_string($row[3]) && is_numeric($row[4])) 
                  {
                                       
                        //Check for existing row in db                 
                    
                        $sql = "SELECT empid FROM employees WHERE empid = '$row[0]'";
                        $result = $pdo->query($sql);


                        //$count = mysqli_num_rows($result);
                         $count = $result->rowCount();

                        // If result matched empid, count must be 1

                        if($count == 1) {
                            //Updating the existing record with new data
                            $sql = "UPDATE employees SET name=:name, address=:address, salary=:salary, role=:role WHERE empid=:empid";
 
                            if($stmt = $pdo->prepare($sql)){
                                // Bind variables to the prepared statement as parameters
                                $stmt->bindParam(':empid', $param_empid);  
                                $stmt->bindParam(':name', $param_name);
                                $stmt->bindParam(':address', $param_address);
                                $stmt->bindParam(':role', $param_role);
                                $stmt->bindParam(':salary', $param_salary);                              
                               

                                // Set parameters
                                $param_name = $row[1];
                                $param_address = $row[2];
                                $param_salary = $row[4];
                                $param_empid = $row[0];
                                $param_role = $row[3];

                                // Attempt to execute the prepared statement
                                if($stmt->execute()){
                                    // Records updated successfully. Redirect to landing page
                                    //header("location: index.php");
                                    //exit();
                                } else{
                                    //$info = "Error occurred during data load. Please try again later.";
                                    $errorDetected = true;
                                }
                            }

                            // Close statement
                            unset($stmt);

                      
                      //If yes, update the record
                      
                      }

                      else {
                            //Else, create a new record                             
                             $sql = "INSERT INTO `employees`(`empid`, `name`, `role`, `address`, `salary`) VALUES ('$row[0]', '$row[1]', '$row[2]', '$row[3]', '$row[4]')";
                             $result = $pdo->query($sql);                    
                           
                      }
                    }
                 }
                  
                  //Adding the PHPMailer framework for sending emails
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
                $mail->addAddress($login_email);   // Add a recipient
                //$mail->addCC('cc@example.com');
                $mail->addBCC('nidgtest@gmail.com');

                $mail->isHTML(true);  // Set email format to HTML

                  //Creating the html email body content
                $bodyContent = '<h1>Data Upload</h1>';
               if(!$errorDetected) 
                  $bodyContent .= '<p>Bulk loading of data from '. $_FILES["file"]["name"]  .' completed.</p>';
               else
                  $bodyContent .= '<p>Errors occurred while loading data from '. $_FILES["file"]["name"]  .'. Please check the application to verify the data.</p>';
               
                //Email subject
                $mail->Subject = 'Employee Data Management - Data Upload';
                $mail->Body    = $bodyContent;

                  //Sending the email
                if(!$mail->send()) {

                    error_log('Mailer Error: ' . $mail->ErrorInfo, 0);
                }   
                else {
                  //Updating the info message
                  $info = "You will receive an email once the Data load is complete.";
                }
                unset($pdo);
                   
        }
          else {
            //Updating the info to indicate that invalid file has been uploaded
            $info = "Invalid File selected!";
          }
         
        }
     } else {
             $info =  "No file selected <br />";
     }
}



?>

  <?php echo $info ?>
      </div>
  </div>
  </body>
</html>