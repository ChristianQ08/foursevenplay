<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'Conexion.Model.php';
include '../classes/UserClass.php';
$result = array();

$objCon = new ConexionModel();
$objCon->connect();

//GET ALL USERS
$data = $objCon->query("SELECT id, username FROM sys_users ORDER BY username ASC");
$objCon->disconnect();

foreach($data as $row){
    $objUser = new UserClass();
    $objUser->id= $row['id'];
    $objUser->username= $row['username'];
    array_push($result, $objUser);
}
$response = json_encode($result);

echo $response;

?>