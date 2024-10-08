<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
