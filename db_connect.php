<?php
header('Content-Type: application/json');

$host = "mysql.railway.internal"; 
$dbname = "railway"; 
$username = "root"; 
$password = "SIUfodpeZgHmfdLZOCIseRqcwOBiSuJO";
$port=3306; 

// Ckrna kya hai smjh ni aaya 
$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => $conn->connect_error]);
    exit();
}
?>