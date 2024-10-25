<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Check if there's an existing punch in without punch out
$sql = "SELECT * FROM time_entries WHERE username='$username' AND punch_out IS NULL";
$result = $conn->query($sql);
$response = array('punchedIn' => false);

if ($result->num_rows > 0) {
    $response['punchedIn'] = true;
}

echo json_encode($response);
$conn->close();
?>