<?php
include "db_connect.php";

// Collecting POST data
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
$address = $_POST["address"];

// Course validation
if (empty($_POST["course"])) {
    echo '<script>alert("Please select at least one course."); window.history.back();</script>';
    exit();
}

$course = implode(", ", $_POST["course"]);

// Check if username, email, or phone already exists
$sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email' OR phone = '$phone'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['username'] == $username) {
            echo '<script>alert("Username already exists!"); window.history.back();</script>';
            exit();
        }
        if ($row['email'] == $email) {
            echo '<script>alert("Email already exists!"); window.history.back();</script>';
            exit();
        }
        if ($row['phone'] == $phone) {
            echo '<script>alert("Phone number already exists!"); window.history.back();</script>';
            exit();
        }
    }
} else {
    // SQL insert query
    $sql = "INSERT INTO users (name, username, email, password, phone, state, district, city, dob, gender, course, address)
            VALUES ('$name', '$username', '$email', '$password', '$phone', '$state', '$district', '$city', '$dob', '$gender', '$course', '$address')";
    
    if ($conn->query($sql) === TRUE) {
        echo '<script>
                alert("New account created successfully! Please Login!");
                window.location.href = "login.php";
              </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>