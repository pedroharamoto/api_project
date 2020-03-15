<?php
//
// file created by Pedro Haramoto on 14/03/2020
// this file sets all the user/login actions
//
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *"); // allow all the methods
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//
include_once 'database/database_config.php';
include_once 'objects/object_user.php';
//
$database   = new Database();
$db         = $database->getConnection();
//
$user       = new User($db);
// captures the posted data
$data   = json_decode(file_get_contents("php://input"));
//
$method = $_SERVER['REQUEST_METHOD'];
// setting user property values
$user->user_name        = $data->user_name;
$user->user_email       = $data->user_email;
$user->user_password    = $data->user_password;
//
// the following code defines the actions
/*
according to the .htaccess{
    action = 1 => New user;
    action = 2 => Return all the users;
    action = 3 => return the specified iduser
    action = 4 => edit the specified iduser
    action = 5 => delete the specified iduser
    action = 6 => count how many times the specified iduser drank water
    action = 7 => login
}
*/
//
// New User
if( ($user->user_name) && ($user->user_email) && ($user->user_password) && ($user->newUser()) ){
    // if the conditions are true, then the user will be created
    http_response_code(200); // OK
    echo json_encode(array("message" => "User " . $user->user_email . " was created."));
}
else {
    http_response_code(400); // Error
    //
    echo json_encode(array("message" => "It was not possible to register a new user."));
}
?>
