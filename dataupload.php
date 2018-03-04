<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height-device-height, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
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
                        <a href="index.php">Overview</a>
                        
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
           <?php include('welcome.php'); ?>
     <div class="page-header">
                        <h2>Data Upload</h2>
                    </div>
     <table width="600">
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

<tr>
  Load data from CSV file.  
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

<tr>
<td></td>
<td> <label class="btn btn-default btn-file">Submit<input type="submit" style="display: none;"  name="submit" /></td></label>
</tr>

</form>
</table>
  <br>
<span>You will receive an email once the data load is complete.</span>
      </div>
  </div>
  </body>
</html>

<?php


/*function processFile() {


    return 'result';
}

$dispatcher = new Amp\Thread\Dispatcher;

// call 2 functions to be executed asynchronously
$promise1 = $dispatcher->call('processFile');


$comboPromise = Amp\all([$promise1]);
list($result1) = $comboPromise->wait();*/



$info = "";
$errorDetected = false;
if ( isset($_POST["submit"]) ) {

   if ( isset($_FILES["file"])) {

            //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }
        else {
                 //Print file details
            /* echo "Upload: " . $_FILES["file"]["name"] . "<br />";
             echo "Type: " . $_FILES["file"]["type"] . "<br />";
             echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
             echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";*/

                 //if file already exists
             if (file_exists("upload/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " already exists. ";
             }
             else {
                    //Store file in directory "upload" with the name of "uploaded_file.txt"
            //$storagename = "uploaded_file.txt";
                $tmpName = $_FILES['file']['tmp_name'];
                $csvAsArray = array_map('str_getcsv', file($tmpName));
                
               
               // move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);
               // echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
               
                foreach($csvAsArray as &$row  ) {
                                   
                  if(is_numeric($row[0]) && is_string($row[1]) && is_string($row[2]) && is_string($row[3]) && is_numeric($row[4])) 
                  {
                                       
                    //Check for existing row in db
                  
                    
                        $sql = "SELECT empid FROM employees WHERE empid = '$row[0]'";
                        $result = $pdo->query($sql);


                        //$count = mysqli_num_rows($result);
                         $count = $result->rowCount();

                        // If result matched empid, table row must be 1 row

                        if($count > 0) {

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



                             $code = random_int ( 10000 , 100000 );
                             $sql = "INSERT INTO `employees`(`empid`, `name`, `role`, `address`, `salary`) VALUES ('$row[0]', '$row[1]', '$row[2]', '$row[3]', '$row[4]')";
                             $result = $pdo->query($sql);
                           
                           
                      }
                    }
                 }
                require 'PHPMailer/PHPMailerAutoload.php';

                $mail = new PHPMailer;

                $mail->isSMTP();                            // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                     // Enable SMTP authentication
                $mail->Username = 'nidgtest@gmail.com';          // SMTP username
                $mail->Password = 'hunan12%%'; // SMTP password
                $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                          // TCP port to connect to

                $mail->setFrom('nidgtest@gmail.com', 'Employee Data Management');
                $mail->addReplyTo('nidgtest@gmail.com', 'Employee Data Management');
                $mail->addAddress('nidhin.george.2018@mumail.ie');   // Add a recipient
                //$mail->addCC('cc@example.com');
                $mail->addBCC('nidgtest@gmail.com');

                $mail->isHTML(true);  // Set email format to HTML

                $bodyContent = '<h1>Data Upload</h1>';
               if(!$errorDetected) 
                $bodyContent .= '<p>Bulk loading of data from '. $_FILES["file"]["name"]  .' completed.</p>';
               else
                $bodyContent .= '<p>Errors occurred while loading data from '. $_FILES["file"]["name"]  .'. Please check the application to </p>';
               

                $mail->Subject = 'Employee Data Management - Data Upload';
                $mail->Body    = $bodyContent;

                if(!$mail->send()) {

                    error_log('Mailer Error: ' . $mail->ErrorInfo, 0);
                }   
                else {
                  $info = "You will receive an email once the Data load is complete.";
                }
                unset($pdo);
            }       
          
         
        }
     } else {
             echo "No file selected <br />";
     }
}



?>
