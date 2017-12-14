<?php
include("bootstrapshowfunc.php");
include("../config.php");
$id=$_GET['id'];
$db = new SQLite3('../data/joorgsqlite.db');
echo "<a href='../index.php' class='btn btn-primary btn-sm active' role='button'>Menü</a> "; 
echo "<a href='filemanager.php?menu=filemanager&id=".$id."' class='btn btn-primary btn-sm active' role='button'>zurück</a> "; 
bootstraphead();
bootstrapbegin("Bilderschau");
$httppfad="http://localhost";
$www="/var/www/html";
$pfad=$_GET['pfad'];
//$pfad="/var/www/html/daten/bilder/Chris_handy/2016/";
$verz = dir ($pfad);
$pfad = str_replace($www,$httppfad,$pfad);

while ( $entry = $verz->read () )
{
//  echo $entry;	
  $lWeiter=true;	
  if (($entry==".") OR ($entry=="..")) {
	  $lWeiter=false;
  }
  if ($lWeiter==true) {
  	 if (substr($entry,-4)!=".jpg") {
      $lWeiter=false;  	 	
  	 }
  }
  if ($lWeiter==true) {
    $filename=$pfad.$entry;	
    $sql = "SELECT * FROM tblbilder WHERE fldfilename='".$filename."'";
    $results = $db->query($sql);
    $bez="";
    if ($row = $results->fetchArray()) {
    	$bez=$row['fldbez'];
    }
    echo "<div class='image'>";
    echo "<table>";
    echo "<tr><td><a rel='gallery' title='Frieda' href='".$filename."'> <img src='".$filename."' height='100' width='auto'> </a></td></tr>";
    echo "<tr><td>".$entry."</td></tr>";
    echo "<tr><td>".$bez."</td></tr>";
    echo "</table>";
    echo "</div>";
  }
}
bootstrapend();
?>
