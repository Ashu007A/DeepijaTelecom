<?php

include "db_connect.php";

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

$sql = "INSERT INTO users (name, username, email, password, phone, state, district, city, dob, gender, course, address) 
        VALUES ('$name', '$username', '$email', '$password', '$phone', '$state', '$district', '$city', '$dob', '$gender', '$course', '$address')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully!";
    header("Location: login.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
