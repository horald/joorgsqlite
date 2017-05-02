<?php

function stammauswahl($menu) {
  $db = new SQLite3('../data/joorgsqlite.db');
  $results = $db->query("SELECT * FROM tblartikel WHERE fldJN='J' ORDER BY fldOrt,fldBez");
  echo "<form class='form-horizontal' method='post' action='stamm.php?stamm=1&menu=".$menu."'>";
  //echo "<input type='hidden' name='id' value=".$idwert.">";
  echo "<table class='table table-hover'>";
  echo "<tr>";
  echo "<th>[]</th>";
  echo "<th>Bezeichnung </th>";
  echo "<th>Ort</th>";
  echo "<th>Preis</th>";
  echo "</tr>";
  $cnt=0;
  while ($row = $results->fetchArray()) {
    $cnt=$cnt+1;
    echo "<tr>";
    echo "<input type='hidden' name='idwert".$cnt."' value=".$row[fldindex].">";
    echo "<td><input type='checkbox' name='check".$cnt."' value='1'></td>";
    echo "<td>".$row['fldBez']." </td>";
    echo "<td>".$row['fldOrt']."</td>";
    echo "<td>".$row['fldPreis']."</td>";
    echo "</tr>"; 
  }	
  echo "</table>";
  echo "<input type='hidden' name='count' value=".$cnt."/>";
  echo "<dd><input type='submit' value='Übernehmen' /></dd>";
  echo "</form>";
}

function stammuebernehmen() {
  $db = new SQLite3('../data/joorgsqlite.db');
  $count = $_POST['count'];
  $cnt=0;
  if ($count>0) {
    $datum = date("Y-m-d");
    for($zaehl = 1; $zaehl <= $count; $zaehl++) {
      $idcheck = $_POST['check'.$zaehl];
      if ($idcheck==1) {
	$cnt=$cnt+1;
        $idwert = $_POST['idwert'.$zaehl];
        $query = "SELECT * FROM tblartikel WHERE fldindex=".$idwert;
        //echo $query."<br>"; 
        $results = $db->query($query);
        while ($row = $results->fetchArray()) {
          $qryins="INSERT INTO tblEinkauf_liste (fldBez,fldort,fldanz,fldpreis,fldStatus,fldEinkaufDatum,fldKonto) VALUES('$row[fldBez]','$row[fldOrt]','$row[fldAnz]','$row[fldPreis]','offen','$datum','$row[fldKonto]')";
          //echo $qryins."=ins<br>"; 
          $db->exec($qryins);
       }	
      }
    }
    echo "<div class='alert alert-success'>";
    //echo $db->lastErrorMsg()."<br>";
    echo $cnt." Stammdaten wurden übernommen.";
    echo "</div>";
  }
}

?>