<?php

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/

// Database connection settings
include('db_connect.php');

// Retrieve the POST data from Android app

if (isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['user_type'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

     /* Simple duplicate email check*/
     $checkQuery = "SELECT * FROM register WHERE email = ?";
     $stmt = $conn->prepare($checkQuery);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $result = $stmt->get_result();

     if ($result->num_rows > 0) {
        echo json_encode(["status" => false, "message" => "Email already exists"]);
    } else {
        // Insert user into database
        $insertQuery = "INSERT INTO register (email, username, password, user_type) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $email, $username, $password, $user_type);

        if ($stmt->execute()) {
            $inserted_id = $stmt->insert_id;
            echo json_encode(["status" => true, "user_id" => $inserted_id, "message" => "Sign Up Success"]);
        } else {
            echo json_encode(["status" => false, "message" => "Sign Up Failed"]);
        }
    }

} else {
    echo json_encode(["status" => false, "message" => "Any Field is Empty"]);
}

// Hash the password before storing it
//$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Prepare the SQL query to insert the new user
//$sql = "INSERT INTO register (username, password, email, user_type) 
     //   VALUES ('$username', '$password', '$email', '$user_type')";

// Check if the query was successful
//if ($conn->query($sql) === TRUE) {
   // echo "Sign Up Success";
//} else {
 //   echo "Error: " . $sql . "<br>" . $conn->error;
//}

// Close the connection
$conn->close();
?>
