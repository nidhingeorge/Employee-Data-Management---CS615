<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$name = $address = $salary = $empid = $role = "";
$name_err = $address_err = $salary_err = $empid_err = $db_err = $role_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = 'Please enter an address.';     
    } else{
        $address = $input_address;
    }
  
   // Validate role
    $input_role = trim($_POST["role"]);
    if(empty($input_role)){
        $role_err = 'Please enter an valid role.';     
    } else{
        $role = $input_role;
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
  
   // Validate EmpId
    $input_empid = trim($_POST["empid"]);
    if(empty($input_empid)){
        $empid_err = "Please enter the Employee Id.";     
    } elseif(!ctype_digit($input_salary)){
        $empid_err = 'Please enter the Employee Id2.';
    } else{
        $empid = $input_empid;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err) && empty($empid_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (empid, name, address, salary, role) VALUES (:empid, :name, :address, :salary, :role)";
 
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
            
        



            try {
            // Attempt to execute the prepared statement
              if($stmt->execute()){
                  // Records created successfully. Redirect to landing page
                  header("location: index.php");
                  exit();
              } else{
                  echo "Something went wrong. Please try again later.";
              }
            } catch (PDOException $e) {
              $db_err = "DataBase Error: The record could not be added. Please check the entered data.<br>";
            } catch (Exception $e) {
              $db_err = "General Error: The record could not be added.<br>";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                   <li class="active">
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                       <div class="form-group <?php echo (!empty($empid_err)) ? 'has-error' : ''; ?>">
                            <label>Employee Id</label>
                            <input type="text" name="empid" class="form-control" value="<?php echo $empid; ?>">
                            <span class="help-block"><?php echo $empid_err;?></span>
                        </div>  
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
                        <input type="submit" class="btn btn-primary" style="background-color: #1f3f562" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                       <span class="help-block"><?php echo $db_err;?></span>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>