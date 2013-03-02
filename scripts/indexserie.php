<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ajax Auto Suggest</title>
</style> 
<script type="text/javascript" src="jquery-1.2.1.pack.js"></script>
<script type="text/javascript">
	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("rpcserie.php", {queryString: ""+inputString+""}, function(data){
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
		scrollbar-base-color:#000000; 
scrollbar-3dlight-color:#000000; 
scrollbar-arrow-color:#000000; 
scrollbar-darkshadow-color:#000000; 
scrollbar-face-color:#000000; 
scrollbar-highlight-color:#000000; 
scrollbar-shadow-color:#000000; 
scrollbar-track-color:#000000; 
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		z-index:3;
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
 z-index:3;
}

</style>

</head>

<body>


	<div id="div-1a">
		<form id="Testform" action="addserie.php" target="film" method = 'get'>
			<div>
			<fieldset style='border-radius: 6px; background: black;'>
			<legend style='color:yellowgreen; background-color: black; border: 10px;'>Volltextsuche</legend>
				<input type="text" size=20% value="" id="inputString" onkeyup="lookup(this.value);" onblur="fill();" name="friends" autocomplete="off"/>
				<input type = 'submit'  name = 'submit3' value = 'Go' hidden>
				<a href='../index.html' target="_top">Filme</a>
			</div>
			</fieldset>
			<div class="suggestionsBox" id="suggestions" style="position:absolute; display: none;">
				<img src="../images/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList">
					&nbsp;
				</div>
			</div>
		</form>
	</div>

<br>
<?php
echo "<img style='position:absolute; top:0px; left:0px; z-index:0; position:fixed;' src=../images/back.jpg width='500' height='90'>";
echo "<br>";
echo "<br>";
echo "<br>";
$movienr="0";
//Verbinde Datenbank
include 'config.php';
 mysql_query("SET NAMES 'utf8'");
$sql = "SELECT * FROM tvshow ORDER BY `c00` ASC";
 
$db_erg = mysql_query( $sql );
if ( ! $db_erg )
{
  die('Ungültige Abfrage: ' . mysql_error());
}

//echo "<table border='1' style='position:absolute; z-index:-62;'>"; 
while ($zeile = mysql_fetch_array( $db_erg, MYSQL_ASSOC))
{

$movienr++;
  echo "<tr>";
  $movie=$zeile['c12'];
  $moviename=$zeile['c00'];
 // $moviename=utf8_decode($moviename);
$file="http://thetvdb.com/api/EABE49B30EC05867/series/$movie/de.xml";
echo "<br>";

if (file_exists("../banners/thm_".$movie."_small.jpg")) { } else {
//include 'serie.php';

		$dst = $path.'./zip/info.zip';
		file_put_contents($dst, file_get_contents("http://www.thetvdb.com/api/EABE49B30EC05867/series/$movie/all/en.zip"));

		$za = new ZipArchive;
		$za->open($dst);
		$xml = $za->getFromName('banners.xml');
		$za->close();

		$sx = simplexml_load_string($xml);
		list($ban) = $sx->xpath("//Banners/Banner[BannerType='series']/BannerPath");
		$pi = pathinfo($ban);
		$series = basename($path);
		$endung = substr( strrchr($ban, '.'), 1);
		if($endung=="jpg") {
		file_put_contents("../banners/thm_$movie.jpg",
			file_get_contents("http://www.thetvdb.com/banners/{$ban}"));
			
			$size = getimagesize("../banners/thm_$movie.jpg");
			$src_img = imagecreatefromjpeg("../banners/thm_$movie.jpg");
$dst_img = imagecreatetruecolor(252,46);
imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, 252, 46, $size[0], $size[1]);
imagejpeg($dst_img, "../banners/thm_".$movie."_small.jpg");
imagedestroy($src_img);
imagedestroy($dst_img);	
//echo "lösche ./banners/thm_$movie.jpg $series";
//unlink("./banners/thm_$movie.jpg");	
		}
		else 
		{
		file_put_contents("../banners/thm_$movie.png",
			file_get_contents("http://www.thetvdb.com/banners/{$ban}"));
			}
		

		
			
			
			
}



//echo "&nbsp;<img src='./banners/thm_".$movie."_small.jpg' width='252' height='46'/>"; 


if (file_exists("../banners/thm_".$movie."_small.jpg")) {

echo "<a href='addserie.php?friends=$movie' target='film'><img src='../banners/thm_".$movie."_small.jpg' width='252' height='46'/></a><br>";
echo "<img src='images/spacer.jpg' width='1' height='3' alt=''>";
} else {
echo "<a href='addserie.php?friends=$movie' target='film'><img src='../banners/thm_".$movie.".png' width='252' height='46'/></a><br>";
echo "<img src='images/spacer.jpg' width='1' height='3' alt=''>";
}
 
}

 echo "</div>";
mysql_free_result( $db_erg );
?>
</body>
</html>
