<?php

namespace App\Models;

use Core\Database;
use PDO;

class Mail extends Database
{
    private int $vacation_request_id;
    private string $sender;
    private string $recipient;
    private string $subject;
    private string $message;

    public function __construct(string $sender,string $recipient, string $subject, string $message, int $vacation_request_id)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->subject = $subject;
        $this->message = $message;
        $this->vacation_request_id = $vacation_request_id;
    }


    public function save_mail_information(){

            $db = static::connectToDatabase();
            $sql_statement = 'INSERT INTO mail (sender_email, recipient_email, subject, message, vacation_request_id)
                            values (:sender_email, :recipient_email, :subject, :message, :vacation_request_id)';
            $query = $db->prepare($sql_statement);
            $query->bindParam(':sender_email', $this->sender);
            $query->bindParam(':recipient_email', $this->recipient);
            $query->bindParam(':subject', $this->subject);
            $query->bindParam(':message', $this->message);
            $query->bindParam(':vacation_request_id', $this->vacation_request_id);

            //returns true if it succeeded and false if not
            return $query->execute();

}
    #get all the incoming mails for the email provided.
    public static function get_emails_by_recipient($recipient_email){

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
