<?php
include "db_connect.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$action = $_GET['action'];

date_default_timezone_set('Asia/Kolkata');
$dateTime = date("Y-m-d H:i:s");
$response = array('success' => false);

if ($action == 'in') {
    // Check punch in
    $sql = "SELECT * FROM time_entries WHERE username='$username' AND punch_out IS NULL";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $response['message'] = "You have already punched in.";
    } else {
        $sql = "INSERT INTO time_entries (username, punch_in) VALUES ('$username', '$dateTime')";
        if ($conn->query($sql) === TRUE) {
            $entryId = $conn->insert_id;
            $response['success'] = true;
            $response['entryId'] = $entryId;
            $response['username'] = $username;
            $response['punchIn'] = $dateTime;
        }
    }
} elseif ($action == 'out') {
    $sql = "SELECT id FROM time_entries WHERE username='$username' AND punch_out IS NULL ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $entryId = $row['id'];
        $updateSql = "UPDATE time_entries SET punch_out='$dateTime' WHERE id='$entryId'";
        if ($conn->query($updateSql) === TRUE) {
            $response['success'] = true;
            $response['entryId'] = $entryId;
            $response['punchOut'] = $dateTime;
        }
    } else {
        $response['message'] = "No punch in found for punch out.";
    }
}

echo json_encode($response);
$conn->close();
?>