<?php
namespace App\Controllers;
require_once 'autoload.php';
use App\Models\User;
use PHPMailer\PHPMailer\Exception;

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
            header("Location: http://localhost/EpignosisPortal/App/Views/Manager/manager_home.php");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            // Redirect to the create employee page
            $employee_data = [
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'verified_password' =>$_POST['verified_password']
            ];
            $url = $this->authenticate_employee($employee_data);
            header("Location:" . $url);
            die();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
            session_start();
            $user_type = $_SESSION["user_type"];
            // Redirect to the create employee page
            if($user_type == "employee"){
                $redirect_url = "Location: http://localhost/EpignosisPortal/App/Views/Login/login.php";
            }else{
                $redirect_url = "Location: http://localhost/EpignosisPortal/App/Views/Login/login.php";
            }
            $_SESSION = array();
            session_destroy();
            header($redirect_url);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
            $user = new User();
            $user = $user->get_user_by_id($_POST["user_id"]);
            $user->setFirstName($_POST["first_name"]);
            $user->setLastName($_POST["last_name"]);
            $user->setEmail($_POST["email"]);
            $user->setUserType($_POST["user_type"]);
            try{
                $user ->update_user($_POST["user_id"], $user);
                header("Location: http://localhost/EpignosisPortal/App/Views/Manager/manager_home.php");
            }catch (Exception $e){

            }
            // Redirect to the create employee page

        }
    }
    private function authenticate_employee($employee_data){
        session_start();
//        var_dump($employee_data);
        try{
            $employee = $this->get_employee_by_email($employee_data["email"]);
        }catch (Exception $e){

        }
        //if the returned employee object(from the db) has a first name and email(which means we successfully fetched it) try to authenticate by checking the password.
        if($employee->getEmail() != null && $employee->getFirstName()){
            $hashedPassword = $employee->getPassword();
            $userType = $employee->getUserType();
            $userEmail = $employee->getEmail();
            $inputPassword = $employee_data["password"];
            #compare the input password to the password returned from the db.
            if (password_verify($inputPassword, $hashedPassword)) {
                #based on the user type(employee or admin) redirect to the appropriate home page
                if($userType == "employee"){
                    $_SESSION["user_type"] = $userType;
                    $_SESSION["user_email"] = $userEmail;
                    return  "http://localhost/EpignosisPortal/App/Views/Employee/employee_home.php";
                }else{
                    $_SESSION["user_type"] = $userType;
                    $_SESSION["user_email"] = $userEmail;
                    return "http://localhost/EpignosisPortal/App/Views/Manager/manager_home.php";
                }
            } else {
                echo "Wrong password";
            }
        }
        echo "123";
    }
    private function save_new_employee($data) {
        // Perform any validation or data processing here
        // Save the data to the database using your preferred method
        // Example code to save data to the database
        $user_data = [
            'first_name' =>  $data["first_name"],
            'last_name' => $data["last_name"],
            'email' => $data["email"],
            'password' => password_hash($data["password"], PASSWORD_DEFAULT),
            'user_type' => $data["user_type"],
        ];
        $userModel = new User($user_data);
        $userModel->save_user();

        // Redirect or display success message
//        header("Location: http://localhost/EpignosisPortal/App/Views/Home/Manager/manager_home.php");
//        exit;
    }
    public function get_employee_by_email($email): User
    {
        $user = new User();
        $user = $user->get_user_by_email($email);
        return $user;
    }

    public function get_employee_by_id($id){
        $user = new User();
        $user = $user->get_user_by_id($id);
        return $user;
    }

    public function get_all_employees(){
        return User::get_all_users();
    }
}
// Create an instance of the UserController
$controller = new UserController();
// Handle the request
$controller->handleRequest();