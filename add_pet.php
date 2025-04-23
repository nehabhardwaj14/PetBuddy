<?php
include('db_connect.php');
if (
    isset($_POST['pet_name'], $_POST['breed'], $_POST['age'], $_POST['category'], $_POST['price'], $_POST['status']) &&
    !empty($_POST['pet_name']) && !empty($_POST['breed']) && !empty($_POST['age']) &&
    !empty($_POST['category']) && !empty($_POST['price']) && !empty($_POST['status']) &&
    isset($_FILES['image']) && isset($_FILES['image']['name'])
) {
    $petName = $_POST['pet_name'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileTmp = $_FILES['image']['tmp_name'];
    $originalName = $_FILES['image']['name'];
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $uniqueName = uniqid('img_', true) . '.' . $ext;
    $targetFile = $uploadDir . $uniqueName;

    if (move_uploaded_file($fileTmp, $targetFile)) {
        $stmt = $conn->prepare("INSERT INTO pets (name, breed, age, category, price, status, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissss", $petName, $breed, $age, $category, $price, $status, $uniqueName);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Pet added suc+cessfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Database insert failed."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to move uploaded file."]);
    }
} else {

echo isset($_POST['pet_name'], $_POST['breed'], $_POST['age'], $_POST['category'], $_POST['price'], $_POST['status']);
echo !empty($_POST['pet_name']) . "<br>";

echo !empty($_POST['breed']) . "<br>";
echo !empty($_POST['age']) . "<br>";
echo !empty($_POST['category']) . "<br>"; 
echo !empty($_POST['price']) . "<br>";
echo !empty($_POST['status']) . "<br>"; 
echo isset($_FILES['image']) . "<br>";
echo isset($_FILES['image']['name']) . "<br>";

    echo json_encode(["success" => false, "message" => "Missing required fields or invalid image."]);
}//krio run application
?>