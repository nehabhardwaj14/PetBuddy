<?php
    header('Content-Type: application/json');

//print_r($_POST);
//exit();

// Database connection setup
include('db_connect.php');

$response = array();
$users = array();

// Check if both username and password are sent
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Basic login query (not secure – for demo only)
    $sql = "SELECT * FROM register WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $response["success"] = true;
        $response["users"] = $users;
    } 
    else {
        $response["success"] = false;
        $response["message"] = "No users found";
    }
} else {
    $response["success"] = false;
    $response["message"] = "Some Fields Are Missing";
}
echo json_encode($response);
// Close connection
$conn->close();
?>
