<?php
namespace App\Controllers;
require_once 'autoload.php';
use App\Models\User;

class UserController {
    public function handleRequest()
    {
        //save the new employee data from the create new employee form
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_employee_data'])) {
            // Redirect to the create employee page
            $employee_data = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'user_type' => $_POST['user_type'],
            ];
            $this->save_new_employee($employee_data);
            header("Location: http://localhost/EpignosisPortal/App/Views/Home/Manager/manager_home.php");
            exit;
        }

    }
    private function save_new_employee($data) {
        // Perform any validation or data processing here
        // Save the data to the database using your preferred method

        // Example code to save data to the database
        $user_data = [
            'first_name' =>  $data["first_name"],
            'last_name' => $data["last_name"],
            'email' => $data["email"],
            'password' => $data["password"],
            'user_type' => $data["user_type"],
        ];

        $userModel = new User($user_data);
        $userModel->save_user();

        // Redirect or display success message
//        header("Location: http://localhost/EpignosisPortal/App/Views/Home/Manager/manager_home.php");
//        exit;
    }

    public function get_all_employees(){
        return User::get_all_users();
    }
}

// Create an instance of the UserController
$controller = new UserController();

// Handle the request
$controller->handleRequest();