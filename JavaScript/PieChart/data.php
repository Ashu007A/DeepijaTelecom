<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pie_chart_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT category, value FROM data";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $data[] = [$row["category"], (int)$row["value"]];
  }
} else {
  echo "0 results";
}
$conn->close();
echo json_encode($data);
?>