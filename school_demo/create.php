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

// Fetch classes for dropdown
$sql = "SELECT * FROM classes";
$classes_result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Validate input
    if (!empty($name) && ($image == '' || (mime_content_type($_FILES['image']['tmp_name']) == 'image/jpeg' || mime_content_type($_FILES['image']['tmp_name']) == 'image/png'))) {
        // Upload image
        if ($image != '') {
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
        }

        // Insert student into the database
        $sql = "INSERT INTO student (name, email, address, class_id, image, created_at) VALUES ('$name', '$email', '$address', $class_id, '$image', NOW())";
        if ($conn->query($sql) === TRUE) {
            header('Location: index.php');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid input";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Student</title>
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
        <h1>Create Student</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>
            <div class="form-group">
                <label for="class_id">Class</label>
                <select class="form-control" id="class_id" name="class_id" required>
                    <?php while ($class = $classes_result->fetch_assoc()): ?>
                        <option value="<?php echo $class['class_id']; ?>"><?php echo $class['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</body>
</html>
