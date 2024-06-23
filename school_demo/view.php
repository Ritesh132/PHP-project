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

$sql = "SELECT student.id, student.name, student.email, student.address, student.created_at, student.image, classes.name as class_name
        FROM student
        JOIN classes ON student.class_id = classes.class_id
        WHERE student.id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    die("Student not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<nav class="navbar bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand">Educase India
    </a>
    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
</nav><br><br>
    <div class="container">
        <h1>View Student</h1>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td><?php echo $student['name']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $student['email']; ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?php echo $student['address']; ?></td>
            </tr>
            <tr>
                <th>Class</th>
                <td><?php echo $student['class_name']; ?></td>
            </tr>
            <tr>
                <th>
