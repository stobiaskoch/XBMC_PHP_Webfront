<?php
   // Configuration - Your Options
      $allowed_filetypes = array('.JPG','.jpg','.gif','.bmp','.png'); // These will be the types of file that will pass the validation.
      $max_filesize = 524288; // Maximum filesize in BYTES (currently 0.5MB).
      $upload_path = '../banners/'; // The place the files will be uploaded to (currently a 'files' directory).
	  $movie=$_REQUEST["movie"];
   $filename = "thm_$movie.jpg"; // Get the name of the file (including file extension).
   $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
 
   // Check if the filetype is allowed, if not DIE and inform the user.
   if(!in_array($ext,$allowed_filetypes))
      die($filenmame);
 
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
      die('The file you attempted to upload is too large.');
 
   // Check if we can upload to the specified path, if not DIE and inform the user.
   if(!is_writable($upload_path))
      die('You cannot upload to the specified directory $upload_path, please CHMOD it to 777.');
 
   // Upload the file to your specified path.
   if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $filename))
{
		 $size = getimagesize("../banners/thm_$movie.jpg");
$src_img = imagecreatefromjpeg("../banners/thm_$movie.jpg");
$dst_img = imagecreatetruecolor(252,46);
imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, 252, 46, $size[0], $size[1]);
imagejpeg($dst_img, "../banners/thm_".$movie."_small.jpg");
imagedestroy($src_img);
imagedestroy($dst_img);	
}
      else{
         echo 'There was an error during the file upload.  Please try again.'; // It failed :(.
 }
 
echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>";
echo "<meta http-equiv='refresh' content='0;URL=addserie.php?friends=$movie'>";

?>