<?php

include "db_connect.php";

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST["phone"];
    $state = $_POST["state"];
    $district = $_POST["district"];
    $city = $_POST["city"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $course = $_POST["course"];
    $address = $_POST["address"];


    $user_id = $_SESSION['userid'];

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
            WHERE id='$user_id'";

    if ($password) {
        $sql = "UPDATE users SET 
                name='$name', 
                username='$username', 
                email='$email', 
                password='$password', 
                phone='$phone', 
                state='$state', 
                district='$district', 
                city='$city', 
                dob='$dob', 
                gender='$gender', 
                course='$course', 
                address='$address' 
                WHERE id='$user_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully!";
        header("Location: dashboard.php");
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
