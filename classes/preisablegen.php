<?php
header("content-type: text/html; charset=utf-8");
session_start();
include("bootstrapfunc.php");
$menu=$_GET['menu'];
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin($pararray['headline']);
echo "<a href='../index.php'  class='btn btn-primary btn-sm active' role='button'>Menü</a> ";
echo "<a href='showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Liste</a> ";
$db = new SQLite3('../data/joorgsqlite.db');
$dbselarr = $_SESSION['DBSELARR'];
$dbselchk = $_SESSION['DBSELCHK'];
$count=sizeof($dbselarr);
echo "<br>";
for ( $x = 0; $x < $count; $x++ ) {
  $sql="SELECT * FROM ".$pararray['dbtable']." WHERE ".$pararray['fldindex']."=".$dbselarr[$x];
  $results = $db->query($sql);
  $row = $results->fetchArray(); 
  
  $sqlsearch="SELECT * FROM tblartikel WHERE fldBez='".$row['fldBez']."' AND fldOrt='".$row['fldOrt']."'";
  //$sqlsearch="SELECT * FROM tblartikel";
  //echo $sqlsearch."<br>";
  $ressearch = $db->query($sqlsearch);
  if ($rowsearch = $ressearch->fetchArray()) {
    $sqlpreis="UPDATE tblartikel SET fldPreis='".$row['fldPreis']."' WHERE fldindex=".$rowsearch['fldindex'];
  } else {
    $sqlpreis="INSERT INTO tblartikel (fldKonto,fldJN,fldAnz,fldBez,fldPreis,fldOrt) VALUES ('".$row['fldKonto']."','J',1,'".$row['fldBez']."','".$row['fldPreis']."','".$row['fldOrt']."')";	
  }
  //echo $sqlpreis."<br>";
  $db->exec($sqlpreis);
  
  echo "<div class='alert alert-success'>";
  $nr=$x+1;
  echo $nr.") ".$row['fldBez'].",".$row['fldOrt'].",".$row['fldPreis']."<br>";
  echo $sqlpreis."<br>";
  echo "</div>";
}
bootstrapend();
?>