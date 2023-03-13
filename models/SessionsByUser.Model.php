<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'Conexion.Model.php';
include '../classes/SessionClass.php';
$result = array();

//------- INPUT -----------------------
$idUser = $_POST['idUser'];
$idUser = ($idUser == '') ? 0 : $idUser;

$objCon = new ConexionModel();
$objCon->connect();

//SEARCH SESSIONS FOR A PARTICULAR USER
$query = "SELECT session_id, FROM_UNIXTIME(login_tstamp) as login_tstamp, FROM_UNIXTIME(logout_tstamp) as logout_tstamp, ip_address FROM sys_user_sessions WHERE user_id = ".$idUser." ORDER BY login_tstamp DESC";
$data = $objCon->query($query);
$objCon->disconnect();

foreach($data as $row){
    $objSession = new SessionClass();
    $objSession->session_id= $row['session_id'];
    $objSession->login_tstamp= $row['login_tstamp'];
    $objSession->logout_tstamp= $row['logout_tstamp'];
    $objSession->ip_address= $row['ip_address'];

    array_push($result, $objSession);
}

$response = json_encode($result);

echo $response;

?>