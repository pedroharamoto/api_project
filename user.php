<?php
//
// file created by Pedro Haramoto on 14/03/2020
// this file sets all the user/login actions
//
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
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
// setting user property values
$user->user_name        = $data->user_name;
$user->user_email       = $data->user_email;
$user->user_password    = $data->user_password;
//
if( ($user->user_name) and ($user->user_email) and ($user->user_password) and ($user->newUser()) ){
    // if the conditions are true, then the user will be created
    echo json_encode(array("message" => "User " . $user->user_email . " was created."));
}
//
?>
