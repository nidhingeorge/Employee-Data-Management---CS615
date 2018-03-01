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
                    <h3>Employee Data Management</h3>
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
     
      </div>
  </div>
  </body>
</html>

<?php

if ( isset($_POST["submit"]) ) {

   if ( isset($_FILES["file"])) {

            //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }
        else {
                 //Print file details
             echo "Upload: " . $_FILES["file"]["name"] . "<br />";
             echo "Type: " . $_FILES["file"]["type"] . "<br />";
             echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
             echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

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
                  
                  
                  if(is_numeric($row[0]) && is_string($row[1]) && is_string($row[2]) && is_numeric($row[3])) {
                    echo $row[0];
                    echo $row[1];
                    echo $row[2];   
                    echo $row[3];   
                    
                    
                  }
           
                 }
               
               
            }
          
          
         
        }
     } else {
             echo "No file selected <br />";
     }
}






?>
