<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'Conexion.Model.php';
include '../classes/UserClass.php';

$result = array();
$month = $_POST['month'] + 0;
$year = $_POST['year'] + 0;

//-------UNCOMMENT IF PAST MONTH IS REQUIRED-------------------//
// $date = date_create(date('Y-m-d'));
// $date1MBef = date_add($date,date_interval_create_from_date_string("-1 months"));
// $month = date_format($date1MBef,'m');
// $year = date_format($date1MBef,'Y');

//------------------------------------------------------------//

$objCon = new ConexionModel();
$objCon->connect();

//LIST OF USERS WHO LOGIN AT LEAST 3 TIMES A WEEK IN THE MONTH AND YEAR GIVED
$query= "SELECT t2.user_id, u.username, CONCAT( UPPER (LEFT(u.first_name,1)), '.', u.surname) as user_names, SUM(t2.week_number)".
        "FROM (".
            "SELECT  t.user_id, ".
                    "COUNT(t.user_id), ".
                    "CASE ".
                        "WHEN t.login_tstamp < 8 THEN 1 ".
                        "WHEN t.login_tstamp BETWEEN 8 AND 14 THEN 2 ".
                        "WHEN t.login_tstamp BETWEEN 15 AND 21 THEN 3 ".
                        "WHEN t.login_tstamp > 21 THEN 4 ".
                        "END as week_number ".
            "FROM ( ".
                "SELECT user_id, session_id, ( FROM_UNIXTIME(login_tstamp,'%d') + 0)as login_tstamp, FROM_UNIXTIME(logout_tstamp)as logout_tstamp, ip_address ".
                "FROM sys_user_sessions ".
                "WHERE ". 
                    "FROM_UNIXTIME(login_tstamp,'%m') = ".$month. 
                    " AND FROM_UNIXTIME(login_tstamp,'%Y') = ".$year.
            " ) as t ".
            "GROUP BY t.user_id, week_number ".
            "HAVING COUNT(t.user_id) > 2 ".
        ") as t2 ".
        "INNER JOIN sys_users u ON t2.user_id = u.id ".
        "GROUP BY t2.user_id ".
        "HAVING SUM(t2.week_number) = 10";

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