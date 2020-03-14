<?php
header("Content-Type: application/json; charset=UTF-8");
// File created by Pedro Haramoto on 14/03/2020
//
// This file defines the database's class and its methods
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
            // Using PDO in order to use an exception class that handles possible problems that may occur
            $this->conn = new PDO("mysql:host=".$this->host, $this->username, $this->password);
            $this->conn->exec("SET NAMES utf8");
            //
            $query  = "CREATE DATABASE IF NOT EXISTS" . $this->db_name; // SQL Query to create a database named by the public variable $db_name
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
    //
    // This method gets the datebase connetion
    //
    public function getConnection(){
        //
        $this->conn = null; //sets the public variable $conn as null in order to clean it

        try{
            //tries the connection
            // Using PDO in order to use an expection class that handles possible problems that may occur
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);            $this->conn->exec("SET NAMES utf8");
            //
            $this->conn->exec("set names utf8");
        }
        catch(PDOException $exception){
            //if was not possible to connect to the database, then shows the following message
            echo "Connection to the " . $this->db_name . " has failed<br>Error: " . $exception->getMessage();
            //
        }
        //Connection successful
        return $this->conn;
    }
    //
    // This method creates the user table
    //
    public function createUserTable(){
        //
        $this->getConnection();
        //
        $query = "
                    CREATE TABLE IF NOT EXISTS `user` (
                      `user_id` int(11) NOT NULL AUTO_INCREMENT,
                      `user_name` varchar(250) NOT NULL,
                      `user_email` varchar(250) NOT NULL,
                      `user_password` varchar(2048) NOT NULL,
                      PRIMARY KEY (`user_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1;
        ";
        //
        $stmt = $this->conn->prepare($query); // Prepares the query to execute it
        $stmt->execute(); //executes the query
        //
    }
    //
    // This method creates the user table
    //
    public function createUserDrinkTable(){
        //
        $this->getConnection();
        //
        $query = "
                    CREATE TABLE IF NOT EXISTS `user_drink` (
                      `user_drink_id` int(11) NOT NULL AUTO_INCREMENT,
                      `user_id` int(11) NOT NULL,
                      `user_drink_ml` float NOT NULL,
                      `user_drink_date` timestamp NOT NULL DEFAULT current_timestamp(),
                      PRIMARY KEY (`user_drink_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1;

                    ALTER TABLE `user_drink`
                        ADD KEY `user_id` (`user_id`);

                    ALTER TABLE `user_drink`
                        ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

        ";
        //
        $stmt = $this->conn->prepare($query); // Prepares the query to execute it
        $stmt->execute(); //executes the query
        //
    }
    //
}

?>
