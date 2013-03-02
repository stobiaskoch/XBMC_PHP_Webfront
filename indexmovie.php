<?php
//Zugriff nur von einem Rechner erlauben
//Falls nicht gewünscht, von hier ->
$ip=$_SERVER['REMOTE_ADDR'];
if($ip!="192.168.2.2") { goto a; }
//<- bis hier löschen

$filter=$_REQUEST["filter"];
if($filter=="720") {$x720="selected";}
if($filter=="1080") {$x1080="selected";}
if($filter=="xvid") {$xvid="selected";}
if($filter=="") {$filter="KeinFilter"; $xno="selected";}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ajax Auto Suggest</title>
</style> 
<script type="text/javascript" src="scripts/jquery-1.2.1.pack.js"></script>
<script type="text/javascript">
	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("rpc.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
					$('#Testform').submit();				
				}
						});
		}
	} // lookup
	
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		$('#Testform').submit();
		setTimeout("$('#suggestions').hide();", 200);
		$('#inputString').val(thisValue='');
	}
</script>

<style type="text/css">
	body {
		background-color:#000000;
		font-family: Helvetica;
		font-size: 15px;
		color: #000;
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		position: relative;
		left: 30px;
		margin: 10px 0px 0px 0px;
		width: 200px;
		background-color: #212427;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #000;	
		color: #fff;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
		
		
	}
	a:link { 
color:#FFFFFF;
text-decoration:none;
} 

a:visited { 
color:#FFFFFF;
text-decoration:none;
} 

a:active { 
color:#FFFFFF;
text-decoration:none;
} 

a:hover { 
color:#9acd32;
text-decoration:none;
} 

table {
background-color:#000000;
color:#FFFFFF;
 a:link    {color:black;}
 a:visited {color:black;}
 a:hover   {color:black;}
 a:active  {color:black;}
}
#div-1a {
 position:fixed;
 left:50;
}
#filter23 {
position:fixed;
 left:200;
 right:200;
}
</style>

</head>

<body>


	<div id="div-1a">
	
		<form id="Testform" action="add.php" target="film" method = 'get'>


				
			<div>
			
			<fieldset style='border-radius: 6px; background: black;'>
			<legend style='color:yellowgreen; background-color: black; border: 10px;'>Volltextsuche</legend>
				<input type="text" size=20% value="" id="inputString" onkeyup="lookup(this.value);" onblur="fill();" name="friends" autocomplete="off"/>
				<input type = 'submit'  name = 'submit3' value = 'Go' hidden>
				


				
				
				
				
				<a href='indexserie.html' target="_top">Serien</a>
			</div>
	
			</fieldset>
			
			<div class="suggestionsBox" id="suggestions" style="position:absolute; display: none; z-index:3;">

				<img src="images/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList">
					&nbsp;
					</div>
				</div>
		</form>
		<img src='images/spacer.jpg' width='1' height='6' alt=''>
										<div name="filterddd" style='position:absolute; z-index:-50;'>
				<form name="form1" action="index.php" method="post">
			<select name="filter" onchange="javascript:document.form1.submit();">
		<option <?php echo $xno; ?>>KeinFilter</option>	
		<option <?php echo $x720; ?>>720</option>
		<option <?php echo $x1080; ?>>1080</option>
		<option <?php echo $xvid; ?>>xvid</option>
    </select>
	<input type="submit" name="submitbutton" value="Speichern" hidden>
	</form>
	</div>	
	</div>


<br><br><br><br><br><br>

<?php
echo "<img style='position:absolute; top:0px; left:0px; z-index:-2; position:fixed;' src=images/back.jpg width='500' height='106'>";
$movienr="0";


//Verbinde Datenbank
include 'config.php';

//Umlaute der mySql-Datenbank?
mysql_query("SET NAMES 'utf8'");

//Filme holen:
$sql = "SELECT * FROM movie  ORDER BY `c00` ASC";
 
$db_erg = mysql_query( $sql );

if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysql_error());
}

//Tabelle erstellen
echo "<table width='300' border='1' style='position:absolute; z-index:-62;'>"; 
while ($zeile = mysql_fetch_array( $db_erg, MYSQL_ASSOC))
{
	$idfile=$zeile['idFile'];
	$sql2 = "SELECT * FROM streamdetails WHERE `idFile`='$idfile' AND `iStreamType`='0'";
 	$db_erg2 = mysql_query( $sql2 );
	if ( ! $db_erg )
{
		die('Ungültige Abfrage: ' . mysql_error());
}

//Codec auslesen
while ($zeile12 = mysql_fetch_array( $db_erg2, MYSQL_ASSOC))
{
	$codec=$zeile12['strVideoCodec'];
	$iVideoHeight=$zeile12['iVideoWidth'];
}

$sql = "SELECT * FROM movie WHERE c09='$movie'";

  $movie=$zeile['idMovie'];
  $codecpic="";
  if($iVideoHeight>="1279") {$codecpic="&nbsp;&nbsp;<img src='images/vres_720.png' width='34' height='14'>"; $codec2="720";}
  if($iVideoHeight>="1919") {$codecpic="&nbsp;&nbsp;<img src='images/vres_1080.png' width='34' height='14'>"; $codec2="1080";}
  if($iVideoHeight<="1278") {$codecpic="&nbsp;&nbsp;<img src='images/vcodec_div1.png' width='34' height='14'>"; $codec2="xvid";}
  $moviename=$zeile['c00'];
  
//Filter einstellen
  if($filter==$codec2) {
	$movienr++;
	echo "<tr>";
	echo "<td width='300' style='font-size:0.8em'; z-index='-99'>".$movienr.": <a href='add.php?friends=$movie' target='film'>$moviename</a>$codecpic</td>";
	echo "</tr>";
}

  if($filter=="KeinFilter") {
	$movienr++;
	echo "<tr>";
	echo "<td width='300' style='font-size:0.8em'; z-index='-99'>".$movienr.": <a href='add.php?friends=$movie' target='film'>$moviename</a>$codecpic</td>";
	echo "</tr>";
}}

echo "</table>";
 echo "</div>";
mysql_free_result( $db_erg );
goto b;
a:
echo "tschüss";
b:
?>
</body>
</html>
