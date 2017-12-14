<?php
$menu=$_GET['menu'];
include("../sites/views/".$menu."/showtab.inc.php");
$id=$_GET['id'];
$db = new SQLite3('../data/joorgsqlite.db');
$markfield=$pararray['markfield'];
$status=$pararray['markyes'];
$markno=$pararray['markno'];
$sql="SELECT * FROM ".$pararray['dbtable']." WHERE ".$pararray['fldindex']."=".$id;
$results = $db->query($sql);
while ($row = $results->fetchArray()) {
  $arr=$row;
}
if ($arr["$markfield"]==$status) {
  $status=$markno;
}	
$sql="UPDATE ".$pararray['dbtable']." SET ".$markfield."='".$status."' WHERE ".$pararray['fldindex']."=".$id;
$query = $db->exec($sql);
//echo "<a href='showtab.php?menu=".$menu."'>zurueck</a>";
echo "<meta http-equiv='refresh' content='0; URL=showtab.php?menu=".$menu."'>";  
?>