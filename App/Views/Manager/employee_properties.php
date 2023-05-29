<?php

use App\Controllers\UserController;
include '../Common/header.php';
require_once '../Common/session.php';

$controller = new UserController();
$user = $controller->get_employee_by_id($_GET['id']);
var_dump($_GET["id"]);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>User Details</h1>

        <form action="../../Controllers/UserController.php" method="POST">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user->getFirstName(); ?>" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user->getLastName(); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user->getEmail(); ?>" required>
            </div>
            <div class="form-group">
                <label for="user_type">User Type:</label>
                <select class="form-control" id="user_type" name="user_type" required>
                    <option value="admin" <?php if ($user->getUserType() === 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="employee" <?php if ($user->getUserType() === 'employee') echo 'selected'; ?>>Employee</option>
                </select>
            </div>

            <input type="hidden" name="user_id" value="<?php echo $_GET["id"]; ?>" required>
            <button type="submit" class="btn btn-primary" name="update_user" value="update_user">Update User</button>

        </form>
</div>
</body>
</html>
