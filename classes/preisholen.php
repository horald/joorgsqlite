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
  $sqlpreis="SELECT * FROM tblartikel WHERE fldBez = '".$row['fldBez']."' and fldOrt='".$row['fldOrt']."'";
  //echo $sqlpreis."<br>";
  $respreis = $db->query($sqlpreis);
  if ($rowpreis = $respreis->fetchArray()) {
    $sqlupdate="UPDATE ".$pararray['dbtable']." SET fldPreis=".$rowpreis['fldPreis']." WHERE ".$pararray['fldindex']."=".$dbselarr[$x];
    $db->exec($sqlupdate);
    echo "<div class='alert alert-success'>";
    $nr=$x+1;
    echo $nr.") ".$row['fldBez'].",".$row['fldOrt'].",".$rowpreis['fldPreis']."<br>";
    //echo $sqlupdate."<br>";
    echo "</div>";
  }
}
bootstrapend();
?>