<?php
include("bootstrapfunc.php");
include("leerenfunc.php");
$menu=$_GET['menu'];
//echo $menu."<br>";
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin($pararray['headline']);
echo "<a href='showtab.php?menu=".$menu."' class='btn btn-primary btn-sm active' role='button'>Zurück</a>"; 
$leeren = $_GET['leeren'];
if ($leeren==1) {
  $show = $_POST['chkanzeigen'];
  leerensave($pararray);
  if ($show<>"anzeigen") {
    echo "<meta http-equiv='refresh' content='0; URL=showtab.php?menu=".$menu."'>";  
  }
} else {
  leereninput($menu);
}  
bootstrapend();
?>