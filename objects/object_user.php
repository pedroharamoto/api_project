<?php
// File created by Pedro Haramoto on 14/03/2020
//
// This file defines the user's class and its methods
//
include_once '../database/database_config.php';
//
class User{
    //
    private $conn;
    //
    private $user_id;
    private $user_name;
    private $user_email;
    private $user_password;
    //
    public function __construct($db){
        // tries de connection
        $this->conn = $db;
    }
    //
    // Method to return all the users
    //
    public function getUser($id){
        // This function has a required parameter
        // If $id = 0, then all the users are returned
        // If $id != 0, then its returned the specified user, which is $id itself
        //
        $query = "SELECT user_id, user_name, user_email, user_password FROM user WHERE 1 ";
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
               extract($row); // gets the itaration record
               //
               $user = array(
                   "iduser"         => $user_id,
                   "user_name"      => $user_name,
                   "user_email"     => $user_email,
                   "user_password"  => $user_password
               );
               //
               array_push($users_array,$user);
        }
        //
        return json_encode($users_array); //encodes the final array and return the JSON
    }
}
$database   = new Database();
$db         = $database->getConnection();
$user       = new User($db);
$users      = $user->getUser(2);

echo ($users);

?>
