<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'>
<style type="text/css">
body { font-family: 'Marcellus', serif; }
</style>

</head>
<body>
<br>
<body bgcolor="#000000" text="#ffffff">
<?php
$movie=$_REQUEST["friends"];
if($movie=="") {goto a;}

//Verbinde Datenbank
include 'config.php';
   
   
   
   $sql = "SELECT * FROM tvshow WHERE c12='$movie'"; 
   
   $db_erg = mysql_query( $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysql_error());
}


while ($zeile = mysql_fetch_array( $db_erg, MYSQL_ASSOC))
{
$idfile=$zeile['idFile'];


$sql = "SELECT * FROM movie WHERE c09='$movie'";

  $movie=$zeile['c12'];
  $movie2=str_replace('tt', '', $movie);
  $filename="../banners/thm_".$movie.".jpg";
  	$title=$zeile['c00'];
//	echo "&nbsp;&nbsp;&nbsp;$title</h1>($movie)<h1>";
	$tileleng = strlen($title);
	if($tileleng<="15") {$fontsize="360%";} else {$fontsize="180%";}
	if($tileleng<="32") {$fontsize="250%";} else {$fontsize="180%";}
  if (file_exists($filename)) {
  include 'uploadformserie2.php';
    echo "&nbsp;<img src=$filename width='758' height='140'>"; 
echo "<br>";
	echo "<span style='font-size:$fontsize'>&nbsp;$title</span><span style='font-variant:small-caps'>&nbsp;&nbsp;(tvdb$movie)</span>";
} else {

  
  
  if (file_exists($filename)) {include 'uploadformserie2.php';} else {
  include 'uploadformserie.php'; }
  
  
  
  
  
  echo "&nbsp;<img src=$filename width='758' height='140'>"; 
  echo "<br>";
  
  
  
  
  
  
  
  
  
  
  
	$title=$zeile['c00'];
	echo "<span style='font-size:$fontsize'>&nbsp;$title</span><span style='font-variant:small-caps'>&nbsp;&nbsp;($movie)</span>";
  echo "</h1>";
}
$dauer=$zeile['c11'];
$genre=$zeile['c14'];
$imrating=$zeile['c05'];

$imrating=str_replace('00000', '', $imrating);
$dauer= $dauer/60;

echo "<table border='1' bgcolor='#000000'>";
echo "<tr>";
echo "<td>Sender: $genre</td>
</tr><tr>
<td>Ausstrahlungsjahr: $imrating</td>
";
echo "</table><br>Inhaltsangabe:<br><br>";
  echo $zeile['c01'];

//  $oIMDB = new IMDB($movie);
//  $oIMDB->getPoster();
}

 
mysql_free_result( $db_erg );

a:











?>