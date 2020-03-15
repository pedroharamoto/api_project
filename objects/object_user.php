<?php
// File created by Pedro Haramoto on 14/03/2020
//
// This file defines the user's class and its methods
//
class User{
    //
    private $conn;
    //
    public $user_id;
    public $user_name;
    public $user_email;
    public $user_password;
    //
    public function __construct($db){
        // tries de connection
        $this->conn = $db;
    }
    //
    // method to create a new user
    //
    public function newUser(){
        //
        // before we create a new user, it is necessary to verify if the email already exists.
        //
        if($this->existsUserByEmail()){
            //
            echo json_encode(array("message" => "It was not possible to insert a new row to database, because " . $this->user_email . " already exists."));
        }
        else{
            //
            $query = "  INSERT INTO user
                        SET
                            user_name       = :user_name,
                            user_email      = :user_email,
                            user_password   = :user_password
                    ";

            //prepares the query
            $stmt = $this->conn->prepare($query);
            // removing all the special characters
            $this->user_name        = htmlspecialchars(strip_tags($this->user_name));
            $this->user_email       = htmlspecialchars(strip_tags($this->user_email));
            $this->user_password    = htmlspecialchars(strip_tags($this->user_password));

            // bindind all the values to the query
            $stmt->bindParam(':user_name', $this->user_name);
            $stmt->bindParam(':user_email', $this->user_email);

            // hashing the password
            $password_hash = password_hash($this->user_password, PASSWORD_BCRYPT);
            $stmt->bindParam(':user_password', $password_hash);

            // execute the query, also check if query was successful
            if($stmt->execute()){
                return true;
            }
            echo json_encode(array("message" => "It was not possible to insert a new row to database"));
        }
    }
    //
    // Method to return all the users or the specific user
    //
    public function getUserById($id){
        // This function has a required parameter
        // If $id = 0, then all the users are returned
        // If $id != 0, then its returned the specified user, which is $id itself
        //
        $query = "SELECT * FROM user WHERE 1 ";
        //
        if($id){
            $query .= " AND user_id = " . $id;
        }
        //
        $stmt = $this->conn->prepare($query); // prepares the query
        $stmt->execute(); // executes the statement
        //
        $users_array = array(); // creates an array to store the user(s)
        //
        $row = $stmt->rowCount(); //counts how many user(s) the query has returned
        //
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
               //
               extract($row); // gets the iteration record
               //
               $user = array(
                   "user_id"         => $user_id,
                   "user_name"      => $user_name,
                   "user_email"     => $user_email,
                   "user_password"  => $user_password
               );
               //
               array_push($users_array,$user);
        }
        //
        return json_encode($users_array); //encodes the final array and return the encoded JSON
    }
    //
    public function existsUserByEmail(){
        //
        // This function will be searching the user by its email
        //
        $query = "SELECT * FROM user WHERE user_email = '" . $this->user_email . "' LIMIT 0,1";
        //
        $stmt = $this->conn->prepare($query); // prepares the query
        $stmt->execute(); // executes the statement
        //
        $row = $stmt->rowCount(); //counts how many user(s) the query has returned
        //
        if($row>0){
            // there is one user
            $row = $stmt->fetch(PDO::FETCH_ASSOC); // gets the iteration record
            // sets the values to object properties
            $this->user_id       = $row['user_id'];
            $this->user_name     = $row['user_name'];
            $this->user_password = $row['user_password'];
            //
            return true; // the user exists
        }
        //
        return false; //the user doesn't exist
    }
    //
    public function countTimesDrink(){
        //
        // this function will count how many times the user drank water
        //
        $query = "SELECT * FROM user_drink WHERE user_id = '" . $this->user_id . "'";
        //
        $stmt = $this->conn->prepare($query); // prepares the query
        $stmt->execute(); // executes the statement
        //
        $row = $stmt->rowCount(); //counts how many times
        //
        return $row; // times
    }
    //
    public function getAllUsers(){
        //
        // this funcion will return all the users
        //

    }
}
//


?>
