<?php
//Conector to database
$db_server="localhost:3306"; //$_ENV["MYSQL_SERVER"];
$db_database="webshop"; //$_ENV["MYSQL_DATABASE"];
$db_username="root"; //$_ENV['MYSQL_USER'];
$db_password=""; //$_ENV["MYSQL_PASSWORD"];

//skapa en global variabel som är nåbar i alla funktioner.
global $db;
try{
    $db= new PDO("mysql:host=$db_server;dbname=$db_database;charset=utf8",
    $db_username, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
}
catch(PDOException$e){
    http_response_code(500);
    echo'{"error": true, "message": "'.json_encode($e-> getMessage()).'"}';
}
?>