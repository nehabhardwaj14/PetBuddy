<?php
include 'db_connect.php'; // assumes $conn
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['status'])){
    $status = $_GET['status'];
    $sql = "SELECT ar.request_id, ar.status, ar.request_date, 
                   ar.applicant_name, ar.email, ar.address, ar.reason,
                u.email as user_email, p.id as pet_id, p.name as pet_name, p.breed as pet_breed, p.age as pet_age, p.category as pet_category, p.image as pet_image, p.price as pet_price
            FROM adoption_requests ar
            JOIN register u ON ar.user_id = u.id
            JOIN pets p ON ar.pet_id = p.id
            WHERE ar.status = '$status'
            ORDER BY ar.request_date DESC";
    $result = mysqli_query($conn, $sql);
    
    $response = [];
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }
        echo json_encode(["success" => true, "total_requests" => mysqli_num_rows($result), "requests" => $response]);
    } else {
        echo json_encode(["success" => false, "message" => "No adoption requests found."]);
    }
}
else if($_SERVER['REQUEST_METHOD'] === 'GET' ){
    $sql = "SELECT ar.request_id, ar.status, ar.request_date, 
                   ar.applicant_name, ar.email, ar.address, ar.reason,
                u.email as user_email, p.id as pet_id, p.name as pet_name, p.breed as pet_breed, p.age as pet_age, p.category as pet_category, p.image as pet_image, p.price as pet_price
            FROM adoption_requests ar
            JOIN register u ON ar.user_id = u.id
            JOIN pets p ON ar.pet_id = p.id
            ORDER BY ar.request_date DESC";
    
    $result = mysqli_query($conn, $sql);
    
    $response = [];
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }
        echo json_encode(["success" => true, "total_requests" => mysqli_num_rows($result), "requests" => $response]);
    } else {
        echo json_encode(["success" => false, "message" => "No adoption requests found."]);
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])){

    $request_id = $_POST['request_id'];

    $sql = "SELECT ar.request_id, ar.status, ar.request_date, 
                ar.applicant_name, ar.email, ar.address, ar.reason,
                u.email as user_email, u.username as username, p.id as pet_id, p.name as pet_name, p.breed as pet_breed, p.age as pet_age, p.category as pet_category, p.image as pet_image, p.price as pet_price, p.status as pet_status
            FROM adoption_requests ar
            JOIN register u ON ar.user_id = u.id
            JOIN pets p ON ar.pet_id = p.id
            WHERE ar.request_id = $request_id";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode(["success" => true, "result" => $row]);
    } else {
        echo json_encode(["success" => false, "message" => "Request not found"]);
    }
    
    
}

$conn->close();
?>
