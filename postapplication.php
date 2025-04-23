<?php
header('Content-Type: application/json');

include('db_connect.php');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['user_id']);
    $pet_id = intval($_POST['pet_id']);
    $name = $_POST['applicant_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $reason = $_POST['reason'];


// Step 1: Check if user exists
$user_check = mysqli_query($conn, "SELECT id FROM register WHERE id = '$user_id'");
if (mysqli_num_rows($user_check) == 0) {
    die(json_encode(["success" => false, "message" => "Invalid user ID"]));
}

// Step 2: Check if pet exists
$pet_check = mysqli_query($conn, "SELECT id FROM pets WHERE id = '$pet_id'");
if (mysqli_num_rows($pet_check) == 0) {
    die(json_encode(["success" => false, "message" => "Invalid pet ID"]));
}

    $sql = "INSERT INTO adoption_requests (user_id, pet_id, applicant_name, email, phone, address, reason)
            VALUES ($user_id, $pet_id, '$name', '$email', '$phone', '$address', '$reason')";

    if (mysqli_query($conn, $sql)) {
        $request_id =  mysqli_insert_id($conn);
        mysqli_query($conn, "Update pets set status = 'pending' where id = $pet_id");
        $response['success'] = true;
        $response['requestId'] = $request_id;
        $response['message'] = "Adoption request submitted.";
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to submit request.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid method.";
}

echo json_encode($response);
?>
