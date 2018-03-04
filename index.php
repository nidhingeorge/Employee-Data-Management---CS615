<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <li class="active">
                        <a href="index.php">Overview</a>
                        
                    </li>    
                   <li>
                        <a href="create.php">Add Employee</a>
                        
                    </li>
                    <li>
                        <a href="dataupload.php">Data Load</a>
                    </li>
                  
                </ul>

                
            </nav>
       
   
   <div class="container-fluid">
           <?php include('welcome.php'); ?>
            <div class="row">
                <div class="col-md-12">
                 
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Details</h2>
                        <!--<a href="create.php" class="btn btn-success pull-right">Add New Employee</a>-->
                    </div>
                    <?php
                    // Include config file
                    //require_once 'config.php';
                    
             
                    // Attempt select query execution
                    $sql = "SELECT * FROM employees";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        // echo "<th>#</th>";
                                        echo "<th>Employee Id</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Role</th>";
                                        echo "<th>Address</th>";
                                        echo "<th>Salary</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        //echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['empid'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['role'] . "</td>";
                                        echo "<td>" . $row['address'] . "</td>";
                                        echo "<td>" . $row['salary'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?empid=". $row['empid'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a> &nbsp;&nbsp;";
                                            echo "<a href='update.php?empid=". $row['empid'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a> &nbsp;&nbsp;";
                                            echo "<a href='delete.php?empid=". $row['empid'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            unset($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                    }
                    
                    // Close connection
                    unset($pdo);
                    ?>
                </div>
            </div>        
        </div>
       </div>
  <!-- jQuery CDN -->
         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
         </script>
    
</body>
</html>