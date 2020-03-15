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
//includes all jwt lib
require "vendor/autoload.php";
use \Firebase\JWT\JWT;
//
$database   = new Database();
$db         = $database->getConnection();
//
$user       = new User($db);
// capture the posted data
$data   = json_decode(file_get_contents("php://input"));
//
$method = $_SERVER['REQUEST_METHOD'];
// setting user property values
$user->user_email       = $data->user_email;
$user->user_password    = $data->user_password;
//
if( ($user->existsUserByEmail()) && (password_verify($data->user_password,$user->user_password)) ){
    //
    // the user exists and the verification is ok
    //
    // creating token
    //
    $token = array(
        "iss"   => $iss,
        "aud"   => $aud,
        "iat"   => $iat,
        "nbf"   => $nbf,
        "exp"   => $exp,
        "data"  => array(
            "user_id"       => $user->user_id,
            "user_name"     => $user->user_name,
            "user_email"    => $user->user_email,
            "user_password" => $user->user_password
        )
    );
    //
    http_response_code(200); // OK
    //
    $jwt = JWT::encode($token,$key);
    //
    echo json_encode(array(
        "message"       => "Login OK " . $user->user_name,
        "jwt"           => $jwt,
        "iduser"        => $user->user_id,
        "email"         => $user->user_email,
        "name"          => $user->user_name,
        "drink_counter" => $user->countTimesDrink()
    ));
}
else{
    //
    http_response_code(401); //ERROR
    //
    if(!($user->existsUserByEmail()))
        echo json_encode(array("message"   => "Login has failed. User doesn't exist"));
    else
        echo json_encode(array("message"   => "Login has failed. Wrong password"));

}

?>
