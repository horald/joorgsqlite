<?php
include("bootstrapfunc.php");
include("updatefunc.php");
include("../config.php");
$menu=$_GET['menu'];
$menugrp=$_GET['menugrp'];
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin($pararray['headline']);
$update = $_GET['update'];
$idwert = $_GET['id'];
if ($update==1) {
  $chkpreis = $_POST['chkpreis'];
  $show = $_POST['chkanzeigen'];
  $resync = $_POST['resync'];
  updatesave($pararray,$listarray,$menu,$show,$chkpreis,$menugrp,$autoinc_start,$resync,$timezonediff,$autoinc);
  if ($show<>"anzeigen") {
    echo "<meta http-equiv='refresh' content='0; URL=showtab.php?menu=".$menu."&menugrp=".$menugrp."'>";  
  } 
} else {
  updateinput($pararray,$listarray,$idwert,$menu,$menugrp);
}  
bootstrapend();

?>