<?php

$dbhost = "localhost";
$dbuser = "xbmc";
$dbpass = "xbmc";
$dbase = "MyVideos75";

$db_link = mysql_connect($dbhost, $dbuser, $dbpass);
$db_sel = mysql_select_db($dbase)
   or die("Auswahl der Datenbank fehlgeschlagen");
   
?>