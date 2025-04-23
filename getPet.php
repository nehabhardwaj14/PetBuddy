<?php
header('Content-Type: application/json');

include('db_connect.php');

if (isset($_GET['category'])){
    $cat = $_GET['category'];
    $sql = "SELECT * FROM `pets` WHERE `category` LIKE '$cat'";
}
else{
    $sql = "SELECT * FROM pets";
}
$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
                $pets[] = $row;
        }
        $response["success"] = true;
        $response["pets"] = $pets;
        echo json_encode($response);
    } 
    else {
        $response["success"] = false;
        $response["message"] = "No Pets Available";
        echo json_encode($response);
    }
?>