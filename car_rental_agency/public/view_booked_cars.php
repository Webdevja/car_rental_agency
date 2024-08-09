<?php
include('includes/db.php');
session_start();

if ($_SESSION['user_type'] !== 'agency') {
    header("Location: index.php");
    exit;
}

$agency_id = $_SESSION['user_id']; // assuming agency_id is stored in session
$sql = "SELECT rentals.id, rentals.car_id, rentals.user_id, rentals.start_date, rentals.number_of_days, cars.vehicle_model, users.username
        FROM rentals
        JOIN cars ON rentals.car_id = cars.id
        JOIN users ON rentals.user_id = users.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booked Cars</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Booked Cars</h2>
    <table border="1">
        <tr>
            <th>Booking ID</th>
            <th>Vehicle Model</th>
            <th>Customer Username</th>
            <th>Start Date</th>
            <th>Number of Days</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['vehicle_model']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['start_date']; ?></td>
                <td><?php echo $row['number_of_days']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$conn->close();