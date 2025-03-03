<?php
session_start();

if (isset($_POST['login'])) {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'rapt';

    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Incorrect password';
        }
    } else {
        $error = 'Username not found';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to RAPT</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <h1 class="mb-4">Resources Allocation and  Problem Tracking (RAPT) System</h1>
    <p>Magae your resources like a Pro with this versatile RAPT System!</p>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                <h2>User Login</h2>
                    <h5 class="card-title">Managing your resources made easy!</h5>
                    <p>Enter your username and password.</p>
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
                        <a href="register.php" class="btn btn-secondary">Register</a>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>