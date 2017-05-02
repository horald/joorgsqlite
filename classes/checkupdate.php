<?php
include("bootstrapfunc.php");
include("checkupgrade.php");
bootstraphead();
bootstrapbegin("Joorgportal - Checkupdate<br>");
echo "<a href='../index.php' class='btn btn-primary btn-sm active' role='button'>Menü</a> "; 
echo "<a href='about.php' class='btn btn-primary btn-sm active' role='button'>zurück</a> "; 

$getvers=$_GET['getvers'];
if ($getvers=="") {
  echo "<a id='idVersion' href='#' class='btn btn-primary btn-sm active' role='button'>GetVersion</a> "; 

  echo "<script>"; 
  echo "  meinHandler('idVersion','click',vers_anfordern); ";
  echo "</script>";
  $getvers=$_POST['versnr'];
} 


$string = file_get_contents("../version.json");
$json_a = json_decode($string, true);
$locversnr=$json_a['versnr'];
$locversdat=$json_a['versdat'];

$actvers="";	
echo "<a href='installupdate.php?newvers=".$locversnr."&oldvers=".$actvers."&versdat=".$locversdat."' class='btn btn-primary btn-sm active' role='button'>DB-Update einspielen</a><br> "; 
echo "<br>";

if ($getvers<>"") {
  echo "<br>";
  if ($getvers>$locversnr) {
    echo "<a href='https://github.com/horald/joorgsqlite/raw/gh-pages/sites/update/joorgsqlite".$getvers.".zip' class='btn btn-primary btn-sm active' role='button'>Download Update Version ".$getvers."</a><br> "; 
  } else {
    $actvers=getactvers("../data/");	
    if ($actvers<$locversnr) {
      echo "<div class='alert alert-info'>";
      echo "<a href='installupdate.php?newvers=".$locversnr."&versdat=".$locversdat."'>Auf neue Version ".$locversnr." aktualisieren</a>";
      echo "</div>";
    } else {
      echo "<div class='alert alert-success'>";
  	   echo "Sie haben die aktuelle Version ".$getvers;
  	   echo "</div>";
      echo "<a href='https://github.com/horald/joorgsqlite/raw/gh-pages/sites/update/joorgsqlite".$getvers.".zip' class='btn btn-primary btn-sm active' role='button'>Download Update Version ".$getvers."</a><br> "; 
    }
  }
}

bootstrapend();
?>