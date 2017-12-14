<?php
include("bootstrapfunc.php");
include("einmaleinsfunc.php");
$menu=$_GET['menu'];
bootstraphead();
bootstrapbegin("Einmaleins");
echo "<a href='../index.php'  class='btn btn-primary btn-sm active' role='button'>Menü</a> ";
$einmaleins = $_GET['einmaleins'];
if ($einmaleins==2) {
  $rechnung=$_POST['rechnung'];
  $eingabewert=$_POST['eingabewert'];
  $erg=$_POST['erg'];
  $rechenart=$_POST['rechenart'];
  ergebnis($menu,$rechenart,$rechnung,$eingabewert,$erg);
} else {
  if ($einmaleins==1) {
    $rechenart=$_POST['rechenart'];
  	 einmaleins($menu,$rechenart);
  } else {	
    auswahl($menu);
  }
}
bootstrapend();
?>