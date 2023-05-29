<?php

namespace App\Models;

use Core\Database;
use PDO;

class Mail extends Database
{
    private int $id;
    private int $vacation_request_id;
    private string $sender;
    private string $recipient;
    private string $subject;
    private string $message;
    private bool $is_read;

    public function __construct(string $sender,string $recipient, string $subject, string $message, int $vacation_request_id, bool $is_read = null)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->subject = $subject;
        $this->message = $message;
        $this->vacation_request_id = $vacation_request_id;
        if($is_read == null){
            $this->is_read = 0;
        }else{
            $this->is_read = $is_read;
        }
    }

    public static function get_mail_by_id($id){
        $db = static::connectToDatabase();
        $sql_statement = 'SELECT * FROM mail where id = :id';
        $query = $db->prepare($sql_statement);
        $query->bindParam(':id',$id);
        $query->execute();
        $mail = $query->fetch(PDO::FETCH_ASSOC);

        return $mail;
    }
    public function save_mail_information(){

            $db = static::connectToDatabase();
            $sql_statement = 'INSERT INTO mail (sender_email, recipient_email, subject, message, vacation_request_id, is_read)
                            values (:sender_email, :recipient_email, :subject, :message, :vacation_request_id, :is_read)';
            $query = $db->prepare($sql_statement);
            $query->bindParam(':sender_email', $this->sender);
            $query->bindParam(':recipient_email', $this->recipient);
            $query->bindParam(':subject', $this->subject);
            $query->bindParam(':message', $this->message);
            $query->bindParam(':vacation_request_id', $this->vacation_request_id);
            $query->bindParam(':is_read', $this->is_read);

            //returns true if it succeeded and false if not
            return $query->execute();

}
    public function update_mail($mail_id, Mail $new_mail_data)
    {
        $db = static::connectToDatabase();

        // Construct the SQL statement
        $sql_statement = 'UPDATE mail SET  is_read = :is_read WHERE id = :mail_id';

        // Prepare the query
        $query = $db->prepare($sql_statement);

        // Bind the parameters
        $is_read = $new_mail_data->getIsRead();
        $query->bindParam(':is_read', $is_read);
        $query->bindParam(':mail_id', $mail_id);

        // Execute the query
        if ($query->execute()) {
            return true; // Return true if the update was successful
        } else {
            return false; // Return false if the update failed
        }
    }
    #get all the incoming mails for the email provided.
    public static function get_all_emails_by_recipient($recipient_email){

            $db = static::connectToDatabase();
            $sql_statement = 'SELECT * FROM mail where recipient_email = :recipient_email ';
            $query = $db->prepare($sql_statement);
            $query->bindParam(':recipient_email',$recipient_email);
            $query->execute();
            $emails = $query->fetchAll(PDO::FETCH_ASSOC);
            $email_list = [];
            foreach($emails as $email){
                array_push($email_list, $email);
            }
            return $email_list;
    }
    public static function get_unread_emails_by_recipient($recipient_email){

            $db = static::connectToDatabase();
            $sql_statement = 'SELECT * FROM mail where recipient_email = :recipient_email and is_read = :is_read ';
            $query = $db->prepare($sql_statement);
            $query->bindParam(':recipient_email',$recipient_email);
            $is_read = 0;
            $query->bindParam(':is_read',$is_read);
            $query->execute();
            $emails = $query->fetchAll(PDO::FETCH_ASSOC);
            $email_list = [];
            foreach($emails as $email){
                array_push($email_list, $email);
            }
            return $email_list;
    }
    #get all the outgoing mails for the email provided.
    public static function get_emails_by_sender($recipient_email){

        $db = static::connectToDatabase();
        $sql_statement = 'SELECT * FROM mail where sender_email = :recipient_email ';
        $query = $db->prepare($sql_statement);
        $query->bindParam(':recipient_email',$recipient_email);
        $query->execute();
        $emails = $query->fetchAll(PDO::FETCH_ASSOC);
        $email_list = [];
        foreach($emails as $email){
            array_push($email_list, $email);
        }
        return $email_list;
    }
    public function getIsRead(){
        return $this->is_read;
    }
    public function setIsRead(bool $is_read){
        $this->is_read = $is_read;
    }
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getHeaders(): string
    {
        return $this->headers;
    }

    public function setHeaders(string $headers): void
    {
        $this->headers = $headers;
    }

    public function __toString(): string
    {
        return "Recipient: {$this->recipient}\nSubject: {$this->subject}\nBody: {$this->body}\nHeaders: {$this->headers}";
    }
}
