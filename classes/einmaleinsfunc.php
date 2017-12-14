<?php
header("content-type: text/html; charset=utf-8");

function ergebnis($menu,$rechenart,$rechnung,$eingabewert,$erg) {
  echo "<br>";
  echo "<div class='alert alert-info'>";
  echo $rechnung." = ".$erg;
  echo "</div>";
  if ($eingabewert===$erg) {
    echo "<div class='alert alert-success'>";
    echo "Sehr gut!<br>";
    echo "</div>";
  } else {
    echo "<div class='alert alert-danger'>";
    echo "Leider falsch! (".$rechnung." ungleich ".$eingabewert.")<br>";
    echo "</div>";
  }
  echo "<form class='form-horizontal' method='post' action='einmaleins.php?einmaleins=1&menu=".$menu."'>";
  echo "<input type='hidden' name='rechenart' value='".$rechenart."' />";
  echo "<input type='submit' value='weiter' />";
  echo "</form>";
  
}

function einmaleins($menu,$rechenart) {
  echo "<br>";
  $fak1=mt_rand(2, 9);
  $fak2=mt_rand(2, 9);
  $mul=$fak1 * $fak2;
  if ($rechenart=="mal") {
    $erg=$fak1 * $fak2;
    $rechnung=$fak1." * ".$fak2;
  } else {
    $erg=$fak1;
    $rechnung=$mul." / ".$fak2;
  }
  echo "<form class='form-horizontal' method='post' action='einmaleins.php?einmaleins=2&menu=".$menu."'>";
  echo "<table class='table'>";
  echo "<tr>";
  echo "<td>".$rechnung." =</td><td><input type='text' name='eingabewert' value='' /></td>";
  echo "</tr>";
  echo "</table>";  
  echo "<input type='hidden' name='rechnung' value='".$rechnung."' />";
  echo "<input type='hidden' name='erg' value=".$erg." />";
  echo "<input type='hidden' name='rechenart' value='".$rechenart."' />";
  echo "<input type='submit' value='Ergebnis' />";
  echo "</form>";
}

function auswahl($menu) {
  echo "<form class='form-horizontal' method='post' action='einmaleins.php?einmaleins=1&menu=".$menu."'>";
  echo "<label>Rechenart:</label><br>";
  echo "  <input type='radio' id='deuhrv' name='rechenart' value='mal' checked>";
  echo "  <label for='deuhrv'> malnehmen (*)</label><br>";
  echo "  <input type='radio' id='hrvdeu' name='rechenart' value='geteilt'>";
  echo "  <label for='hrvdeu'> geteilt (/)</label><br>";
  echo "<input type='submit' value='auswählen' />";
  echo "</form>";
}
	
?>