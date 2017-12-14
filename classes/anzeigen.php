<?php
header("content-type: text/html; charset=utf-8");
include("../config.php");
$pfad = urldecode($_GET['pfad']);
$pfad = str_replace($www,$httppfad,$pfad);
$datei=$_GET['filename'];
$filename = $pfad.urldecode($datei);
//echo $filename."<br>";
if (substr($filename,strlen($filename)-4)==".pdf") {
  header('Content-Type: application/pdf');
  $pdf = file_get_contents($filename);
  echo $pdf;
}
if (substr($filename,strlen($filename)-4)==".txt") {
  echo "<a href='".$filename."'>".$datei."</a>";
}
if (substr($filename,strlen($filename)-4)==".jpg") {
  echo "<img src='".$filename."' alt='".$datei."' height='100%' width='auto'>"; 
}

?>