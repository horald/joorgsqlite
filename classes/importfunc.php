<?php

function importfunc($importpfad) {
  $count = $_POST['count'];
  //$ktotyp = $_POST['ktotyp'];
  //echo "=ktotyp<br>";
  if ($count>0) {
    for($zaehl = 1; $zaehl <= $count; $zaehl++)
    {
      $idcheck = $_POST['cbutton'.$zaehl];
      if ($idcheck==1) {
        $db = new SQLite3('../data/joorgsqlite.db');
        $cnt=$cnt+1;
        $datei = $_POST['idwert'.$zaehl];
        //$lines = file($importpfad.$datei);
        $handle = fopen($importpfad.$datei,"r");
        $cnt=0;
        //foreach ($lines as $line_num => $textline) {
        //  $cnt=$cnt+1;
        //  echo $textline."<br>";
        //  $db->exec($textline);
        //}
        while (($textline = fgets($handle)) !== false) {
        // process the line read.
          $cnt=$cnt+1;
          echo $textline."<br>";
        
        }
        fclose($handle);

        echo "<div class='alert alert-success'>";
        echo $importpfad.$datei."<br>"; 
        echo $cnt." Daten werden importiert.";
        echo "</div>";

      }
    }
  }
}

function importabfrage($menu,$importpfad) {
  //echo "import";
  $pfad = $importpfad;
  //echo "Pfad:".$pfad."<br>";
  $verz = dir ( $pfad );
  echo "<div class='alert alert-info'>";
  echo "Importpfad:".$pfad;
  echo "</div>";
  echo "<form method='post' action='import.php?import=1&menu=".$menu."'>";

  $db = new SQLite3('../data/joorgsqlite.db');
  $fquery = "SELECT * FROM tblktotyp";
  $fresult = $db->query($fquery);
  echo "<select name='ktotyp' size='1'>";
  while ($fline = $fresult->fetchArray()) {
    $strindex = $fline[fldindex];
    $strbez = $fline[fldbez];
    echo "<option style='background-color:#c0c0c0;' value=".$strindex." >".$strbez."</option>";
  }
  echo "</select>";

  echo "<table class='table table-hover'>";
  echo "<thead>";
  echo "<th width='5'><input type='checkbox' name='cbuttonAll' value='1'></th>";
  echo "<th>Datei</th>";
  echo "</thead>";  
  $count = 0;
  while ( $entry = $verz->read () )
  {
    if (($entry!=".") AND ($entry!="..")) {
      $count = $count + 1; 
      echo "<tr>";
      echo "<input type='hidden' name='idwert".$count."' value=".$entry.">";
      echo "<td width='5'><input type='checkbox' name='cbutton".$count."' value='1'></td>";
      echo "<td>".$entry ."</td>";
      echo "</tr>";
    }  
  }
  echo "<input type='hidden' name='count' value=".$count."/>";
  echo "</table>";
  $verz->close ();
  echo "  <div class='form-actions'>";
  echo "     <button type='submit' name='submit' class='btn btn-primary'> Import </button>";
  echo "     <button class='btn'>Abbruch</button>";
  echo "  </div>";
  echo "</form>";

}

?>