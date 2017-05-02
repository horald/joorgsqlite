<?php
include("bootstrapfunc.php");
bootstraphead();
bootstrapbegin("Joorgportal - Unzip<br>");
echo "<a href='../index.php' class='btn btn-primary btn-sm active' role='button'>Menü</a> "; 
echo "<a href='about.php' class='btn btn-primary btn-sm active' role='button'>zurück</a> "; 
$versnr=$_GET['versnr'];
echo "<div class='alert alert-success'>";
echo "Update-Version ".$versnr." wird entpackt...";
echo "</div>";
$zip = new ZipArchive;
$res = $zip->open('/home/horald/daten/Downloads/joorgsqlite'.$versnr.'.zip');
if ($res === TRUE) {
	 //$path = pathinfo(realpath($file), PATHINFO_DIRNAME);
	 //echo $path."=path<br>";
	 $verz="/var/www/html/test/joorgsqlite".$versnr;
    $zip->extractTo($verz);
    $zip->close();
    echo "<div class='alert alert-success'>";
    echo "Nach ".$verz." entpackt.";
    echo "</div>";
} else {
    echo "<div class='alert alert-warning'>";
    echo 'Fehler:'.$res;
    echo "</div>";
}
bootstrapend();
?>