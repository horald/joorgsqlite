<?php
header("content-type: text/html; charset=utf-8");

function delfileinput() {
  $id=$_GET['id'];
  $pfad = urldecode($_GET['pfad']);
  $filename = urldecode($_GET['filename']);
  echo "<form class='form-horizontal' method='post' action='delfile.php?del=1&id=".$id."&pfad=".urlencode($pfad)."&filename=".urlencode($filename)."'>";

  echo "<dl>";
  echo "<dt>'".$filename."' wirklich löschen?</dt>";
  echo "</dl>";

  echo "<dd><input type='submit' value='Löschen' /> ";
  echo "<input type='submit' name='Abbruch' value='Abbrechen'></dd>";
  echo "</form>";
}

function delfiledelete() {
  $id=$_GET['id'];
  $pfad = urldecode($_GET['pfad']);
  $filename = urldecode($_GET['filename']);
  echo $pfad.$filename." wurde gelöscht.<br>";
  
  $old = getcwd(); // Save the current directory
  chdir($pfad);
  unlink($filename);
  chdir($old); // Restore the old working directory      
  
}

?>