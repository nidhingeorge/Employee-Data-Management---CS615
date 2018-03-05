<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$name = $address = $salary = $empid = $role = "";
$name_err = $address_err = $salary_err = $empid_err = $db_err = $role_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["empid"]) && !empty($_POST["empid"])){
    // Get hidden input value
    $id = $_POST["empid"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }
    
    // Validate address address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = 'Please enter an address.';     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = 'Please enter a positive integer value.';
    } else{
        $salary = $input_salary;
    }
    
  // Validate employee id
   $input_empid = trim($_POST["empid"]);
    if(empty($input_salary)){
        $empid_err = "Please enter the Employee Id.";     
    } elseif(!ctype_digit($input_empid)){
        $empid_err = 'Please enter the Employee Id.';
    } else{
        $empid = $input_empid;
    }
  
   // Validate role
    $input_role = trim($_POST["role"]);
    if(empty($input_role)){
        $role_err = 'Please enter an valid role.';     
    } else{
        $role = $input_role;
    }
    
  
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err) && empty($empid_err) && empty($role_err)){
        // Prepare an insert statement
        $sql = "UPDATE employees SET name=:name, address=:address, salary=:salary, role=:role WHERE empid=:empid";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':name', $param_name);
            $stmt->bindParam(':address', $param_address);
            $stmt->bindParam(':salary', $param_salary);
            $stmt->bindParam(':empid', $param_empid);
            $stmt->bindParam(':role', $param_role);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_empid = $empid;
            $param_role = $role;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["empid"]) && !empty(trim($_GET["empid"]))){
        // Get URL parameter
        $empid =  trim($_GET["empid"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM employees WHERE empid = :empid";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':empid', $param_empid);
            
            // Set parameters
            $param_empid = $empid;
            
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
                    $role = $row["role"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($sql);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                          <div class="form-group <?php echo (!empty($role_err)) ? 'has-error' : ''; ?>">
                            <label>Role</label>
                            <input type="text" name="role" class="form-control" value="<?php echo $role; ?>">
                            <span class="help-block"><?php echo $role_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                        <input type="hidden" name="empid" value="<?php echo $empid; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>