
<?php
$output = shell_exec('sh whats.sh');

$label=json_decode($output, true);
echo "<font color='#9acd32'>";
$nowplay=$label[result][item][label];
$timeout="10000";
if($nowplay=="") {$nowplay="nothing"; $timeout="100000";}
echo "Now playing: $nowplay";
echo "</font>";


?>
<html>
<head>

</head>
<body>
<script type="text/javascript">
<!--
window.setTimeout('location.reload()',<?php echo $timeout; ?>);
//-->
</script>
</body>