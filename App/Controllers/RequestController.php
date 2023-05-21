<?php
namespace App\Controllers;
use App\Models\VacationRequest;
require_once 'autoload.php';

class RequestController
{
    public function handleRequest()
    {
        //redirect the manager to the create an employee form
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_vacation_request'])) {
            // Redirect to the create employee page
            $vacation_request_data = [
                'vacation_start' => $_POST["vacation_start"],
                'vacation_end' => $_POST["vacation_end"],
                'reason' => $_POST["reason"],
                'status' => 'pending',
                'days_requested'=>$_POST["days_requested"]
            ];
            $this->save_new_vacation_request($vacation_request_data);

            header("Location: http://localhost/EpignosisPortal/App/Views/Home/Employee/employee_home.php");
            exit;
        }
    }
    private function save_new_vacation_request($data){

        $vacation_data = [
            'vacation_start' => $data["vacation_start"],
            'vacation_end' => $data["vacation_end"],
            'reason' => $data["reason"],
            'status' => $data["status"],
            'days_requested' => $data["days_requested"]
        ];

        $vacation_request = new VacationRequest($vacation_data);
        $vacation_request->save_vacation_request();
    }

    public function get_all_vacation_requests(){
        return VacationRequest::get_all_vacation_requests();

    }
}
$controller = new RequestController();

// Handle the request
$controller->handleRequest();
