<?php

function stammauswahl($menu) {
  $db = new SQLite3('../data/joorgsqlite.db');
  $resflt = $db->query("SELECT * FROM tblfilter WHERE fldtablename='tblktosal' AND fldfeld='fldInhaber'");
  if ($rowflt = $resflt->fetchArray()) {
  	 //echo $rowflt['fldwert']."<br>";
    $resinh = $db->query("SELECT * FROM tblktoinhaber WHERE fldBez='".$rowflt['fldwert']."'");
    if ($rowinh = $resinh->fetchArray()) {
    	$inhind=$rowinh['fldindex'];
    	//echo $inhind."<br>";
    }	
  }	

  $sql="SELECT * FROM tblktostamm AS st,tblktostamm_zuord AS zu WHERE zu.fldid_ktoinhaber=".$inhind." AND st.fldindex=zu.fldid_ktostamm";
  //echo $sql."<br>";
  $results = $db->query($sql);
  echo "<form class='form-horizontal' method='post' action='stammbuchen.php?stamm=1&menu=".$menu."'>";
  //echo "<input type='hidden' name='id' value=".$idwert.">";
  echo "<table class='table table-hover'>";
  echo "<tr>";
  echo "<th>[]</th>";
  echo "<th>Konto </th>";
  echo "<th>Inhaber </th>";
  echo "<th>Betrag</th>";
  echo "</tr>";
  $cnt=0;
  while ($row = $results->fetchArray()) {
    $cnt=$cnt+1;
    echo "<tr>";
    echo "<input type='hidden' name='idwert".$cnt."' value=".$row[fldindex].">";
    echo "<td><input type='checkbox' name='check".$cnt."' value='1'></td>";
    echo "<td>".$row['fldBez']." </td>";
    echo "<td>".$row['fldInhaber']." </td>";
    echo "<td>".$row['fldBetrag']."</td>";
    echo "</tr>"; 
  }	
  echo "</table>";
  echo "<input type='checkbox' name='chkanzeigen' value='anzeigen'> Speichern anzeigen<br>";
  echo "<input type='hidden' name='count' value=".$cnt."/>";
  echo "<dd><input type='submit' value='Übernehmen' /></dd>";
  echo "</form>";
}

function stammuebernehmen($fldindex,$dbtable,$autoinc_start,$autoinc_step,$autoinc,$show,$timezonediff) {
  $db = new SQLite3('../data/joorgsqlite.db');
  
  if ($autoinc=="J") {
    $sqlid="SELECT * FROM tblindex WHERE fldtable='".$dbtable."'";
    $results = $db->query($sqlid);
    if ($row = $results->fetchArray()) {
      $newrowid=$row['fldid'] + $autoinc_step;
      //echo $newrowid."=newrowid<br>";
    } else {
      $newrowid=$autoinc_start;  
    }
  }
  
  $count = $_POST['count'];
  $cnt=0;
  //echo $count."=count<br>";
  if ($count>0) {
    $datum = date("Y-m-d");
    $timestamp = time();
    $uhrzeit = date("H:i",$timestamp);
    $qryflt = "SELECT * FROM tblfilter WHERE fldtablename='tblktosal'";
    $resflt = $db->query($qryflt);
    if ($rowflt = $resflt->fetchArray()) {
      $inhaber = $rowflt['fldwert'];
    } else {
      $inhaber = "(ohne)";
    }
    //echo "<br>".$inhaber."<br>";
    for($zaehl = 1; $zaehl <= $count; $zaehl++) {
      $idcheck = $_POST['check'.$zaehl];
      if ($idcheck==1) {
	     $cnt=$cnt+1;
        $idwert = $_POST['idwert'.$zaehl];

        if ($timezonediff<>"") {
          $timestamp="datetime('now', 'localtime','".$timezonediff."')";
        } else {  
          $timestamp="datetime('now', 'localtime')";
        }  

        $query = "SELECT * FROM tblktostamm WHERE fldindex=".$idwert;
        //echo $query."<br>"; 
        $results = $db->query($query);
        while ($row = $results->fetchArray()) {
          if ($autoinc=="J") {
            $qryins="INSERT INTO tblktosal (".$fldindex.",fldBez,fldDatum,fldUhrzeit,fldBetrag,fldKonto,fldInhaber,fldtimestamp,flddbsyncnr) VALUES(".$newrowid.",'$row[fldBez]','$datum','$uhrzeit','$row[fldBetrag]','$row[fldKonto]','$inhaber',".$timestamp.",$autoinc_start)";
          } else {
            $qryins="INSERT INTO tblktosal (fldBez,fldDatum,fldUhrzeit,fldBetrag,fldKonto,fldInhaber,fldtimestamp,flddbsyncnr) VALUES('$row[fldBez]','$datum','$uhrzeit','$row[fldBetrag]','$row[fldKonto]','$inhaber',".$timestamp.",$autoinc_start)";
          }
          //echo $qryins."=ins<br>"; 
          $db->exec($qryins);
          if ($show=="anzeigen") {
            echo "<div class='alert alert-success'>";
            echo $db->lastErrorMsg()."<br>";
            echo $qryins."<br>";
            echo "</div>";
          }

       }	
      }
    }
    echo "<div class='alert alert-success'>";
    //echo $db->lastErrorMsg()."<br>";
    echo $cnt." Stammdaten wurden übernommen.";
    echo "</div>";
    if ($autoinc=="J") {
      if ($newrowid==$autoinc_start) {
        $sqlupd="INSERT INTO tblindex (fldtable,fldid) VALUES('".$dbtable."',".$newrowid.")";
      } else {
        $sqlupd="UPDATE tblindex SET fldid=".$newrowid."  WHERE fldtable='".$dbtable."'";
      }
      //echo $sqlupd."<br>";
      $resupd = $db->exec($sqlupd);
    }  
  }
}

?>