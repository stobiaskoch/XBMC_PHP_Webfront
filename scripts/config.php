<?php

$dbhost = "localhost";
$dbuser = "xbmc";
$dbpass = "xbmc";
//Datenbankname normalerweise MyVideos75
$dbase = "MyVideos75";

$db_link = mysql_connect($dbhost, $dbuser, $dbpass);
$db_sel = mysql_select_db($dbase)
   or die("Auswahl der Datenbank fehlgeschlagen");
   
?>