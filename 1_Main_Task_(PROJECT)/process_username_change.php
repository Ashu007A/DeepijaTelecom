<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Timeout duration
$timeout_duration = 60;

// Check if the timeout variable is set and has passed
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_username = $_SESSION['username'];
    $new_username = $_POST["new_username"];

    // Check if new username already exists
    $sql = "SELECT * FROM users WHERE username = '$new_username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo '<script>
                alert("Username already exists!");
                window.history.back();
              </script>';
        exit();
    }

    // Update username in the database
    $sql = "UPDATE users SET username = '$new_username' WHERE username = '$old_username'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['username'] = $new_username; // Update session with new username
        echo '<script>
                alert("Username changed successfully! Please Login again!");
                window.location.href = "login.php";
              </script>';
    } else {
        echo "Error updating username: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>