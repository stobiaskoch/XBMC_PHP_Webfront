<html>
<body>
<form action="./upload.php" method="post" enctype="multipart/form-data">
   <p><p><span style='font-size:70%'>Kein Cover gefunden:<br></span>
	  <input type="file" onchange="this.form.submit()" name="userfile" id="file">
	  <input name='movie' value="<?php echo $movieid2; ?>" type=hidden readonly/>
   <p>
</form>
</body>
</html>