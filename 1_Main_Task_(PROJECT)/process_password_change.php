<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$timeout_duration = 60;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$_SESSION['last_activity'] = time();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Check
    if ($new_password !== $confirm_password) {
        echo "New passwords do not match.";
        exit();
    }

    // Fetch
    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $current_password_hash = $user["password"];

        // Verify
        if (password_verify($old_password, $current_password_hash)) {

            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            $update_sql = "UPDATE users SET password = '$new_password_hash' WHERE username = '$username'";
            if ($conn->query($update_sql) === TRUE) {
                // echo '<script>alert("Password changed successfully! Please Login again.")</script>';
                // header("Location: login.php");
                echo '<script>
                    alert("Password changed successfully! Please Login again.");
                    window.location.href = "login.php";
                </script>';
                exit();
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "Old password is incorrect.";
        }
    } else {
        echo "User not found.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>