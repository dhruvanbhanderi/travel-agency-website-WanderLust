<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_agency";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bookings
$sql = "SELECT * FROM bookings ORDER BY booking_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Bookings</title>
</head>
<body>
    <h1>Admin Dashboard - Bookings</h1>
    <table border="1">
        <tr>
            <th>Booking ID</th>
            <th>Tour Package</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            <th>Booking Date</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['tour_package']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['message']; ?></td>
            <td><?php echo $row['booking_date']; ?></td>
        </tr>
        <?php } ?>
    </table>
    <?php $conn->close(); ?>
</body>
</html>
