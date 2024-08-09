<?php
include('../includes/db.php'); // Adjust the path as necessary
session_start();

// Fetch car ID from URL
$car_id = $_GET['id'];

// Check if user is logged in and is a customer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: login.php");
    exit();
}

// Fetch car details
$sql = "SELECT * FROM cars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $car = $result->fetch_assoc();
} else {
    echo "Car not found.";
    exit();
}

// Handle car rental logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $start_date = $_POST['start_date'];
    $days = $_POST['days'];

    // Insert into rentals table
    $sql = "INSERT INTO rentals (user_id, car_id, start_date, days) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $user_id, $car_id, $start_date, $days);

    if ($stmt->execute()) {
        // Mark car as unavailable
        $sql = "UPDATE cars SET available = 0 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $car_id);
        $stmt->execute();

        echo "Car rented successfully!";
    } else {
        echo "Error renting car: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rent Car</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
    <h2>Rent Car</h2>
    <form method="post" action="">
        <p>Vehicle Model: <?php echo htmlspecialchars($car['model']); ?></p>
        <p>Vehicle Number: <?php echo htmlspecialchars($car['vehicle_number']); ?></p>
        <p>Seating Capacity: <?php echo htmlspecialchars($car['seating_capacity']); ?></p>
        <p>Rent Per Day: <?php echo htmlspecialchars($car['rent_per_day']); ?></p>
        <p>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
        </p>
        <p>
            <label for="days">Number of Days:</label>
            <input type="number" id="days" name="days" required>
        </p>
        <p>
            <button type="submit">Rent Car</button>
        </p>
    </form>
</body>
</html>