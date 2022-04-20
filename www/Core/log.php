<?php
require_once 'Logger.php';

function connectToDatabase()
{
    $dbhost = 'database';
    $dbname =  'mvcdocker2';
    $dbuser = 'root';
    $dbport = '3306';
    $dbpass = 'password';
    try {
        $pdo = new PDO("mysql:host=$dbhost;port=$dbport;dbname=$dbname", $dbuser, $dbpass);
    } catch (PDOException $e) {
        
        Logger::write_log("Database connection failed", [$e->getMessage()]); // <- Log a fatal error with details
        
        die("Oh snap, looks like something didn't work. Please retry again later");
}
    }