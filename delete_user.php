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
    $query = "DELETE FROM users WHERE id = '$id'";
    mysqli_query($con, $query);
    header('Location: users_list.php');
    exit;
} else {
    header('Location: users_list.php');
    exit;
}
?>