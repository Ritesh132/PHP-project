<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "school_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "SELECT image FROM student WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $image_path = 'uploads/' . $student['image'];

    if (file_exists($image_path)) {
        unlink($image_path); // Delete the image file from the server
    }

    $conn->query("DELETE FROM student WHERE id = $id");
    header("Location: index.php");
} else {
    die("Student not found.");
}
?>
