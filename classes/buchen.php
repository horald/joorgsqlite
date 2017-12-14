<?php
include("bootstrapfunc.php");
include("buchenfunc.php");
$menu=$_GET['menu'];
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin("Buchen");
echo "<a href='showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";
echo "<a href='showtab.php?menu=ktosal'  class='btn btn-primary btn-sm active' role='button'>Buchführung</a><br><br>";
$buchen = $_GET['buchen'];
if ($buchen==1) {
  $inhaber = $_POST['inhaber'];	
  $art = $_POST['art'];	
  $datum = $_POST['datum'];
  $uhrzeit = $_POST['uhrzeit'];
  $chkktosum = $_POST['chkktosum'];
  $ort = $_POST['ort'];
  buchenfunc($menu,$pararray,$inhaber,$art,$timezonediff,$datum,$uhrzeit,$chkktosum,$ort);
} else {
  buchenauswahl($menu);
}  
bootstrapend();
?>