<?php
session_start();
header("content-type: text/html; charset=utf-8");

function buchenauswahl($menu) {
  $db = new SQLite3('../data/joorgsqlite.db');
  echo "<form class='form-horizontal' method='post' action='buchen.php?buchen=1&menu=".$menu."'>";
        $sql="SELECT * FROM tblktoinhaber";
        $results = $db->query($sql);
        echo "<table>";
        echo "<tr>";
        echo "<td><label >Kontoinhaber:</label></td>";
        echo "<td><select name='inhaber' size='1'>";
        echo "<option style='background-color:#c0c0c0;' >(ohne)</option>";
        while ($row = $results->fetchArray()) {
            echo "<option style='background-color:#c0c0c0;' >".$row['fldBez']."</option>";
        }
        echo "</select></td> ";
        echo "</tr>";
 
        echo "<tr>";
        echo "<td><label >Art:</label></td>";
        echo "<td><select name='art' size='1'>";
        echo "<option style='background-color:#c0c0c0;' >(ohne)</option>";
        echo "<option style='background-color:#c0c0c0;' >Bar</option>";
        echo "<option style='background-color:#c0c0c0;' >Einkauf</option>";
        echo "<option style='background-color:#c0c0c0;' >Lastschrift</option>";
        echo "</select></td> ";
        echo "</tr>";

        $sqlort="SELECT * FROM tblorte WHERE fldo01typ='FREMD'";
        $resort = $db->query($sqlort);
        echo "<tr>";
        echo "<td><label >Kaufort:</label></td>";
        echo "<td><select name='ort' size='1'>";
        echo "<option style='background-color:#c0c0c0;' >(ohne)</option>";
        while ($rowort = $resort->fetchArray()) {
            echo "<option style='background-color:#c0c0c0;' >".$rowort['fldBez']."</option>";
        }
        echo "</select></td> ";
        echo "</tr>";

        $default = date('Y-m-d');
        echo "<tr>";
        echo "<td><label >Datum:</label></td>";
        echo "<td><div class='input-group date form_date col-md-12' data-date='' data-date-format='yyyy-mm-dd' data-link-field='dtp_input2' data-link-format='yyyy-mm-dd'>";
        echo "<input class='form-control' size='8' type='text' name='datum' value='".$default."' >";
        echo "<span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span>";
        echo "</div></td>";
        echo "<input type='hidden' id='dtp_input2' value='' />";
        echo "</tr>";

        $default=date('H:i');
        echo "<tr>";
        echo "<td><label >Uhrzeit:</label></td>";
        echo "<td><input class='form-control' size='8' type='text' name='uhrzeit' value='".$default."' ></td>";
        echo "</tr>";


        echo "</table>";

  echo "<input type='checkbox' name='chkktosum' value='chkktosum' checked> Kontensumme erstellen<br>";
  echo " <input type='submit' value='Speichern' />";
  echo "</form>";

}

function buchenfunc($menu,$pararray,$inhaber,$art,$timezonediff,$datum,$uhrzeit,$chkktosum,$ort) {
  $dbselarr = $_SESSION['DBSELARR'];
  $count=sizeof($dbselarr);
  $db = new SQLite3('../data/joorgsqlite.db');
  echo "<br>";
  //$datum = date("Y-m-d");
  $Sumbetrag=0;
  if ($chkktosum) {
    $qrysum="SELECT sum(fldPreis*fldAnz) AS summe, fldKonto FROM tblEinkauf_liste WHERE fldOrt='".$ort."' and ".$pararray['strwhere']." GROUP BY fldKonto";
    $ressum = $db->query($qrysum);
    while ($rowsum = $ressum->fetchArray() ) { 
      $timestamp=$datum." ".$uhrzeit;
      $Betrag=sprintf("%.2f",$rowsum['summe']);
      $Sumbetrag=$Sumbetrag+$Betrag;
  	   $qrykto="SELECT * FROM tblktokonten WHERE fldKurz='".$rowsum['fldKonto']."'";
      $reskto = $db->query($qrykto);
      if ($rowkto = $reskto->fetchArray() ) { 
        $bez=$rowkto['fldBez']." ".$ort;
      }
      $qryins="INSERT INTO tblktosal (fldDatum,fldUhrzeit,fldBez,fldKonto,fldInhaber,fldBetrag,fldtimestamp,flddbsyncstatus) VALUES ('".$datum."','".$uhrzeit."','".$bez."','".$rowsum['fldKonto']."','".$inhaber."','-".$Betrag."','".$timestamp."','SYNC')";
      echo "<div class='alert alert-success'>";
      echo $qryins."<br>";
      echo "</div>";
      $db->exec($qryins);
    }
  } else {
    for ( $x = 0; $x < $count; $x++ ) {
      $timestamp = time();
      //$uhrzeit = date("H:i:s",$timestamp);
      $timestamp=$datum." ".$uhrzeit;
  	   $query="SELECT * FROM tblEinkauf_liste WHERE fldindex=".$dbselarr[$x];
 	   //echo $query."<br>";
      $results = $db->query($query);
      if ($row = $results->fetchArray() ) { 
        $Betrag=$row['fldAnz']*$row['fldPreis'];
        $Sumbetrag=$Sumbetrag+$Betrag;
        //$datum=$row['fldEinkaufDatum'];
        //$uhrzeit=$row['fldEinkaufUhrzeit'];
        $qryins="INSERT INTO tblktosal (fldDatum,fldUhrzeit,fldBez,fldKonto,fldInhaber,fldBetrag,fldtimestamp,flddbsyncstatus) VALUES ('".$datum."','".$uhrzeit."','".$row['fldBez']."','".$row['fldKonto']."','".$inhaber."','-".$Betrag."','".$timestamp."','SYNC')";
        echo "<div class='alert alert-success'>";
        echo $qryins."<br>";
        echo "</div>";
        $db->exec($qryins);
      } else {
        echo "<div class='alert alert-success'>";
        echo $db->lastErrorMsg()."<br>";
        echo $qryins."<br>";
        echo "</div>";
      }  
    }
  }  	
  if ($art=="Einkauf") {
      $qryins="INSERT INTO tblktosal (fldDatum,fldUhrzeit,fldBez,fldKonto,fldInhaber,fldBetrag,fldtimestamp,flddbsyncstatus) VALUES ('".$datum."','".$uhrzeit."','Einkauf','EINKAUF','".$inhaber."','".$Sumbetrag."','".$timestamp."','SYNC')";
      echo "<div class='alert alert-success'>";
      echo $qryins."<br>";
      echo "</div>";
      $db->exec($qryins);
  }
  if ($art=="Lastschrift") {
      $qryins="INSERT INTO tblktosal (fldDatum,fldUhrzeit,fldBez,fldKonto,fldInhaber,fldBetrag,fldtimestamp,flddbsyncstatus) VALUES ('".$datum."','".$uhrzeit."','Lastschrift ".$ort."','LASTSCHRIFT','".$inhaber."','".$Sumbetrag."','".$timestamp."','SYNC')";
      echo "<div class='alert alert-success'>";
      echo $qryins."<br>";
      echo "</div>";
      $db->exec($qryins);
  }
  echo "<div class='alert alert-success'>";
  echo $count." ausgewählte Daten gebucht.";
  echo "</div>";
}

?>