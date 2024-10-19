<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$note = $_POST['note'];
$username = $_SESSION['username'];

echo "$note<br>";
echo "$username<br>";
    
$date = date('Y-m-d');
// $filename = "/opt/lampp/htdocs/AKR/notes/$username-$date.txt";
// $filename = "/notes/$username-$date.txt";
// $filename = "/home/dtel/Documents/$username-$date.txt";
$filename = "/opt/lampp/htdocs/AKR/notes/test.txt";

echo "Saving to: $filename<br>";

if (file_exists($filename)) {
    echo "Success";
} else {
    echo "Failed";
}

// if (!is_dir('/opt/lampp/htdocs/AKR/notes')) {
//     mkdir('/opt/lampp/htdocs/AKR/notes', 0755, true);
//     chown('/opt/lampp/htdocs/AKR/notes', 'dtel');
//     echo "Created directory and set ownership<br>";
// }

// Open the file for appending
$file = fopen($filename, "a") or die("Unable to open file!");
if ($file) {
    fwrite(stream: $file,data: $note . PHP_EOL);
    fclose($file);
    echo "Note saved successfully!";
} else {
    echo "Error saving note!";
}

// Append the note to the file
// if (file_put_contents($filename, $note.PHP_EOL, FILE_APPEND) !== false) {
//     echo "Note saved successfully!";
// } else {
//     echo "Error saving note!";
// }

//------------------------------------------------------------------------------------

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['note'])) {
//     $note = $_POST['note'];
//     $username = $_SESSION['username'];
    
//     $date = date('Y-m-d');
//     $filename = "/opt/lampp/htdocs/AKR/notes/$username-$date.txt";

//     // Append the note to the file
//     if (file_put_contents($filename, $note.PHP_EOL, FILE_APPEND) !== false) {
//         echo "Note saved successfully!";
//     } else {
//         echo "Error saving note!";
//     }
// } else {
//     echo "Invalid request.";
// }
?>
