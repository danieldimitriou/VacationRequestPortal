<!-- header.php -->
<?php
require_once 'autoload.php';
require_once '../Common/session.php';
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Add CSS links or stylesheets here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #343a40; /* Set the background color to dark gray */
        }
        .navbar .navbar-brand,
        .navbar .nav-link {
            color: #fff; /* Set the color of the links */
        }
        .navbar .nav-link:hover {
            color: #f8f9fa; /* Set the hover color of the links */
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <?php if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "admin") { ?>
            <a class="navbar-brand" href="http://localhost/EpignosisPortal/App/Views/Manager/manager_home.php">Home</a>
        <?php }else{?>
            <a class="navbar-brand" href="http://localhost/EpignosisPortal/App/Views/Employee/employee_home.php">Home</a>
        <?php }?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" style="color:white;" href="http://localhost/EpignosisPortal/App/Views/Email/email.php">
                        <i class="fa fa-envelope"></i> Mail Notifications
                    </a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form method="POST" action="../../Controllers/UserController.php">
                    <button type="submit" class="btn btn-primary btn-block" name="logout" value="logout">Logout</button>
                </form>
            </li>
        </ul>
    </nav>
</header>

<!-- Add JavaScript dependencies for Bootstrap here -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
