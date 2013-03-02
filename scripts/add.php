<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'>
<style type="text/css">
body { font-family: 'Marcellus', serif; }
</style>
<script language="JavaScript"> 
<!-- 
//PopUp-Generator von http://www.dauerstress.de 
function Fenster1() 
{ 
 var breite=280; 
 var hoehe=150; 
 var positionX=((screen.availWidth / 2) - breite / 2); 
 var positionY=((screen.availHeight / 2) - hoehe / 2); 
 var url='stop.php'; 
 pop=window.open('','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,fullscreen=0,width='+breite+',height='+hoehe+',top=10000,left=10000'); 
 pop.blur(); 
 pop.resizeTo(breite,hoehe); 
 pop.moveTo(positionX,positionY); 
 pop.location=url; 
 }
//--> 
<!-- 
//PopUp-Generator von http://www.dauerstress.de 
function Fenster2(play) 
{ 
 var breite=280; 
 var hoehe=150; 
 var positionX=((screen.availWidth / 2) - breite / 2); 
 var positionY=((screen.availHeight / 2) - hoehe / 2); 
 var url='play.php?play='+play+''; 
 pop=window.open('','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,fullscreen=0,width='+breite+',height='+hoehe+',top=10000,left=10000'); 
 pop.blur(); 
 pop.resizeTo(breite,hoehe); 
 pop.moveTo(positionX,positionY); 
 pop.location=url; 
 }
 function Fenster3() 
{ 
 var breite=280; 
 var hoehe=150; 
 var positionX=((screen.availWidth / 2) - breite / 2); 
 var positionY=((screen.availHeight / 2) - hoehe / 2); 
 var url='./scripts/pause.php'; 
 pop=window.open('','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,fullscreen=0,width='+breite+',height='+hoehe+',top=10000,left=10000'); 
 pop.blur(); 
 pop.resizeTo(breite,hoehe); 
 pop.moveTo(positionX,positionY); 
 pop.location=url; 
 }
//--> 
</script> 
</head>
<body>
<br>
<body bgcolor="#000000" text="#ffffff">
<?php

$ip=$_SERVER['REMOTE_ADDR'];
if($ip!="192.168.2.2") { goto a; }
$movie=$_REQUEST["friends"];
$movieid2=$movie;

include_once '../imdb.class.php';
//Verbinde Datenbank
include 'config.php';
   
   
   
   $sql = "SELECT * FROM movie WHERE idMovie='$movie'"; 
   
   $db_erg = mysql_query( $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysql_error());
}


while ($zeile = mysql_fetch_array( $db_erg, MYSQL_ASSOC))
{
if($movie=="") {$idfile=$zeile['5'];} else {
$idfile=$zeile['idFile']; }
$sql = "SELECT * FROM streamdetails WHERE `idFile`='$idfile' AND `iStreamType`='0'";
 
$db_erg = mysql_query( $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysql_error());
}
 

while ($zeile12 = mysql_fetch_array( $db_erg, MYSQL_ASSOC))
{

$codec=$zeile12['strVideoCodec'];


}

$sql = "SELECT * FROM movie WHERE c09='$movie'";

  $movie=$zeile['c09'];
  $movie2=str_replace('tt', '', $movie);
  $filename="../posters/".$movie2.".jpg";
  $filename2="../posters/".$movieid2.".jpg";
  	$title=$zeile['c00'];
