<?php
include("bootstrapfunc.php");
include("importfunc.php");
//include("../data/config.inc.php");
include("../config.php");
$menu=$_GET['menu'];
//echo $menu."<br>";
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin($pararray['headline']);
echo "<h4>Import</h4>";
echo "<a href='showtab.php?menu=".$menu."' class='btn btn-primary btn-sm active' role='button'>Zurück</a>"; 
//$importpfad = $configarray['import'];
$import = $_GET['import'];
if ($import==1) {
  if (isset($_REQUEST['submit'])) { 
    importfunc($importpfad);
  } else {
    echo "Der Vorgang wurde abgebrochen.<br>"; 
    echo "<meta http-equiv='refresh' content='0; URL=showtab.php?menu=".$menu."'>";
  }  
} else {
  importabfrage($menu,$importpfad);
}  

bootstrapend();
?>