<?php
  $id=$_GET['id'];
  $pfad = urldecode($_GET['pfad']);
  $filename = urldecode($_GET['filename']);
  $pos = strpos($filename, '.');
  $prefix = substr($filename,0,$pos);
  $rpos=(strlen($filename)-$pos) * -1;
  $suffix = substr($filename,$rpos);
  $today = date('Y-m-d-H-i-s');
  $newfilename=$prefix."_".$today.$suffix;
  //echo $pfad."<br>";
  //echo $filename.",".$pos.",".$prefix.",".$rpos.",".$suffix.",".$newfilename."=TCopy<br>";
  if (!copy($pfad."//".$filename, $pfad."//".$newfilename)) {
    echo "copy $filename schlug fehl...\n";
  }
  echo "<meta http-equiv='refresh' content='0; URL=filemanager.php?menu=filemanager&id=".$id."'>";  
?>