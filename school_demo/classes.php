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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $stmt = $conn->prepare("INSERT INTO classes (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit'])) {
        $class_id = $_POST['class_id'];
        $name = $_POST['name'];
        $stmt = $conn->prepare("UPDATE classes SET name=? WHERE class_id=?");
        $stmt->bind_param("si", $name, $class_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $class_id = $_POST['class_id'];
        $conn->query("DELETE FROM classes WHERE class_id = $class_id");
    }
}

$classes_result = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link 
</head>
<body>

    <div class="container">
        <h1>Manage Classes</h1>
        <form action="classes.php" method="post">
            <div class="form-group">
                <label for="name">Class Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Add Class</button>
        </form>

        <h2>All Classes</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($classes_result->num_rows > 0) {
                    while($class = $classes_result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$class['name']}</td>
                                <td>
                                    <form action='classes.php' method='post' style='display:inline-block'>
                                        <input type='hidden' name='class_id' value='{$class['class_id']}'>
                                        <input type='text' name='name' value='{$class['name']}' required>
                                        <button type='submit' name='edit' class='btn btn-warning'>Edit</button>
                                    </form>
                                    <form action='classes.php' method='post' style='display:inline-block'>
                                        <input type='hidden' name='class_id' value='{$class['class_id']}'>
                                        <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No classes found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
