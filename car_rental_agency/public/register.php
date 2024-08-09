<?php
include('../includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = 'customer'; // You can modify this if you want different types of users

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");

    // Check if the prepare statement was successful
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $user_type);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: login.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Car Rental Agency</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="available_cars.php">Available Cars</a>
        <a href="view_booked_cars.php">View Booked Cars</a>
    </nav>
    <div class="container">
        <h2>Register</h2>
        <form method="post" action="register.php">
            <p>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </p>
            <p>
                <label for="user_type">User Type:</label>
                <select id="user_type" name="user_type" required>
                    <option value="customer">Customer</option>
                    <option value="agency">Agency</option>
                </select>
            </p>
            <p>
                <button type="submit">Register</button>
            </p>
        </form>
    </div>
</body>
</html>