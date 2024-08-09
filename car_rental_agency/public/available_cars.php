<?php
include('../includes/db.php'); // Adjust the path as necessary
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Available Cars</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Car Rental Agency</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="view_booked_cars.php">View Booked Cars</a>
    </nav>
    <div class="container">
        <h2>Available Cars for Rent</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Vehicle Model</th>
                        <th>Vehicle Number</th>
                        <th>Seating Capacity</th>
                        <th>Rent Per Day</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP code to display available cars will be here -->
                    <?php
                    include('includes/db.php');
                    $sql = "SELECT * FROM cars WHERE available = 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['model']}</td>
                                    <td>{$row['vehicle_number']}</td>
                                    <td>{$row['seating_capacity']}</td>
                                    <td>{$row['rent_per_day']}</td>
                                    <td><a href='rent_car.php?id={$row['id']}'>Rent Car</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='no-records'>No cars available for rent</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>