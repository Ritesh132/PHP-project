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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image']['name'];

    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES['image']['tmp_name']);

        if($check !== false && ($imageFileType == "jpg" || $imageFileType == "png")) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $stmt = $conn->prepare("UPDATE student SET name=?, email=?, address=?, class_id=?, image=? WHERE id=?");
                $stmt->bind_param("sssisi", $name, $email, $address, $class_id, $image, $id);
                $stmt->execute();
                $stmt->close();
                header("Location: index.php");
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image or wrong format.";
        }
    } else {
        $stmt = $conn->prepare("UPDATE student SET name=?, email=?, address=?, class_id=? WHERE id=?");
        $stmt->bind_param("sssii", $name, $email, $address, $class_id, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
    }
}

$student_result = $conn->query("SELECT * FROM student WHERE id = $id");
$student = $student_result->fetch_assoc();

$classes_result = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
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
        <h1>Edit Student</h1>
        <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $student['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $student['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" required><?php echo $student['address']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="class_id">Class</label>
                <select class="form-control" id="class_id" name="class_id" required>
                    <?php while($class = $classes_result->fetch_assoc()): ?>
                        <option value="<?php echo $class['class_id']; ?>" <?php echo $class['class_id'] == $student['class_id'] ? 'selected' : ''; ?>><?php echo $class['name']; ?></option>
                    <?php endwhile; ?>
                    
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
