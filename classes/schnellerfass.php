<?php
include("bootstrapfunc.php");
include("schnellerfassfunc.php");
include("../config.php");
$menu=$_GET['menu'];
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin($pararray['headline']);
$schnellerfass = $_GET['schnellerfass'];
if ($schnellerfass==1) {
  $submit=$_POST['submit'];
  $key=$_POST['key'];
  $keyvalue=$_POST[$key];
  $keyort=$_POST['ort'];
  $ortvalue=$_POST[$keyort];
  $show = $_POST['chkanzeigen'];
  $savetyp = $_POST['savetyp'];
  schnellerfass_verarbeiten($pararray,$listarray,$submit,$key,$keyvalue,$keyort,$ortvalue,$show,$autoinc_start,$autoinc_step,$menu,$savetyp);
  schnellerfass_abfrage($listarray,$menu,$savetyp);  
} else {
  $savetyp="Hinzufügen";	
  schnellerfass_abfrage($listarray,$menu,$savetyp);  
}
bootstrapend();
?>