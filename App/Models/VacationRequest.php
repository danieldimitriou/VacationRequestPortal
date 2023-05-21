<?php
namespace App\Models;
use Core\Database;
use PDO;
require_once 'autoload.php';

class VacationRequest extends Database {

    private string $vacation_start;
    private string $vacation_end;
    private string $reason;
    private string $status;
    private int $days_requested;

    public function __construct($data = [])
    {
        if (isset($data['vacation_start'])) {
            $this->vacation_start = $data['vacation_start'];
        }

        if (isset($data['vacation_end'])) {
            $this->vacation_end = $data['vacation_end'];
        }

        if (isset($data['reason'])) {
            $this->reason = $data['reason'];
        }

        if (isset($data['status'])) {
            $this->status = $data['status'];
        }
        if (isset($data['days_requested'])) {
            $this->status = $data['days_requested'];
        }
    }

    public function save_vacation_request(){
//        $hashed_password =password_hash($this-> password, PASSWORD_DEFAULT);
        $db = static::connectToDatabase();
        $sql_statement = 'INSERT INTO vacation_request (vacation_start, vacation_end, reason, status)
                            values (:vacation_start, :vacation_end, :reason, :status)';
        $query = $db->prepare($sql_statement);
        $query->bindParam(':vacation_start', $this->vacation_start);
        $query->bindParam(':vacation_end', $this->vacation_end);
        $query->bindParam(':reason', $this->reason);
        $query->bindParam(':status', $this->status);

        //returns true if it succeeded and false if not
        return $query->execute();
    }
    public static function get_all_vacation_requests(){

        $db = static::connectToDatabase();
        $sql_statement = 'SELECT * FROM vacation_request';
        $query = $db->prepare($sql_statement);
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);

        return $users;

    }

}



