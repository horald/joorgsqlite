<?php
include("../config.php");
$filename=$_GET['filename'];
$db = new SQLite3('../data/joorgsqlite.db');
echo "notiz:".$filename;
$menu="bilder";
echo "<meta http-equiv='refresh' content='0; URL=insert.php?menu=".$menu."&filename=".$filename."'>";  
?>