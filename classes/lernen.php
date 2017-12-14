<?php
include("bootstrapfunc.php");
include("lernenfunc.php");
$menu=$_GET['menu'];
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin("Lernen");
echo "<a href='showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";
$lernen = $_GET['lernen'];
if ($lernen==1) {
  $sprache=$_POST['sprache'];
  $lektion=$_POST['lektion'];
  $muttersprache=$pararray['muttersprache'];
  $fremdsprache=$pararray['fremdsprache'];
  lernen($menu,$sprache,$lektion,$muttersprache,$fremdsprache);
} else {
  if ($lernen==2) {
    $vokabel=$_POST['vokabel'];
	 $fldindex=$_POST['fldindex'];
	 $sprache=$_POST['sprache'];
	 $lektion=$_POST['lektion'];
    $muttersprache=$pararray['muttersprache'];
  	 $fremdsprache=$pararray['fremdsprache'];
    ergebnis($menu,$vokabel,$fldindex,$sprache,$lektion,$muttersprache,$fremdsprache);
  } else {
    $muttersprache=$pararray['muttersprache'];
  	 $fremdsprache=$pararray['fremdsprache'];
    auswahl($menu,$muttersprache,$fremdsprache);
  }
}
bootstrapend();
?>
