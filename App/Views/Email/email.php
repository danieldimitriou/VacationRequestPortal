<?php
use App\Controllers\MailController;
require_once 'autoload.php';
require_once '../Common/session.php';
require_once '../Common/header.php';
$controller = new MailController();
//$inbox_emails = $controller->get_all_emails_by_recipient();
$unread_emails = $controller->get_unread_emails_by_recipient();
$outbox_emails = $controller->get_emails_by_sender();

if(!isset($_SESSION["user_type"]) || !isset($_SESSION["user_email"])){
    header("Location: http://localhost/EpignosisPortal/App/Views/Login/login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Inbox</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.7.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Email Inbox</h1>

    <div class="row mt-4">
        <div class="col">
            <?php foreach ($unread_emails as $email): ?>
                <div class="email mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $email['subject']; ?></h5>
                            <?php echo $email['id']; ?>
                            <h6 class="card-subtitle mb-2 text-muted">From: <?php echo $email['sender_email']; ?></h6>
                            <p class="card-text"><?php echo $email['message']; ?></p>
<!--                            <p class="card-text">--><?php //echo $email['']; ?><!--</p>-->
                            <?php if($_SESSION["user_type"] == "admin"){?>

                                <form action="../../Controllers/MailController.php" method="POST">
                                    <input type="hidden" name="vacation_request_id" value="<?php echo $email['vacation_request_id']; ?>">
                                    <input type="hidden" name="mail_id" value="<?php echo $email['id']; ?>">
                                    <button type="submit" name="approve_vacation_request" value="approve_vacation_request" class="btn btn-primary">Approve</button>
                                </form>

                                <form action="../../Controllers/MailController.php" method="POST">
                                    <input type="hidden" name="vacation_request_id" value="<?php echo $email['vacation_request_id']; ?>">
                                    <input type="hidden" name="mail_id" value="<?php echo $email['id']; ?>">
                                    <button type="submit" name="deny_vacation_request" value="deny_vacation_request" class="btn btn-primary">Deny</button>
                                </form>

                            <?php }?>
                            <p class="card-text">Received on: <?php echo date('Y-m-d', strtotime($email['created_at']));; ?></p>
                            <!-- email_template.php -->

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="container">
    <h1 class="mt-5">Email Outbox</h1>

    <div class="row mt-4">
        <div class="col">
            <?php foreach ($outbox_emails as $email): ?>
                <div class="email mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $email['subject']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">To: <?php echo $email['recipient_email']; ?></h6>
                            <p class="card-text">Sent on: <?php echo date('Y-m-d', strtotime($email['created_at']));; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
