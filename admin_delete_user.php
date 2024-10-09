<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

// Timeout duration
$timeout_duration = 60;

// Check if the timeout variable is set and has passed
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: admin_login.php");
    exit();
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();

include "db_connect.php";

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete user from the database
    $sql = "DELETE FROM users WHERE id = $user_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('User deleted successfully!');
                window.location.href = 'admin_dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting user: " . $conn->error . "');
                window.location.href = 'admin_dashboard.php';
              </script>";
    }

    $conn->close();
} else {
    echo "<script>
            alert('Invalid request.');
            window.location.href = 'admin_dashboard.php';
          </script>";
}
?>
