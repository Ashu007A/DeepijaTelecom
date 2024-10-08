<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

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
