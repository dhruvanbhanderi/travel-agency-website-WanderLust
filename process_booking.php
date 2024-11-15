<?php
// Database connection (replace with your own database details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_agency";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$tourPackage = $_POST['tour-package'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

// Store data in database
$sql = "INSERT INTO bookings (tour_package, name, email, phone, message) VALUES ('$tourPackage', '$name', '$email', '$phone', '$message')";
if ($conn->query($sql) === TRUE) {
    // Send email to admin
    $adminEmail = "admin@wanderlusttravels.com";
    $subject = "New Booking from $name";
    $body = "Tour Package: $tourPackage\nName: $name\nEmail: $email\nPhone: $phone\nMessage: $message";
    mail($adminEmail, $subject, $body);

    // Redirect to confirmation page with data in URL
    header("Location: submit_booking.html?name=".urlencode($name)."&email=".urlencode($email)."&phone=".urlencode($phone)."&message=".urlencode($message)."&tourPackage=".urlencode($tourPackage));
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
