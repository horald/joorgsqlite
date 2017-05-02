<?php
include("bootstrapfunc.php");
include("upgradefunc.php");
bootstraphead();
bootstrapbegin("Joorgportal<br>");
echo "<a href='../index.php' class='btn btn-primary btn-sm active' role='button'>Menü</a><br> "; 
$newvers=$_GET['newvers'];
$oldvers=$_GET['oldvers'];
$versdat=$_GET['versdat'];

echo "<div class='alert alert-warning'>";
echo "Aktualisierung wird eingespielt...";
echo "</div>";

//checktables($tablearray);
//checkupdatefiles($newvers,$oldvers);
updatetable($newvers);
updatedbversion($newvers,$versdat);
bootstrapend();
?>