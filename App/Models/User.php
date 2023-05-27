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
    public function get_user_by_email($user_email): User
    {
        $db = static::connectToDatabase();
        $sql_statement = 'SELECT * FROM Users where email = :email ';
        $query = $db->prepare($sql_statement);
        $query->bindParam(':email',$user_email);
        $query->execute();
        $user_data = $query->fetch(PDO::FETCH_ASSOC);
        $user = new User($user_data);
        return new User($user_data);
    }

    public static function get_all_users(){

        $db = static::connectToDatabase();
        $sql_statement = 'SELECT * FROM Users';
        $query = $db->prepare($sql_statement);
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);

        return $users;

    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUserType(): string
    {
        return $this->user_type;
    }

    /**
     * @param string $user_type
     */
    public function setUserType(string $user_type): void
    {
        $this->user_type = $user_type;
    }


}
