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

// Register a new resource
if (isset($_POST['register_resource'])) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];
    $assigned_to = $_POST['assigned_to'];
    $department_id = $_POST['department_id'];

    $query = "INSERT INTO resources (name, category_id, status, assigned_to, department_id) 
              VALUES ('$name', '$category_id', '$status', '$assigned_to', '$department_id')";
    mysqli_query($con, $query);
    header('Location: resources.php');
    exit;
}

// Fetch categories for dropdown
$query_categories = "SELECT * FROM resource_categories";
$result_categories = mysqli_query($con, $query_categories);

// Fetch users for dropdown
$query_users = "SELECT id, username FROM users";
$result_users = mysqli_query($con, $query_users);

// Fetch departments for dropdown
$query_departments = "SELECT id, name FROM departments";
$result_departments = mysqli_query($con, $query_departments);

// Fetch all resources for listing
$query_resources = "SELECT r.id, r.name, r.status, c.name AS category_name, u.username AS assigned_to_username, d.name AS department_name 
                    FROM resources r 
                    LEFT JOIN resource_categories c ON r.category_id = c.id 
                    LEFT JOIN users u ON r.assigned_to = u.id 
                    LEFT JOIN departments d ON r.department_id = d.id";
$result_resources = mysqli_query($con, $query_resources);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resources Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Resources Management</h2>

    <!-- Resource Registration Form -->
    <form action="resources.php" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <?php while ($category = mysqli_fetch_assoc($result_categories)) { ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php } ?>
            </select>
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
                <?php while ($user = mysqli_fetch_assoc($result_users)) { ?>
                    <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="department_id">Department:</label>
            <select class="form-control" id="department_id" name="department_id" required>
                <?php while ($department = mysqli_fetch_assoc($result_departments)) { ?>
                    <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="register_resource" class="btn btn-primary">Register Resource</button>
    </form>

    <!-- List of Resources -->
    <h3>Existing Resources</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Category</th>
            <th>Assigned To</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($resource_row = mysqli_fetch_assoc($result_resources)) { ?>
            <tr>
                <td><?php echo $resource_row['id']; ?></td>
                <td><?php echo $resource_row['name']; ?></td>
                <td><?php echo $resource_row['status']; ?></td>
                <td><?php echo $resource_row['category_name']; ?></td>
                <td><?php echo $resource_row['assigned_to_username']; ?></td>
                <td><?php echo $resource_row['department_name']; ?></td>
                <td>
                    <!-- Edit and Delete Links -->
                    <a href="edit_resource.php?id=<?php echo $resource_row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="delete_resource.php?id=<?php echo $resource_row['id']; ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure you want to delete this resource?')">Delete</a></td></tr><?php } ?>
        </tbody>
    </table>
    <a href='index.php' class='btn btn-secondary'>Back to Dashboard</a>
</div>
</body>
</html>;