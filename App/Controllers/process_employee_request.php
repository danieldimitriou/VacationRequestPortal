<?php
include_once '../Models/User.php';
include_once '../Models/VacationRequest.php';
include_once 'Core/Database.php';

$dateFrom = $_POST['date_from'];
$dateTo = $_POST['date_to'];
$reason = $_POST['reason'];

$database = new Database();

$db = $database->connectToDatabase();