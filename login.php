<?php
session_start();
$host = 'localhost';
$db = 'travel_agency';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'login' && isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            header("Location: home_page.html"); // Redirect to homepage on successful login
        } else {
            echo "Invalid username or password";
        }

        $stmt->close();

    } elseif ($action == 'register' && isset($_POST['new_username'], $_POST['new_password'])) {
        
        $new_username = $_POST['new_username'];
        $new_password = $_POST['new_password'];

        $check_sql = "SELECT * FROM users WHERE username = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $new_username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "Username already exists, please choose a different one.";
        } else {
            $insert_sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ss", $new_username, $new_password);
            if ($insert_stmt->execute()) {
                echo "Registration successful! You can now log in.";
            } else {
                echo "Error registering user. Please try again.";
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
} else {
    echo "Please enter valid information.";
}

$conn->close();
?>
