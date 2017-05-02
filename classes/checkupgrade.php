<?php

function getactvers($pfad) {
  $db = new SQLite3($pfad.'joorgsqlite.db');
  $sql="SELECT * FROM tblversion ORDER BY fldversion";
  $results = $db->query($sql);
  while ($row = $results->fetchArray()) {
    $arr=$row;
  }
  $versnr=$arr['fldversion'];
  $db->close();	
  return $versnr;
}

function check_version($versnr) {

  $string = file_get_contents("version.json");
  $json_a = json_decode($string, true);
  $locvers=$json_a['versnr'];
  $versdat=$json_a['versdat'];
  if ($versnr=="") {
    echo "<script>"; 
    echo "  indexvers_anfordern(); ";
    echo "</script>";
  }
  if ($locvers<$versnr) {
    echo "<div class='alert alert-info'>";
    echo "<a href='classes/checkupdate.php?getvers=".$versnr."'>Neue Version ".$versnr." verfügbar</a><br>";
    echo "</div>";
  } else {
    $actvers=getactvers("data/");	
    if ($actvers<$versnr) {
      echo "<div class='alert alert-info'>";
      echo "<a href='classes/installupdate.php?newvers=".$versnr."&oldvers=".$actvers."&versdat=".$versdat."'>Auf neue Version ".$versnr." aktualisieren</a>";
      echo "</div>";
    }
  }
}


?>