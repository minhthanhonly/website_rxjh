<?php
// $myServer = "WIN-CLJ1B0GQ6JP";
// $myUser = "sa";
// $myPass = "Zaq@1234567890987123456zxc";
$myServer = "SOMEONE\SQLEXPRESS";
$myUser = "sa";
$myPass = "896584";
$myDB = "rxjhgame"; 
$dbhandlegame = odbc_connect("Driver={SQL Server Native Client 11.0};Server=$myServer;Database=$myDB;", $myUser, $myPass);//mssql_connect($myServer, $myUser, $myPass) or die("Couldn't connect to SQL Server on $myServer". mssql_get_last_message());


//Config kenh online
$kenh1 = true;
$kenh2 = false;
$kenh3 = false;
?>