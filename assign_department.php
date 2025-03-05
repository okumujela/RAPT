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

if (isset($_POST['assign_departments'])) {
    $user_id = $_POST['user_id'];
    $departments = $_POST['departments'];

    // Clear existing assignments for the user
    $query = "DELETE FROM user_departments WHERE user_id = '$user_id'";
    mysqli_query($con, $query);

    // Assign new departments
    foreach ($departments as $department_id) {
        $query = "INSERT INTO user_departments (user_id, department_id) VALUES ('$user_id', '$department_id')";
        mysqli_query($con, $query);
    }

    header('Location: assign_departments.php');
    exit;
}
?>