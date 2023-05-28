<?php
namespace App\Models;
use Core\Database;
use DateTime;
use PDO;
require_once 'autoload.php';

class VacationRequest extends Database {

    private int $id;
    private string $user_id;
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
            $this->days_requested = $data['days_requested'];
        }
    }

    public function save_vacation_request(){
//        $hashed_password =password_hash($this-> password, PASSWORD_DEFAULT);
        $db = static::connectToDatabase();
        $sql_statement = 'INSERT INTO vacation_request (vacation_start, vacation_end, reason, status, days_requested, requesting_employee_email)
                            values (:vacation_start, :vacation_end, :reason, :status, :days_requested, :requesting_employee_email)';
        $query = $db->prepare($sql_statement);
        $start_date = new DateTime($this->vacation_start);
        $end_date = new DateTime($this->vacation_end);
        $interval = $start_date->diff($end_date);
        $days_requested = $interval->days;
        $requesting_employee_email = $_SESSION["user_email"];
        $query->bindParam(':vacation_start', $this->vacation_start);
        $query->bindParam(':vacation_end', $this->vacation_end);
        $query->bindParam(':reason', $this->reason);
        $query->bindParam(':status', $this->status);
        $query->bindParam(':days_requested', $days_requested);
        $query->bindParam(':requesting_employee_email', $requesting_employee_email);

        //returns true if it succeeded and false if not
        if($query->execute()){
            $lastInsertId = $db->lastInsertId();
            return $lastInsertId;
        }else{
            return \PDOException::class;
        }
    }
    public static function get_vacation_request_by_id($vacation_request_id){
        $db = static::connectToDatabase();
        $sql_statement = 'SELECT * FROM vacation_request where id = :vacation_request_id';
        $query = $db->prepare($sql_statement);
        $query->bindParam(':vacation_request_id', $vacation_request_id);
        $query->execute();
        $vacation_request = $query->fetchAll(PDO::FETCH_ASSOC);
        return $vacation_request;
    }
    public function update_vacation_request($vacation_request_id, $new_vacation_request_data){

    }

    public static function get_all_vacation_requests(){

        $db = static::connectToDatabase();
        $sql_statement = 'SELECT * FROM vacation_request';
        $query = $db->prepare($sql_statement);
        $query->execute();
        $vacation_requests = $query->fetchAll(PDO::FETCH_ASSOC);
        $vacation_request_list = [];
        foreach ($vacation_requests as $vacation_request){
            array_push($vacation_request_list, $vacation_request);
        }
        return $vacation_request_list;

    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    /**
     * @return string
     */
    public function getVacationStart(): string
    {
        return $this->vacation_start;
    }

    /**
     * @param string $vacation_start
     */
    public function setVacationStart(string $vacation_start): void
    {
        $this->vacation_start = $vacation_start;
    }

    /**
     * @return string
     */
    public function getVacationEnd(): string
    {
        return $this->vacation_end;
    }

    /**
     * @param string $vacation_end
     */
    public function setVacationEnd(string $vacation_end): void
    {
        $this->vacation_end = $vacation_end;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getDaysRequested(): int
    {
        return $this->days_requested;
    }

    /**
     * @param int $days_requested
     */
    public function setDaysRequested(int $days_requested): void
    {
        $this->days_requested = $days_requested;
    }


}



