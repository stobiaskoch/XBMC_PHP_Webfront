<?php

$dbhost = "localhost";
$dbuser = "USERNAME";
$dbpass = "PASSWORT";
//Datenbankname normalerweise MyVideos75
$dbase = "DATENBANK";

$db_link = mysql_connect($dbhost, $dbuser, $dbpass);
$db_sel = mysql_select_db($dbase)
   or die("Auswahl der Datenbank fehlgeschlagen");
   
?>