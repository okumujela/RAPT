<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['register_resource'])) {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'rapt';

    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    $name = $_POST['name'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $assigned_to = $_POST['assigned_to'];
    $department = $_POST['department'];

    $query = "INSERT INTO resources (name, category, status, assigned_to, department) VALUES ('$name', '$category', '$status', '$assigned_to', '$department')";
    mysqli_query($con, $query);
    header('Location: resources.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Resource to RAPT</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Register Resource to RAPT</h2>
        <form action="resources.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" class="form-control" id="category" name="category" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="available">Available</option>
                    <option value="allocated">Allocated</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>
            <div class="form-group">
                <label for="assigned_to">Assigned To:</label>
                <select class="form-control" id="assigned_to" name="assigned_to" required>
                    <?php
                    $query = "SELECT id, username FROM users";
                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" class="form-control" id="department" name="department" required>
            </div>
            <button type="submit" name="register_resource" class="btn btn-primary">Register Resource</button>
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>