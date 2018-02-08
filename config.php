<?php


// PHP Data Objects(PDO) Sample Code:

    $pdo = new PDO("sqlsrv:server = tcp:crudedbserver.database.windows.net,1433; Database = CrudeDB", "user", "pwd12%%12");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (!$pdo) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }




// SQL Server Extension Sample Code:
/*$connectionInfo = array("UID" => "user@crudedbserver", "pwd" => "pwd12%%12", "Database" => "CrudeDB", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:crudedbserver.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);*/



/* Attempt to connect to MySQL database */
/*
$connectstr_dbhost = 'tcp:crudedbserver.database.windows.net,1433';
$connectstr_dbname = 'CrudeDB';
$connectstr_dbusername = 'user';
$connectstr_dbpassword = 'pwd12%%12';
// MS Azure does not allow direct access to MySQL configuration, only via environment
foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }
    
    $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}
$pdo = sqlsrv_connect($connectstr_dbhost, $connectstr_dbusername, $connectstr_dbpassword,$connectstr_dbname);
if (!$pdo) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}*/
// TODO make sure DB exists
// TODO create table (only once, if it does not yet exist)
?>
