<?php

namespace App\Controllers;
require 'vendor/autoload.php';

use App\Models\Mail;
use App\Models\User;
use App\Models\VacationRequest;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once 'autoload.php';

class MailController
{
    public function handleRequest()
    {
        // Redirect the manager to the create an employee form
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["get_emails"])) {
          $url = "http://localhost/EpignosisPortal/App/Views/Email/email.php";
          header("Location".$url);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['approve_vacation_request']) || isset($_POST["deny_vacation_request"]))) {
            $vacation_request_data = VacationRequest::get_vacation_request_by_id($_POST["vacation_request_id"]);
            var_dump($vacation_request_data);
            $vacation_request = new VacationRequest($vacation_request_data);
            $mail_data = Mail::get_mail_by_id($_POST["mail_id"]);
            $vacation_request_id = $vacation_request->getId();
            $mail = new Mail($mail_data["sender_email"], $mail_data["recipient_email"], $mail_data["subject"], $mail_data["message"],$vacation_request_id,  $mail_data["is_read"], $mail_data["created_at"]);
            if(isset($_POST['approve_vacation_request'])){
                $vacation_request->setStatus("approved");
                $mail->setIsRead(true);
                $decision = "accepted";
            }
            if(isset($_POST['deny_vacation_request'])){
                $vacation_request->setStatus("denied");
                $mail->setIsRead(true);
                $decision = "rejected";
            }
            $vacation_request->update_vacation_request($_POST["vacation_request_id"],$vacation_request);
            $mail->update_mail($_POST["mail_id"],$mail);
            $mail = new PHPMailer(true);
            $sender = $mail_data["recipient_email"];
            $recipient = $mail_data["sender_email"];
            $subject = 'Vacation Request Decision';
            $body = 'Dear employee, your supervisor has '. $decision .' your application
submitted on '. date('Y-m-d', strtotime($vacation_request->getDateRequested())).'.';
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = '127.0.0.1';
                $mail->SMTPAuth = false;
                $mail->SMTPAutoTLS = false;
                $mail->Port = 1025;
                //add sender, recipient, subject and body to the email
                $mail->setFrom($sender);
                $mail->addAddress($recipient);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;
                // Send the email
                try {
                    $mail->send();
                    $mail_data = new Mail($sender, $recipient, $subject, $body, $vacation_request->getId());
                    $mail_data->save_mail_information();
                } catch (Exception $e) {
                    echo 'error while sending or saving the mail ';
                }

                header("Location: http://localhost/EpignosisPortal/App/Views/Email/email.php");
            } catch (Exception $e) {
                echo 'Failed to send email: ' . $mail->ErrorInfo;
            }



        }
    }

    public function get_all_emails_by_recipient()
    {
        $email = $_SESSION["user_email"];
        return Mail::get_all_emails_by_recipient($email);
    }
    public function get_unread_emails_by_recipient()
    {
        $email = $_SESSION["user_email"];
        return Mail::get_unread_emails_by_recipient($email);
    }

    public function get_emails_by_sender()
    {
        $email = $_SESSION["user_email"];
        return Mail::get_emails_by_sender($email);
    }
}

$controller = new MailController();

// Handle the request
$controller->handleRequest();
