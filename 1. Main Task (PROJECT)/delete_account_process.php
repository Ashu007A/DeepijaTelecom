<?php
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

include "db_connect.php";

$username = $_SESSION['username'];

$sql = "DELETE FROM users WHERE username = '$username'";
if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
    
    session_unset();
    session_destroy();
    header("Location: home.html");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
