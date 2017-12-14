<?php
include("bootstrapfunc.php");
include("grafikfunc.php");
$menu=$_GET[menu];
$idwert=$_GET[idwert];
bootstraphead();
bootstrapbegin("Grafik");
echo "<a class='btn btn-primary' href='showtab.php?menu=".$menu."&idwert=".$idwert."'>zurueck</a><br> ";
$grafik = $_GET['grafik'];
if ($grafik==1) {
  grafikanzeigen();
} else {
  grafikauswahl($menu,$idwert);
}
bootstrapend();
?>