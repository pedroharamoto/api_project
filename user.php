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
require "vendor/autoload.php";
use \Firebase\JWT\JWT;
//
$database   = new Database();
$db         = $database->getConnection();
//
$user       = new User($db);
// captures the posted data
$data   = json_decode(file_get_contents("php://input"));
//
$method = $_SERVER['REQUEST_METHOD'];
//
/*
//
//
//
// setting user property values
//
//
//
*/
if( ($method) == "POST"){
    //
    $user->user_name        = $data->user_name;
    $user->user_email       = $data->user_email;
    $user->user_password    = $data->user_password;
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
}
else{
    if(($method) == 'GET'){
        //
        /*
        //
        //
        //
        // get userid and users list
        //
        //
        //
        */
        if($_GET["iduser"]){
            // if exists an iduser, then
            // Get a iduser using token as HEADER
            //
            $headers = apache_request_headers();
            //
            $jwt=isset($headers['token']) ? $headers['token'] : "";
            //
            // if jwt is not empty
            if($jwt){
                //
                // all the tokens definitions are in "database/database_config.php"
                // such as $key, $iss...
                //
                try {
                    // decode jwt
                    $decoded = JWT::decode($jwt, $key, array('HS256'));
                    // set response code
                    http_response_code(200);
                    //
                    if($user->getUserById($_GET['iduser'])){
                        // if it is true, then a user has been found
                        // show user informations
                        echo json_encode(array(
                            "message" => "Clear to go.",
                            "data" => $user
                        ));
                    }
                    else{
                        echo json_encode(array(
                            "message" => "User " . $_GET['iduser'] . ' was not found'
                        ));
                    }
                }
                catch (Exception $e){
                    // set response code
                    http_response_code(401);
                    // tell the user access denied, then an error message is shown
                    echo json_encode(array(
                        "message" => "Access denied.",
                        "error" => $e->getMessage()
                    ));
                }
            }
        }
        else{
            //
            // get all users
            //
            $headers = apache_request_headers();
            //
            $jwt=isset($headers['token']) ? $headers['token'] : "";
            //
            // if jwt is not empty
            if($jwt){
                //
                // all the tokens definitions are in "database/database_config.php"
                // such as $key, $iss...
                //
                try {
                    // decode jwt
                    $decoded = JWT::decode($jwt, $key, array('HS256'));
                    // set response code
                    http_response_code(200);
                    // show users
                    echo json_encode(array(
                        "message" => "Clear to go.",
                        "data" => $user->getAllUsers()
                    ));
                }
                catch (Exception $e){
                    // set response code
                    http_response_code(401);
                    // tell the user access denied, then an error message is shown
                    echo json_encode(array(
                        "message" => "Access denied.",
                        "error" => $e->getMessage()
                    ));
                }
            }
            //
        }
    }
    if($method == 'PUT'){
        /*
        //
        //
        //
        // Edit an user
        //
        //
        //
        */
        $user->user_name        = $data->user_name;
        $user->user_email       = $data->user_email;
        $user->user_password    = $data->user_password;
        //
        if($_GET["iduser"]){
            // if exists an iduser, then
            // Get a iduser using token as HEADER
            //
            $headers = apache_request_headers();
            //
            $jwt=isset($headers['token']) ? $headers['token'] : "";
            //
            // if jwt is not empty
            if($jwt){
                //
                // all the tokens definitions are in "database/database_config.php"
                // such as $key, $iss...
                //
                try {
                    // decode jwt
                     $decoded = JWT::decode($jwt, $key, array('HS256'));
                     // set response code
                     http_response_code(200);
                     //
                     //
                     // verifying if the update requisition is from the correct user
                     //
                     if($_GET["iduser"] == $decoded->data->user_id){
                         //
                         // before editting the user register, it is necessary to verify if the user is trying to change to an existing email
                         //
                         if($user->updateUser($_GET["iduser"])){
                             //
                             echo json_encode(array(
                                 "message" => "Update done.",
                             ));
                         }
                     }
                     else{
                         echo json_encode(array(
                             "message" => "You're trying to edit an account that doens't belong to you!",
                         ));
                     }
                }
                catch (Exception $e){
                    // set response code
                    http_response_code(401);
                    // tell the user access denied, then an error message is shown
                    echo json_encode(array(
                        "message" => "Access denied.",
                        "error" => $e->getMessage()
                    ));
                }
            }
        }
    }
}

?>
