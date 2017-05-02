<?php
include("bootstrapfunc.php");
include("insertfunc.php");
include("../config.php");
$menu=$_GET['menu'];
$menugrp=$_GET['menugrp'];
//echo $menu."<br>";
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin($pararray['headline']);
$insert = $_GET['insert'];
$idwert = $_GET['id'];
if ($insert==1) {
  $show = $_POST['chkanzeigen'];
  //insertsave($pararray,$listarray,$menu,$show,$autoinc_step,$autoinc_start,$menugrp,$autoinc_start,$timezonediff,$autoinc);
  insertsave($pararray,$listarray,$menu,$menugrp,$show,$autoinc_step,$autoinc_start,$timezonediff,$autoinc);
  if ($show<>"anzeigen") {
    echo "<meta http-equiv='refresh' content='0; URL=showtab.php?menu=".$menu."&menugrp=".$menugrp."'>";  
  }
} else {
  insertinput($listarray,$idwert,$menu,$menugrp);
}  
bootstrapend();
?>
