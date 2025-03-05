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
    <title>RAPT Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dashboard-card {
            height: 100%;
            transition: all 0.3s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">RAPT Dashboard</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Welcome, <?php echo $_SESSION['username']; ?></span>
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Resources</h5>
                        <p class="card-text">Manage and track all resources</p>
                        <a href="resources.php" class="btn btn-primary">Go to Resources</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <p class="card-text">Manage resource categories</p>
                        <a href="categories.php" class="btn btn-primary">Go to Categories</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Departments</h5>
                        <p class="card-text">Manage departments</p>
                        <a href="departments.php" class="btn btn-primary">Go to Departments</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">Manage system users</p>
                        <a href="users_list.php" class="btn btn-primary">Go to Users</a>
                    </div>
                </div>
            </div>
            <?php if ($_SESSION['role'] == 'super_admin') { ?>
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Assign Manager</h5>
                        <p class="card-text">Assign manager roles to users</p>
                        <a href="assign_manager.php" class="btn btn-primary">Assign Manager</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>