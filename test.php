<?php 

if(isset($_POST['btn'])) {
	$pagename = stripslashes($_POST['text']);

	if(preg_match("/[!@^%\$()=?;+#\/*\[\]\{\}<>|,' -\"]/", $pagename)){
	 	echo $pagename." :yes!";
	}
	else {
	  echo $pagename." :no!";
	}

}

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Document</title>
 </head>
 <body>
 	<form action="test" method="POST">
 		<input type="text" name="text">
 		<input type="submit" value="submit" name="btn">
 	</form>
 </body>	
 </html>