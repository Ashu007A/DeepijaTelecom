<?php
// Read
$connectionParams = file_get_contents('db_connection.txt');

// Convert to array
parse_str(str_replace("\n", "&", $connectionParams), $dbConfig);

// Assign
$host = $dbConfig['host'];
$username = $dbConfig['username'];
$password = $dbConfig['password'];
$dbname = $dbConfig['dbname'];

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br><br>";

// Query
$sql = "SELECT * FROM admins";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " | Name: " . $row["username"]. " | Email: " . $row["password"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
