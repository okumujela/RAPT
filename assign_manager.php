<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'super_admin') {
    header('Location: login.php');
    exit;
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'rapt';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (isset($_POST['assign_manager'])) {
    $user_id = $_POST['user_id'];
    $query = "UPDATE users SET role = 'manager' WHERE id = '$user_id'";
    mysqli_query($con, $query);
    header('Location: assign_manager.php');
    exit;
}

$query = "SELECT * FROM users WHERE role = 'user'";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Manager</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Assign Manager</h2>
    <form action="assign_manager.php" method="post">
        <div class="form-group">
            <label for="user_id">Select User:</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="assign_manager" class="btn btn-primary">Assign Manager</button>
    </form>
    <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
</div>
</body>
</html>