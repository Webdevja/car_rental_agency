<?php
include('includes/db.php');
session_start();

if ($_SESSION['user_type'] !== 'agency') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vehicle_model = $_POST['vehicle_model'];
    $vehicle_number = $_POST['vehicle_number'];
    $seating_capacity = $_POST['seating_capacity'];
    $rent_per_day = $_POST['rent_per_day'];

    $stmt = $conn->prepare("INSERT INTO cars (vehicle_model, vehicle_number, seating_capacity, rent_per_day) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $vehicle_model, $vehicle_number, $seating_capacity, $rent_per_day);

    if ($stmt->execute()) {
        echo "Car added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Car</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Add New Car</h2>
    <form action="add_car.php" method="post">
        <label for="vehicle_model">Vehicle Model:</label>
        <input type="text" id="vehicle_model" name="vehicle_model" required><br><br>
        <label for="vehicle_number">Vehicle Number:</label>
        <input type="text" id="vehicle_number" name="vehicle_number" required><br><br>
        <label for="seating_capacity">Seating Capacity:</label>
        <input type="number" id="seating_capacity" name="seating_capacity" required><br><br>
        <label for="rent_per_day">Rent Per Day:</label>
        <input type="number" step="0.01" id="rent_per_day" name="rent_per_day" required><br><br>
        <input type="submit" value="Add Car">
    </form>
</body>
</html>
