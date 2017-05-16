<?php
$menu=$_GET['menu'];
include("bootstrapfunc.php");
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin($pararray['headline']);
$id=$_GET['id'];
echo "<a href='showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Liste</a> ";
$db = new SQLite3('../data/joorgsqlite.db');
$sql="SELECT * FROM ".$pararray['dbtable']." WHERE ".$pararray['fldindex']."=".$id;
echo "<br>";
echo $sql."<br>";
$results = $db->query($sql);
$row = $results->fetchArray();
$sqlsearch="SELECT * FROM tblartikel WHERE fldBez='".$row['fldBez']."' AND fldOrt='".$row['fldOrt']."'";
//$sqlsearch="SELECT * FROM tblartikel";
echo $sqlsearch."<br>";
$ressearch = $db->query($sqlsearch);
if ($rowsearch = $ressearch->fetchArray()) {
  $sqlpreis="UPDATE tblartikel SET fldPreis='".$row['fldPreis']."', fldBarcode='".$row['fldBarcode']."' WHERE fldindex=".$rowsearch['fldindex'];
} else {
  $sqlpreis="INSERT INTO tblartikel (fldKonto,fldJN,fldAnz,fldBez,fldPreis,fldOrt,fldBarcode) VALUES ('".$row['fldKonto']."','N',1,'".$row['fldBez']."','".$row['fldPreis']."','".$row['fldOrt']."','".$row['fldBarcode']."')";	
}
echo $sqlpreis."<br>";
$db->exec($sqlpreis);
echo $db->lastErrorMsg()."<br>";
bootstrapend();
?>