<!DOCTYPE html>
<html>
<head>
    <title>Create New Employee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php
    include '../Common/header.php';
    ?>
    <h1>Create New Employee</h1>

    <form action="../../Controllers/UserController.php" method="POST">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="user_type">User Type:</label>
            <select class="form-control" id="user_type" name="user_type" required>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
            </select>
        </div>

        <button type="submit" name="new_employee_data" value="new_employee_data" class="btn btn-primary">Create User</button>
    </form>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
