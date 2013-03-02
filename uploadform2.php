<html>
<body>
<form action="./upload.php" method="post" enctype="multipart/form-data">
   <p><span style='font-size:70%'>Cover ändern:<br></span>
	  <input type="file" onchange="this.form.submit()" name="userfile" id="file">
	  <input name='movie' value="<?php echo $movieid2; ?>" type=hidden readonly/>
	  <input name='movieold' value="<?php echo $movie2; ?>" type=hidden readonly/>
</form>
</body>
</html>