//	<h1>";
	$tileleng = strlen($title);
	if($tileleng<="15") {$fontsize="360%";} else {$fontsize="180%";}
	if($tileleng<="32") {$fontsize="250%";} else {$fontsize="180%";}
 

 if (file_exists($filename)) {
  include 'uploadform2.php';
    echo "&nbsp;<img src=$filename width='108' height='160'/>"; 
	echo "<span style='font-size:$fontsize'>&nbsp;$title</span><span style='font-variant:small-caps'>&nbsp;&nbsp;($movie)</span>";
	goto schluss;
} else {

	if (file_exists($filename2)) {
  include 'uploadform2.php';
  echo "&nbsp;<img src=$filename2 width='108' height='160'/>";
echo "<span style='font-size:$fontsize'>&nbsp;$title</span><span style='font-variant:small-caps'>&nbsp;&nbsp;($movie)</span>"; 
goto schluss; 
  }
  else
  {
      $oIMDB = new IMDB($movie);
  $oIMDB->getPoster();
  
  }
 
 if (file_exists($filename)) {
  include 'uploadform2.php';
    echo "&nbsp;<img src=$filename width='108' height='160'/>"; 
	echo "<span style='font-size:$fontsize'>&nbsp;$title</span><span style='font-variant:small-caps'>&nbsp;&nbsp;($movie)</span>";
	goto schluss;
	
} else {

	if (file_exists($filename2)) {

  include 'uploadform3.php';
  echo "<span style='font-size:$fontsize'>&nbsp;$title</span><span style='font-variant:small-caps'>&nbsp;&nbsp;($movie)</span>";
  echo "&nbsp;<img src=$filename2 width='108' height='160'/>";
  goto schluss;
  /*
  } 
  if (file_exists($filename)) {
  include 'uploadform2.php';
  echo "&nbsp;<img src=$filename width='108' height='160'/>";
  } 
  else {
  
  
  
  if (file_exists($filename2)) {
  include 'uploadform2.php';
  echo "&nbsp;<img src=$filename2 width='108' height='160'/>"; 
  }
  else
  {
 
  }
  
  
  }
  
  
  
  
  */
  
  
  
  
  
  
	$title=$zeile['c00'];
	echo "<span style='font-size:$fontsize'>&nbsp;$title</span><span style='font-variant:small-caps'>&nbsp;&nbsp;($movie)</span>";
  echo "</h1>";
}}}
schluss:
$dauer=$zeile['c11'];
$genre=$zeile['c14'];
$imrating=$zeile['c05'];
$trailer=$zeile['c19'];
$trailer=str_replace('plugin://plugin.video.youtube/?action=play_video&videoid=', 'http://www.youtube.com/watch?v=', $trailer);
if($trailer=="") {$trailer="http://www.google.de/#q=$title Trailer";}
$imrating=str_replace('00000', '', $imrating);
$dauer= $dauer/60;
$rating=$zeile['c12'];
if(strpos($rating,"Rated NC-17")!==false) {$fsk="<img src=../images/de_18.png width='29' hight='29'>";}
if(strpos($rating,"Rated R for")!==false) {$fsk="<img src=../images/de_16.png width='29' hight='29'>";}
if(strpos($rating,"Rated PG-13")!==false) {$fsk="<img src=../images/de_12.png width='29' hight='29'>";}
if(strpos($rating,"Rated 12")!==false) {$fsk="<img src=../images/de_12.png width='29' hight='29'>";}
if(strpos($rating,"Rated PG for")!==false) {$fsk="<img src=../images/de_6.png width='29' hight='29'>";}
if(strpos($rating,"Rated G for")!==false) {$fsk="<img src=../images/de_0.png width='29' hight='29'>";}
if($rating=="") {$fsk="<img src=../images/rating_not_rated.jpg width='29' hight='29'>";}
echo "<table border='1' bgcolor='#000000'>";
echo "<tr>";
echo "<td>Genre: $genre</td>
<td>Dauer: $dauer Min.</td><td>Codec: $codec</td>
</tr><tr>
<td>IMDB-Rating: $imrating</td>
<td><a href='$trailer' target='_blank'>Trailer</a>
</td>
<td>FSK: $fsk</td></td>";
echo "</table><br>Inhaltsangabe:<br><br>";
  echo $zeile['c01'];
//  $command="http://192.168.2.11/jsonrpc?request=";
  $play=$zeile['idMovie'];
  
  if($ip=="192.168.2.2") {
echo "<center><br><br><a href='#' onClick='Fenster2(\"".$play."\")'><img src=../images/PlayerPlay.png width='32' height='32'></a>";
echo "<a href='#' onClick='Fenster3()'><img src=../images/PlayerPause.png width='32' height='32'></a>"; 
echo "<a href='#' onClick='Fenster1()'><img src=../images/PlayerStop.png width='32' height='32'></a></center>"; 



}
}
 
mysql_free_result( $db_erg );

a:
echo "<iframe style='border: none;' src='whats.php'  scrolling='no' height='40' name='SELFHTML_in_a_box'></iframe>";












?>