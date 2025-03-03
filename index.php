<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Allocation and Problem Tracking System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome to RAPT</h2>
        <p>You are logged in as <?php echo $_SESSION['username']; ?></p>
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <a href="resources.php" class="btn btn-primary">Manage Resources</a>
        <?php if ($_SESSION['role'] == 'super_admin') { ?>
            <a href="assign_manager.php" class="btn btn-secondary">Assign Manager</a>
        <?php } ?>
    </div>
</body>
</html>