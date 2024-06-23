<?php
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "school_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch students with their respective class names
$sql = "SELECT student.id, student.name, student.email, student.created_at, student.image, classes.name as class_name 
        FROM student 
        LEFT JOIN classes ON student.class_id = classes.class_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
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
</nav>    
<div class="container">
        <h1>Student List</h1>
        <a href="create.php" class="btn btn-primary mb-3">Add Student</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Created At</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($student = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$student['name']}</td>
                                <td>{$student['email']}</td>
                                <td>{$student['class_name']}</td>
                                <td>{$student['created_at']}</td>
                                <td><img src='uploads/{$student['image']}' width='50' height='50'></td>
                                <td>
                                    <a href='view.php?id={$student['id']}' class='btn btn-info btn-sm'>View</a>
                                    <a href='edit.php?id={$student['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete.php?id={$student['id']}' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No students found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$conn->close();
?>
