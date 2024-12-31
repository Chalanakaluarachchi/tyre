<?php
// Database connection file
$serverName = "LAPTOP-S17OQCRK"; // Replace with your SQL Server name
$connectionOptions = [
    "Database" => "PX_AUTO_TYRE_MART", // Database name
    "Uid" => "ravishka",         // SQL Server username
    "PWD" => "123456"          // SQL Server password
];

// Establish connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Check connection
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
