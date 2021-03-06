

<?php


// Database credentials. Assuming you are running MySQL server with default setting
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'crudedb');
define('DB_PASSWORD', 'test3434');
define('DB_NAME', 'crudedb');
 
// Attempt to connect to MySQL database 
try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

/*

// PHP Data Objects(PDO) Sample Code:

    $pdo1 = new PDO("sqlsrv:server = tcp:crudedbserver.database.windows.net,1433; Database = CrudeDB", "user", "pwd12%%12");
    $pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (!$pdo1) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }




// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "user@crudedbserver", "pwd" => "pwd12%%12", "Database" => "CrudeDB", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:crudedbserver.database.windows.net,1433";
$pdo = sqlsrv_connect($serverName, $connectionInfo);*/
?>

