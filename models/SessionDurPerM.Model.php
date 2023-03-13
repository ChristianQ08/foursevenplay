<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'Conexion.Model.php';
include '../classes/SessionClass.php';
$result = array();

$month = $_POST['month'] + 0;
$year = $_POST['year'] + 0;

//-------UNCOMMENT IF PAST MONTH IS REQUIRED-------------------//
// $date = date_create(date('Y-m-d'));
// $date1MBef = date_add($date,date_interval_create_from_date_string("-1 months"));
// $month = date_format($date1MBef,'m');
// $year = date_format($date1MBef,'Y');

//------------------------------------------------------------//

//---THE MOST COMMON SESSION DURATIONS IN 30MIN BLOCKS FOR THE MONTH GIVED
$query = "SELECT t2.dif_hours, t2.dif_min, COUNT(t2.dif_hours) as sessions_cant ".
        "FROM( ".
            "SELECT  t.dif DIV 60 as dif_hours, ".
                    "CASE WHEN MOD((t.dif DIV 30),2) > 0 THEN 30 ".
                    "ELSE 0 END as dif_min, ".
                    "t.dif ".
            "FROM ".
               "( ".
                "SELECT TIMESTAMPDIFF(MINUTE,FROM_UNIXTIME(login_tstamp),FROM_UNIXTIME(logout_tstamp)) as dif ".
                "FROM sys_user_sessions ".
                "WHERE FROM_UNIXTIME(login_tstamp,'%m') = ".$month.
                   " AND FROM_UNIXTIME(login_tstamp,'%Y') = ".$year.
                " ) as t ".
            "WHERE t.dif > 29 ".
            ")as t2 ".
        "GROUP BY t2.dif_hours, t2.dif_min ".
        "ORDER BY t2.dif_hours ASC";
    
$objCon = new ConexionModel();
$objCon->connect();
$data = $objCon->query($query);
$objCon->disconnect();

foreach($data as $row){
    $objSession = new SessionClass();
    $objSession->session_cant= $row['sessions_cant'];
    $objSession->session_duration_h= $row['dif_hours'];
    $objSession->session_duration_m= $row['dif_min'];

    array_push($result, $objSession);
}

$response = json_encode($result);

echo $response;

?>