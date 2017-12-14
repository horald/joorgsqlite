<?php
header("content-type: text/html; charset=utf-8");

function ergebnis($menu,$vokabel,$fldindex,$sprache,$lektion,$muttersprache,$fremdsprache) {
  $db = new SQLite3('../data/joorgsqlite.db');
  $sql="SELECT * FROM tblvokabeln WHERE fldindex=".$fldindex;
  $results = $db->query($sql);
  $row = $results->fetchArray();
  $anzgelernt=$row['fldanzgelernt'];
  $anzfehler=$row['fldanzfehler'];
  echo "<br>";
  echo "<table class='table'>";
  if ($sprache==="deuhrv") {
    $ergebnis=$row['fldsprache_zwei'];
    echo "<tr><td>".$muttersprache."</td><td>".$row['fldsprache_eins']."</td></tr>";
    echo "<tr><td><b>".$fremdsprache."</b></td><td><b>".$row['fldsprache_zwei']."</b></td></tr>";
  } else {
    $ergebnis=$row['fldsprache_eins'];
    echo "<tr><td>".$fremdsprache."</td><td>".$row['fldsprache_zwei']."</td></tr>";
    echo "<tr><td><b>".$muttersprache."</b></td><td><b>".$row['fldsprache_eins']."</b></td></tr>";
  }  
  echo "</table>";
  if ($vokabel===$ergebnis) {
  	 $anzgelernt=$anzgelernt+1;
    $update="UPDATE tblvokabeln SET fldanzgelernt=".$anzgelernt." WHERE fldindex=".$fldindex;
    echo "<div class='alert alert-success'>";
    echo "Sehr gut! (".$anzgelernt." x richtig, ".$anzfehler." x falsch)<br>";
    echo "</div>";
  } else {
  	 $anzfehler=$anzfehler+1;
    $update="UPDATE tblvokabeln SET fldanzfehler=".$anzfehler." WHERE fldindex=".$fldindex;
    echo "<div class='alert alert-danger'>";
    echo "Leider falsch! (".$anzgelernt." x richtig, ".$anzfehler." x falsch)<br>";
    echo "</div>";
  }
  //echo $update."<br>";
  $db->exec($update);
  echo "<form class='form-horizontal' method='post' action='lernen.php?lernen=1&menu=".$menu."'>";
  echo "<input type='hidden' name='sprache' value='".$sprache."' />";
  echo "<input type='hidden' name='lektion' value=".$lektion." />";
  echo "<input type='submit' value='weiter' />";
  echo "</form>";
}

function lernen($menu,$sprache,$lektion,$muttersprache,$fremdsprache) {
  $db = new SQLite3('../data/joorgsqlite.db');
  //zufallsdatensatz ermitteln
  if ($lektion==="(ohne)") {
    $where="";
  } else {
    $where=" AND fldlektion='".$lektion."'";
    $qryflt="SELECT * FROM tblfilter WHERE fldtablename='tbllektion' AND fldmaske='LERNEN'";
    $resflt = $db->query($qryflt);
    if ($rowflt = $resflt->fetchArray()) {
      $qryflt="UPDATE tblfilter SET fldwert='".$lektion."' WHERE fldtablename='tbllektion' AND fldmaske='LERNEN'";
    } else {
      $qryflt="INSERT INTO tblfilter (fldtablename,fldmaske,fldwert) VALUES('tbllektion','LERNEN','".$lektion."')";
    }
    $db->exec($qryflt);
  }
  $sql="SELECT count(*) as anz FROM tblvokabeln WHERE fldfremdsprache='".$fremdsprache."' AND fldanzgelernt-fldanzfehler<=3".$where;
  $results = $db->query($sql);
  if ($row = $results->fetchArray()) {
    $anz=$row['anz'];
    echo "<div class='alert alert-success'>";
    echo "Noch ".$anz." Vokablen. (".$lektion.") für ".$fremdsprache."<br>";
    echo "</div>";
  } else {
    echo "<div class='alert alert-success'>";
    echo "Keine Vokabeln für ".$fremdsprache." gefunden.<br>";
    echo "</div>";
  }
  
  //echo $anz."=anz<br>";
  $sql="SELECT * FROM tblvokabeln WHERE fldfremdsprache='".$fremdsprache."' AND fldanzgelernt-fldanzfehler<=3".$where;
  $results = $db->query($sql);
  $cnt=0;
  //echo mt_rand(1, 2)."=zufall<br>";
  $zufall=mt_rand(1, $anz);
  echo "<br>";
  while ($row = $results->fetchArray()) {
    $cnt=$cnt+1;
    //echo $cnt.",".$zufall.",".$row['fldindex']."=cnt,zufall,fldindex<br>";
	if ($cnt===$zufall) {
	  $fldindex=$row['fldindex'];
	}
  }
  
  $sql="SELECT * FROM tblvokabeln WHERE fldindex=".$fldindex;
  //echo $sql."<br>";
  $results = $db->query($sql);
  echo "<form class='form-horizontal' method='post' action='lernen.php?lernen=2&menu=".$menu."'>";
  echo "<table class='table'>";
  while ($row = $results->fetchArray()) {
    if ($sprache==="deuhrv") {
      echo "<tr><td>".$muttersprache."</td><td>".$row['fldsprache_eins']."</td></tr>";
	  echo "<tr><td>".$fremdsprache."</td><td><input type='text' name='vokabel'></td></tr>";
	} else {
      echo "<tr><td>".$muttersprache."</td><td><input type='text' name='vokabel'></td></tr>";
	  echo "<tr><td>".$fremdsprache."</td><td>".$row['fldsprache_zwei']."</td></tr>";
	}
	echo "<input type='hidden' name='sprache' value=".$sprache." />";
	echo "<input type='hidden' name='fldindex' value=".$row['fldindex']." />";
  }
  echo "</table>";
  echo "<input type='hidden' name='lektion' value=".$lektion." />";
  echo "<input type='submit' value='Ergebnis' />";
  echo "</form>";
}

function auswahl($menu,$muttersprache,$fremdsprache) {
  $db = new SQLite3('../data/joorgsqlite.db');
  $qryflt="SELECT * FROM tblfilter WHERE fldtablename='tbllektion' AND fldmaske='LERNEN'";
  $resflt = $db->query($qryflt);
  if ($rowflt = $resflt->fetchArray()) {
    $auswahl=$rowflt['fldwert'];
  }
  $sql="SELECT * FROM tbllektion";
  $results = $db->query($sql);
  echo "<form class='form-horizontal' method='post' action='lernen.php?lernen=1&menu=".$menu."'>";
  echo "Lektion: ";
  echo "<select name='lektion' size='1'>"; 
  echo "<option>(ohne)</option>"; 
  while ($row = $results->fetchArray()) {
  	 if ($row['fldbez']===$auswahl) {
      echo "<option selected>".$row['fldbez']."</option>"; 
    } else {
      echo "<option>".$row['fldbez']."</option>"; 
    }
  }
  echo "</select>";
  echo "<br>";  
  echo "  <input type='radio' id='deuhrv' name='sprache' value='deuhrv' checked>";
  echo "  <label for='deuhrv'> ".$muttersprache." - ".$fremdsprache."</label><br>";
  echo "  <input type='radio' id='hrvdeu' name='sprache' value='hrvdeu'>";
  echo "  <label for='hrvdeu'> ".$fremdsprache." - ".$muttersprache."</label><br>";
  echo "  <input type='submit' value='auswählen' />";
  echo "</form>";
}
  
?>