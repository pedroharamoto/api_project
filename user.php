<?php
header("Access-Control-Allow-Origin: http://localhost/api_mosyle/api_project/");
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


?>
