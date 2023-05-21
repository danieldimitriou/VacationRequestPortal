<?php

namespace App\Models;
use PDO;
use Core\Database;
require_once 'autoload.php';

class User extends Database
{

    private int $id;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;
    private string $user_type;

    public function __construct($data = [])
    {
        if (isset($data['first_name'])) {
            $this->first_name = $data['first_name'];
        }

        if (isset($data['last_name'])) {
            $this->last_name = $data['last_name'];
        }

        if (isset($data['email'])) {
            $this->email = $data['email'];
        }

        if (isset($data['password'])) {
            $this->password = $data['password'];
        }

        if (isset($data['user_type'])) {
            $this->user_type = $data['user_type'];
        }
    }

    public function save_user(){
//        $hashed_password =password_hash($this-> password, PASSWORD_DEFAULT);
        $db = static::connectToDatabase();
        $sql_statement = 'INSERT INTO Users (first_name, last_name, email, password, user_type)
                            values (:first_name, :last_name, :email, :password, :user_type)';
        $query = $db->prepare($sql_statement);
        $query->bindParam(':first_name', $this->first_name);
        $query->bindParam(':last_name', $this->last_name);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':password', $this->password);
        $query->bindParam(':user_type', $this->user_type);

        //returns true if it succeeded and false if not
        return $query->execute();
    }
    public function get_user_by_email($user_email){

    }
    public static function get_all_users(){

        $db = static::connectToDatabase();
        $sql_statement = 'SELECT * FROM Users';
        $query = $db->prepare($sql_statement);
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);

        return $users;

    }
}
