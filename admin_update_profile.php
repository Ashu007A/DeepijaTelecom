<?php

include "db_connect.php";

session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $state = $_POST["state"];
    $district = $_POST["district"];
    $city = $_POST["city"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $course = $_POST["course"];
    $address = $_POST["address"];

    $sql = "UPDATE users SET 
            name='$name', 
            username='$username', 
            email='$email', 
            phone='$phone', 
            state='$state', 
            district='$district', 
            city='$city', 
            dob='$dob', 
            gender='$gender', 
            course='$course', 
            address='$address' 
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Profile updated successfully!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating profile: " . $conn->error;
        header("Location: admin_edit_profile.php?id=$id");
        exit();
    }

    // $conn->close();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: admin_dashboard.php");
    exit();
}
?>
