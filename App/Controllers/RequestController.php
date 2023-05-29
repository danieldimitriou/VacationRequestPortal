<?php

namespace App\Controllers;
require 'vendor/autoload.php';

use App\Models\Mail;
use App\Models\User;
use App\Models\VacationRequest;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once 'autoload.php';

class RequestController
{
    public function handleRequest()
    {
        // Redirect the manager to the create an employee form
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_vacation_request'])) {
            $vacation_request_data = [
                'vacation_start' => $_POST["vacation_start"],
                'vacation_end' => $_POST["vacation_end"],
                'reason' => $_POST["reason"],
                'status' => 'pending',
            ];
            try{
                $vacation_request = $this->saveNewVacationRequest($vacation_request_data);
                var_dump($vacation_request->getId());
            }catch (Exception $e){
                echo $e;
                echo "Error while saving request. Please try again.";
            }
            $manager_email = User::get_manager_email();
//            var_dump($vacation_request);
            $user = new User();
            $user = $user->get_user_by_email($_SESSION["user_email"]);
            $mail = new PHPMailer(true);
            $sender = $user->getEmail();
            $recipient = $manager_email["email"];
            $subject = 'Vacation Request';
            $body = '
  <h1 style="color: #333;">Dear supervisor,</h1>
  <p>Employee ' . $user->getFirstName() . ' ' . $user->getLastName() . ' requested for some time off, starting on ' . $vacation_request->getVacationStart() . ' and ending on ' . $vacation_request->getVacationEnd() . ', stating the reason:</p>
  <p>' . $vacation_request->getReason() . '</p>
  <p>Click on one of the below links to approve or reject the application:</p>
  <p>
  
 
';
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = '127.0.0.1';
                $mail->SMTPAuth = false;
                $mail->SMTPAutoTLS = false;
                $mail->Port = 1025;

                // Set sender and recipient
                $mail->setFrom($sender);
                $mail->addAddress($recipient);

                // Set email content
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

                header("Location: http://localhost/EpignosisPortal/App/Views/Employee/employee_home.php");
            } catch (Exception $e) {
                echo 'Failed to send email: ' . $mail->ErrorInfo;
            }
            exit;
        }
    }

    private function saveNewVacationRequest($data)
    {
        session_start();
        $vacation_data = [
            'vacation_start' => $data["vacation_start"],
            'vacation_end' => $data["vacation_end"],
            'reason' => $data["reason"],
            'status' => $data["status"],
        ];

        $vacation_request = new VacationRequest($vacation_data);
        $vacation_request_id= $vacation_request->save_vacation_request();
        $vacation_request->setId($vacation_request_id);


        return $vacation_request;
    }

    public function get_all_vacation_requests()
    {
        return VacationRequest::get_all_vacation_requests();
    }

    public function get_employees_vacation_requests($employee_email){
        return VacationRequest::get_employees_vacation_requests($employee_email);
    }

}

$controller = new RequestController();

// Handle the request
$controller->handleRequest();
