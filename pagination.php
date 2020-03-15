<?php
//
// file created by Pedro Haramoto on 15/03/2020
// this file sets all the optional requirements
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

//
// Top Drinker
//
$page   = (int)$_GET["page"]; //actual page
$qty    = (int)$_GET['qty']; //how many registers per page
//

//
echo json_encode($user->getListPagination($page,$qty));

?>
