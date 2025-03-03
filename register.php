<?php
session_start();

if (isset($_POST['register'])) {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'rapt';

    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    mysqli_query($con, $query);
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register to RAPT</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <h1 class="mb-4">Resources Allocation and  Problem Tracking (RAPT) System</h1>
    <p>Magae your resources like a Pro with this versatile RAPT System!</p>
        
        <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                <h2>Register to RAPT</h2>
                    <h5 class="card-title">Managing your resources made easy!</h5>
                    <p>Enter the details below to register.</p>
                    <form action="register.php" method="post">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-primary">Register</button>
                        <a href="login.php" class="btn btn-secondary">Login</a>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>