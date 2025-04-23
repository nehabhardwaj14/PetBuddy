<?php
header('Content-Type: application/json');

include('db_connect.php');

if(isset($_POST['name']) && isset($_POST['breed']) && isset($_POST['category']) && isset($_POST['age']) && isset($_POST['imgurl']) && isset($_POST['price'], $_POST['status'])){
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $category = strtolower($_POST['category']);
    $age = $_POST['age'];
    $image = $_POST['imgurl'];
    $status = $_POST['status'];
    $price =  $_POST['price'];

    $sql = "INSERT INTO pets (name, breed, category, age, image, price, status)
                VALUES ('$name', '$breed', '$category', '$age', '$image', '$price', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Pet uploaded successfully"]);
    } 
    else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}
else{
    echo json_encode(["status" => "error", "message" => "Invalid Paremeters"]);
}


$conn->close();
?>
