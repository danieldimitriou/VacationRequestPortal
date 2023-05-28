<?php
use App\Controllers\UserController;
require_once 'autoload.php';
require_once 'App/Controllers/UserController.php';
require_once '../Common/session.php';

// Fetch All Users
$controller = new UserController();
//
//// Fetch All Users (employees)
$users = $controller->get_all_employees();
//if (isset($_POST['add_employees'])) {
//    // Redirect the create employee page
//    header("Location: http://localhost/EpignosisPortal/App/Views/CreateEmployee/create_employee.php");
//    exit; // Make sure to exit after redirecting to prevent further execution
//}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<?php
include '../Common/header.php';
?>
<div class="container">
    <h1>User Management</h1>
    <a href="http://localhost/EpignosisPortal/App/Views/Manager/create_employee.php" class="button" style="display: inline-block;padding: 10px 20px;  background-color: lightslategray;
  color: white;
  text-decoration: none;
  border-radius: 4px;">Add new employees</a>
    <!-- User List -->
    <h2>User List</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>User Type</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['first_name'] ?></td>
                    <td><?= $user['last_name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['user_type'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
