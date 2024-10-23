<?php

include "db_connect.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the user is an admin
    $sql = "SELECT * FROM admins WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        if ($password == $admin['password']) {
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password.";
            header("Location: admin_login.php");
            exit();
        }
    } else {
        echo '<script>
                    alert("Username or password entered was wrong!");
                    window.location.href = "admin_login.php";
                </script>';
        // $_SESSION['error'] = "No admin found with that username.";
        // header("Location: admin_login.php");
        // exit();
    }
    
    // $conn->close();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: admin_login.php");
    exit();
}
?>
