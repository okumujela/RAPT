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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
} else {
    header('Location: users_list.php');
    exit;
}

if (isset($_POST['edit_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $query = "UPDATE users SET username = '$username', email = '$email', role = '$role' WHERE id = '$id'";
    mysqli_query($con, $query);
    header('Location: users_list.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit User</h2>
    <form action="edit_user.php?id=<?php echo $id; ?>" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select class="form-control" id="role" name="role" required>
                <option value="user" <?php if ($row['role'] == 'user') echo 'selected'; ?>>User</option>
                <option value="manager" <?php if ($row['role'] == 'manager') echo 'selected'; ?>>Manager</option>
                <?php if ($_SESSION['role'] == 'super_admin') { ?>
                    <option value="super_admin" <?php if ($row['role'] == 'super_admin') echo 'selected'; ?>>Super Admin</option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="edit_user" class="btn btn-primary">Save Changes</button>
        <a href="users_list.php" class="btn btn-secondary">Back to Users List</a>
    </form>
</div>
</body>
</html>