<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
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

$query = "SELECT * FROM users";
$result_users = mysqli_query($con, $query);

$query = "SELECT * FROM departments";
$result_departments = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Departments to Users</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Assign Departments to Users</h2>
        <?php while ($user_row = mysqli_fetch_assoc($result_users)) { ?>
            <h3><?php echo $user_row['username']; ?></h3>
            <form action="assign_department.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_row['id']; ?>">
                <?php while ($department_row = mysqli_fetch_assoc($result_departments)) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="departments[]" value="<?php echo $department_row['id']; ?>">
                        <label class="form-check-label"><?php echo $department_row['name']; ?></label>
                    </div>
                <?php } ?>
                <button type="submit" name="assign_departments" class="btn btn-primary">Assign Departments</button>
            </form>
            <?php
            mysqli_data_seek($result_departments, 0); // Reset the pointer
            ?>
        <?php } ?>
    </div>
</body>
</html>