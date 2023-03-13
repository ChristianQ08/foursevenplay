<?php
// include "..\models\SessionsByUser.Model.php";
// include "..\models\UsersLogTTPerM.Model.php";
// include "..\models\Users.Model.php";
// include "..\models\UserLog3Cons2M.Model.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>47Play Reports</title>

    <link rel="icon" type="image/x-icon" href="../assets/img/Top-Logo.png">
    
    <!------------ DATATABLE - BOOTSTRAP ------------>
    <link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/> 
    <script type="text/javascript" src="../DataTables/datatables.min.js"></script>

    <!-- DATETIMEPICKER -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g==" crossorigin="anonymous" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js" integrity="sha512-L6Trpj0Q/FiqDMOD0FQ0dCzE0qYT2TFpxkIpXRSWlyPvaLNkGEMRuXoz6MC5PrtcbXtgDLAAI4VFtPvfYZXEtg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-2JBCbWoMJPH+Uj7Wq5OLub8E5edWHlTM4ar/YJkZh3plwB2INhhOC3eDoqHm1Za/ZOSksrLlURLoyXVdfQXqwg==" crossorigin="anonymous"></script>    
   
    <!-- ICON -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <script type="text/javascript" src="report.js"></script>
</head>
<body style="background-color: white;">
    <div class="container">
        <div class="row">
            <div class="form-group">
                <label for="select_reports">Reports</label>
                <select class="form-control" id="select_reports">
                    <option value="0"></option>
                    <option value="1">1- Sessions per User</option>
                    <option value="2">2- Users who login at least 3 times a week</option>
                    <option value="3">3- Common session durations in 30min blocks</option>
                    <option value="4">4- Users who logged at least 3 consecutive days</option>
                </select>
            </div>
        </div>
        <!-- REPORT 1 -->
        <div class="row col-9" id="div_usersSessByUsers" hidden="true">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="select_usersSessByUsers">Users</label>
                </div>
                <select class="custom-select col-3" id="select_usersSessByUsers">
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="searchSessByUsers">Search</button>
                </div>
            </div>
        </div>
        
        <div class="row" id="div_SessByUsers" hidden="true">
            <div class="col-9">
                <hr>
                <div class="card border-0">
                    <table id="table_SessByUsers" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>SESION ID</th>
                                <th>LOGIN</th>
                                <th>LOGOUT</th>
                                <th>IP ADDRESS</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END REPORT 1 -->
        
        <!-- REPORT 2 -->

        <div class="row" id="div_dateUserLog3PerW" hidden="true">
            <div class="form-group">
                <label for="dateUserLog3PerW">Period</label>
                <div class="input-group date" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" id="dateUserLog3PerW" data-target="#dateUserLog3PerW">
                    <div class="input-group-append" data-target="#dateUserLog3PerW" data-toggle="datetimepicker">
                        <div class="input-group-text"><span class="material-symbols-outlined">calendar_month</span></i></div>
                    </div>
                    <button type="button" class="btn btn-light" id="searchUserLog3PerW">Search</button>
                </div>
            </div>
        </div>
        <div class="row" id="div_UserLog3PerW" hidden="true">
            <div class="col-9">
                <div id="alertUserLog3PerW"></div>
                <hr>
                <div class="card border-0">
                    <table id="table_UserLog3PerW" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>USER ID</th>
                                <th>USERNAME</th>
                                <th>USER N.SURNAME</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END REPORT 2 -->

        <!-- REPORT 3 -->

        <div class="row" id="div_dateSDurPerM" hidden="true">
            <div class="form-group">
                <label for="dateSDurPerM">Period</label>
                <div class="input-group date" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" id="dateSDurPerM" data-target="#dateSDurPerM">
                    <div class="input-group-append" data-target="#dateSDurPerM" data-toggle="datetimepicker">
                        <div class="input-group-text"><span class="material-symbols-outlined">calendar_month</span></i></div>
                    </div>
                    <button type="button" class="btn btn-light" id="searchSDurPerM">Search</button>
                </div>
            </div>
        </div>
        <div class="row" id="div_SDurPerM" hidden="true">
            <div class="col-9">
                <div id="alertSDurPerM"></div>
                <hr>
                <div class="card border-0">
                    <table id="table_SDurPerM" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>CANT USER SESSIONS</th>
                                <th>DURATION HOURS</th>
                                <th>DURATION MINUTES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END REPORT 3 -->

        <!-- REPORT 4 -->

        <div class="row" id="div_dateUserLog3Cons2M" hidden="true">
            <div class="form-group">
                <label for="dateUserLog3Cons2M">Period</label>
                <div class="input-group date" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" id="dateUserLog3Cons2M" data-target="#dateUserLog3Cons2M">
                    <div class="input-group-append" data-target="#dateUserLog3Cons2M" data-toggle="datetimepicker">
                        <div class="input-group-text"><span class="material-symbols-outlined">calendar_month</span></i></div>
                    </div>
                    <button type="button" class="btn btn-light" id="searchUserLog3Cons2M">Search</button>
                </div>
            </div>
        </div>
        <div class="row" id="div_UserLog3Cons2M" hidden="true">
            <div class="col-9">
                <div id="alertUserLog3Cons2M"></div>
                <hr>
                <div class="card border-0">
                    <table id="table_UserLog3Cons2M" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>IDUSER</th>
                                <th>USERNAME</th>
                                <th>USER N.SURNAME</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END REPORT 4 -->
    </div>

</body>