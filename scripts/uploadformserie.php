<html>
<body>
<form action="./uploadserie.php" method="post" enctype="multipart/form-data">
   <p><span style='font-size:70%'>Kein Banner gefunden:<br></span>
	  <input type="file" onchange="this.form.submit()" name="userfile" id="file">
	  <input name='movie' value="<?php echo $movie; ?>" type=hidden readonly/>
</form>
</body>
</html>