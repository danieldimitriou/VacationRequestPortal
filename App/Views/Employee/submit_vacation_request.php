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
        <div class="col-md-6">
            <h2>New Request</h2>
            <form action="../../Controllers/RequestController.php" method="POST">
                <div class="form-group">
                    <label for="date_from">Date from (vacation start):</label>
                    <input type="date" class="form-control" id="vacation_start" name="vacation_start" required>
                </div>

                <div class="form-group">
                    <label for="date_to">Date to (vacation end):</label>
                    <input type="date" class="form-control" id="vacation_end" name="vacation_end" required>
                </div>

                <div class="form-group">
                    <label for="reason">Reason:</label>
                    <textarea class="form-control" id="reason" name="reason" required></textarea>
                </div>

                <button type="submit" name="new_vacation_request" value="new_vacation_request" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <!-- Add any additional content or scripts here -->
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- Add any additional JavaScript files or scripts here -->
</body>
</html>
