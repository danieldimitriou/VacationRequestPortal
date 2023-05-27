<?php
use App\Controllers\RequestController;
require_once 'autoload.php';
require_once 'App/Controllers/RequestController.php';
$controller = new RequestController();
//
//// Fetch All Users (employees)
$requests = $controller->get_all_vacation_requests();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vacation Requests</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Add any additional CSS links or stylesheets here -->
</head>
<body>
<?php
include '../Common/header.php';
?>
<div class="container">
    <h1>Vacation Requests</h1>
    <a href="http://localhost/EpignosisPortal/App/Views/Employee/submit_vacation_request.php" class="button" style="display: inline-block;padding: 10px 20px;  background-color: lightslategray;
  color: white;
  text-decoration: none;
  border-radius: 4px;">Submit new request</a>
    <div class="row">
        <div class="row">
            <?php foreach ($requests as $request): ?>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Date Submitted: <?= $request['date_submitted'] ?></h5>
                            <p class="card-text">Dates Requested: <?= $request['vacation_start'] ?> - <?= $request['vacation_end'] ?></p>
                            <p class="card-text">Days Requested: <?= $request['days_requested'] ?></p>
                            <p class="card-text">Status: <?= $request['status'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>



    <!-- Add any additional content or scripts here -->
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- Add any additional JavaScript files or scripts here -->
</body>
</html>
