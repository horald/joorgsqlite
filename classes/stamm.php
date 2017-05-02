<?php
include("bootstrapfunc.php");
include("stammfunc.php");
$menu=$_GET['menu'];
//echo $menu."=menu<br>";
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin($pararray['headline']);
echo "<a href='showtab.php?menu=".$menu."' class='btn btn-primary btn-sm active' role='button'>Zurück</a>"; 
$stamm = $_GET['stamm'];
//$idwert = $_GET['id'];
if ($stamm==1) {
  stammuebernehmen();
} else {
  stammauswahl($menu);
}  
bootstrapend();
?>