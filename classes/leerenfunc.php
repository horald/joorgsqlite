<?php

function leereninput($menu) {
  echo "<form class='form-horizontal' method='post' action='leeren.php?leeren=1&menu=".$menu."'>";

  echo "<dl>";
  echo "<dt>Wirklich ALLES löschen?</dt>";
  echo "</dl>";
  echo "<input type='checkbox' name='chkanzeigen' value='anzeigen'> Löschen anzeigen<br>";

  echo "<dd><input type='submit' value='Löschen' /></dd>";
  echo "</form>";
}

function leerensave($pararray) {
  $db = new SQLite3('../data/joorgsqlite.db');
  $sql="DELETE FROM ".$pararray['dbtable'];
  $db->exec($sql);
  echo "<div class='alert alert-success'>";
  echo $sql."<br>";
  echo $db->lastErrorMsg()."<br>";
  echo "Alle Daten gelöscht.";
  echo "</div>";
}

?>