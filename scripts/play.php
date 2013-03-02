<?php
$play=$_REQUEST["play"];
$play=str_replace("%20", " ", $play);
$play='"'.$play.'"';
//echo $play;
$output = shell_exec("sh play.sh $play");
echo $output;

?>

<html>
<head>
<script LANGUAGE="JavaScript"> 
setTimeout("self.close();", 0);	 //3 sek = 3000 millisek 
</script>  

</head>
<body>
<form>

</form>
</body>
