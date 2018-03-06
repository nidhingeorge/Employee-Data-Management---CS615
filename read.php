
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
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
    <style type="text/css">
      
    </style>
</head>
<body>
    <div class="wrapper">
      <!-- Sidebar Holder -->
           <nav id="sidebar">
                <div class="sidebar-header">
                   <a href='index.php'> <h3>Employee Data Management</h3></a>
                </div>

                <ul class="list-unstyled components">
                    <li class="active">
                        <a href="index.php">Dashboard</a>
                        
                    </li>    
                   <li>
                        <a href="create.php">Add Employee</a>
                        
                    </li>
                    <li>
                        <a href="dataupload.php">Data Upload</a>
                    </li>
                  
                </ul>

                
            </nav>
        <div class="container-fluid">
          
          
<?php 
          //Including the config and user info
          include('welcome.php'); ?>
<?php
// Check existence of id parameter before processing further
if(isset($_GET["empid"]) && !empty(trim($_GET["empid"]))){
    
    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE empid = :empid";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':empid', $param_empid);
        
        // Set parameters
        $param_empid = trim($_GET["empid"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];
                $empid = $row["empid"];
                $role = $row["role"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
          
         
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
                   <div class="form-group">
                        <label>Employee Id</label>
                        <p class="form-control-static"><?php echo $row["empid"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                   <div class="form-group">
                        <label>Role</label>
                        <p class="form-control-static"><?php echo $row["role"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p class="form-control-static"><?php echo $row["address"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <p class="form-control-static"><?php echo $row["salary"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>