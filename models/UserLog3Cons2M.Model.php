<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'Conexion.Model.php';
include '../classes/UserClass.php';

$result = array();
$month = $_POST['month'];
$year = $_POST['year'];

$date = date_create($year."-".$month."-01");
$date1MBef = date_add($date,date_interval_create_from_date_string("-1 months"));
$monthBef = date_format($date1MBef,'m');
$yearMBef = date_format($date1MBef,'Y');


//-------UNCOMMENT IF 2 PAST MONTHS IS REQUIRED-------------------//

// $date = date_create(date('Y-m-d'));

// $date1MBef = date_add($date,date_interval_create_from_date_string("-1 months"));
// $month = date_format($date1MBef,'m');
// $year = date_format($date1MBef,'Y');

// $date2MBef = date_add($date,date_interval_create_from_date_string("-1 months"));
// $monthBef = date_format($date2MBef,'m');
// $yearMBef = date_format($date2MBef,'Y');

//------------------------------------------------------------//

$objCon = new ConexionModel();
$objCon->connect();

//----------LIST OF USERS WHO LOGGED AT LEAST 3 CONSECUTIVE DAYS IN THE MONTH GIVED AND PREVIOUS
$query= "SELECT ".
        "t2.user_id,".
        "u.username, ".
        "CONCAT( UPPER (LEFT(u.first_name,1)), '.', u.surname) as user_names ".
        "FROM ".
            "(WITH t as ".
                "( ".
                "SELECT FROM_UNIXTIME(login_tstamp,'%Y-%m-%d') as date_login, user_id ".
                "FROM sys_user_sessions ".
                "WHERE (FROM_UNIXTIME(login_tstamp,'%m') = ".$month." AND FROM_UNIXTIME(login_tstamp,'%Y') = ".$year.") ".
                    "OR (FROM_UNIXTIME(login_tstamp,'%m') = ".$monthBef." AND FROM_UNIXTIME(login_tstamp,'%Y') = ".$yearMBef.") ".
                "GROUP BY date_login, user_id ".
                "ORDER BY CAST(date_login AS DATE) ASC ".
                ") ".
            "SELECT ".
                "date_login, ".
                "user_id, ".
                "CASE ".
                    "WHEN ADDDATE( date_login, -1) = LAG(date_login,1) OVER (PARTITION BY user_id ORDER BY date_login) ".
                    "THEN  1 ".
                    "ELSE  0 ".
                "END as 1_day, ".
                "CASE ".
                    "WHEN ADDDATE( date_login, -2) = LAG(date_login,2) OVER (PARTITION BY user_id ORDER BY date_login) ".
                    "THEN  1 ".
                    "ELSE  0 ".
                "END as 2_day ".
            "FROM t ".
        ") as t2 ".
        "INNER JOIN sys_users u ON t2.user_id = u.id ".
        "WHERE t2.1_day = 1 AND t2.2_day = 1 ".
        "GROUP BY u.username, user_names ".
        "ORDER BY u.username";

$data = $objCon->query($query);
$objCon->disconnect();

foreach($data as $row){
    $objUser = new UserClass();
    $objUser->id= $row['user_id'];
    $objUser->username= $row['username'];
    $objUser->user_names= $row['user_names'];
    array_push($result, $objUser);
}
$response = json_encode($result);

echo $response;

?>