<?php
include("bootstrapfunc.php");
bootstraphead();
bootstrapbegin("Get Ortkurz");
$menu=$_GET['menu'];
echo "<a href='schnellerfass.php?menu=".$menu."' class='btn btn-primary btn-sm active' role='button'>Zurück</a>"; 

echo "<form class='form-horizontal' method='post' action='getortkurz.php?schnellerfass=1&menu=".$menu."'>";
echo "<input type='checkbox' name='chkanzeigen' value='anzeigen'> Speichern anzeigen<br>";
echo "<input type='submit' name='submit' value='OK' /></dd>";
echo "</form>";  


bootstrapend();
?>