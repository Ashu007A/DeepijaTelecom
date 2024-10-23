<?php

include "db_connect.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Session
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $user['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password.";
            header("Location: login.php");
            exit();
        }
    } else {
        echo '<script>
                    alert("Username or password entered was wrong!");
                    window.location.href = "login.php";
                </script>';
        // $_SESSION['error'] = "No user found with that username.";
        // header("Location: login.php");
        // exit();
    }
    
    // $conn->close();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: login.php");
    exit();
}
?>
