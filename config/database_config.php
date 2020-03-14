<?php
// File created by Pedro Haramoto on 14/03/2020
//
// This file defines the database's class
//

// Creating the Database Class
class Database{
    // Setting all the database's credentials
    private $host       = "localhost";
    private $db_name    = "api_mosyle";
    private $username   = "root";
    private $password   = "";
    public  $conn;
    //
    // Construct method to create the $db_name database, if it doesn't exist
    //
    public function __construct(){
        //
        $this->conn = null; //sets the public variable $conn as null in order to clean it

        try{
            //tries the connection
            // Using PDO in order to use an expection class that handles possible problems that may occur
            $this->conn = new PDO("mysql:host=".$this->host, $this->username, $this->password);
            $this->conn->exec("SET NAMES utf8");
            //
            $query  = "CREATE DATABASE " . $this->db_name; // SQL Query to create a database named by the public variable $db_name
            //
            $stmt   = $this->conn->prepare($query); // Prepares the query to execute it
            $stmt->execute(); //executes the query
        }
        catch(PDOException $exception){
            //if was not possible to connect to the database, then shows the following message
            echo "Connection to the " . $this->db_name . " has failed<br>Error: " . $exception->getMessage();
            //
        }
        //Connection successful
        return $this->conn;
    }
}

?>
