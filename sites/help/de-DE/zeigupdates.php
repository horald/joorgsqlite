<?php
echo "update<br>";

$pfad=$_SERVER['PHP_SELF'];
$pfad=substr($pfad,0,-17);
$pfad="http://".$_SERVER['SERVER_NAME'].$pfad;


	 echo $pfad."=path<br>";

//includes("updates/updateprot1.017.html");
//includes($pfad."/sites/help/de-DE/updates/updateprot1.018.php");
//includes($pfad."/sites/help/de-DE/updates/updateprot1.021.html");
?>