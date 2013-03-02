<?php
   // Configuration - Your Options
      $allowed_filetypes = array('.jpg','.gif','.bmp','.png'); // These will be the types of file that will pass the validation.
      $max_filesize = 524288; // Maximum filesize in BYTES (currently 0.5MB).
      $upload_path = '../posters/'; // The place the files will be uploaded to (currently a 'files' directory).
	  $movie2=$_REQUEST["movie"];
	  $movieold=$_REQUEST["movieold"];
	  if (file_exists("../posters/".$movieold.".jpg")) {
	  	  unlink("../posters/".$movieold.".jpg");
		 }
	  echo "../posters/".$movieold.".jpg";
	  
	  
   $filename = "$movie2.jpg"; // Get the name of the file (including file extension).
   $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
 
   // Check if the filetype is allowed, if not DIE and inform the user.
   if(!in_array($ext,$allowed_filetypes))
      die($filenmame);
 
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
      die('The file you attempted to upload is too large.');
 
   // Check if we can upload to the specified path, if not DIE and inform the user.
   if(!is_writable($upload_path))
      die('You cannot upload to the specified directory, please CHMOD it to 777.');
 
   // Upload the file to your specified path.
   if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $filename))
         echo ''; // It worked.
      else
         echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
 
 
echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>";
echo "<meta http-equiv='refresh' content='0;URL=add.php?friends=$movie2'>";

?>