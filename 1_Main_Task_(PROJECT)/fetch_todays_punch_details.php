<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$response = array();

$currentDate = date('Y-m-d');

$sql = "SELECT * FROM time_entries WHERE username = '$username' AND DATE(punch_in) = '$currentDate'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $response[] = array(
        'id' => $row['id'],
        'username' => $row['username'],
        'punchIn' => $row['punch_in'],
        'punchOut' => $row['punch_out']
    );
}

echo json_encode($response);
$conn->close();
?>