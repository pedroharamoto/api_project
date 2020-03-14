<?php
//
//File created by Pedro Haramoto on 14/03/2020
//
// This file sets the user registration

include_once 'database/database_config.php';
include_once 'objects/object_user.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$database   = new Database();
$db         = $database->getConnection();
//
$user       = new User();
echo "oi";



?>
