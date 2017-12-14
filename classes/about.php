<?php
include("bootstrapfunc.php");
include("../config.php");
bootstraphead();
bootstrapbegin("Joorgportal - About<br>");
$sqlite=1;
$string = file_get_contents("../version.json");
$json_a = json_decode($string, true);
$versnr=$json_a['versnr'];
$versdat=$json_a['versdat'];
$getvers=$_POST['versnr'];

echo "<a href='../index.php' class='btn btn-primary btn-sm active' role='button'>Menü</a> "; 
$chkupdate="checkupdate.php";
if ($getvers<>"") {
  $chkupdate=$chkupdate."?getvers=".$getvers;
} else {
  echo "<script>"; 
  echo "  aboutvers_anfordern(); ";
  echo "</script>";
}
echo "<a href='".$chkupdate."' class='btn btn-primary btn-sm active' role='button'>Update prüfen</a> ";
echo "<a href='help.php' class='btn btn-primary btn-sm active' role='button'>Hilfe</a> ";

$pfad=$_SERVER['PHP_SELF'];
$pfad=substr($pfad,0,-9);
$pfad="http://".$_SERVER['SERVER_NAME'].$pfad."checkupdate.php";
$pfad=$_SERVER['PHP_SELF'];
$phppfad=getcwd();
$pfad=substr($pfad,0,-9);
$pfad="http://".$_SERVER['SERVER_NAME'].$pfad."checkconnection.php";
echo "<pre>";
echo "<table>";
echo "<tr><td>Stand</td>  <td>: ".$versdat."</td></tr>";
echo "<tr><td>Version</td><td>: ".$versnr."</td></tr>";
if ($getvers<>"") {
  echo "<tr><td>Neue Version</td><td>: ".$getvers."</td></tr>";
}
echo "<tr><td>Sourcecode unter</td><td>: <a href='https://github.com/horald/joorgsqlite' target='_blank'>github:joorgsqlite</a></td></tr>";
echo "<tr><td>Pfad</td><td>: ".$phppfad."</td></tr>";
echo "<tr><td>Computername</td><td>: ".php_uname()."</td></tr>";
echo "<tr><td>Autoinc-Start/dbsyncnr</td>  <td>: ".$autoinc_start."</td></tr>";
echo "<tr><td>Autoinc-Step</td>  <td>: ".$autoinc_step."</td></tr>";
echo "</table>";
echo "</pre>";
bootstrapend();
?>