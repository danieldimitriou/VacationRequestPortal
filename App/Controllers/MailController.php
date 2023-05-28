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
            if(isset($_POST['approve_vacation_request'])){
                echo $_POST["vacation_request_id"];
                $vacation_request = VacationRequest::get_vacation_request_by_id($_POST["vacation_request_id"]);
                var_dump($vacation_request);
            }
//            header("Location: http://localhost/EpignosisPortal/App/Views/Email/email.php");

        }
    }

    public function get_emails_by_recipient()
    {
        $email = $_SESSION["user_email"];
        return Mail::get_emails_by_recipient($email);
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
