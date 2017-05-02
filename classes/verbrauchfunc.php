<?php
header("Content-type: image/png");

// erstellen eines leeren Bildes mit 400px Breite und 300px Höhe
$anzproz=0.7;
$breite=1020*$anzproz;
//$hoehe=120;
$hoehe=150;
$bild = imagecreatetruecolor($breite, $hoehe);

// Hintergrundfarbe erstellen
$hintergrundfarbe = imagecolorallocate ($bild, 50, 50, 50);
imagefill($bild, 0, 0, $hintergrundfarbe);

// Farben festlegen
$gruen = imagecolorallocate($bild, 0, 255, 0);
$weiss = imagecolorallocate($bild, 255, 255, 255);

// Viereck zeichen
// mit folgenden Kordinaten (x1, y1, x2, y2, Farbe);
imagefilledrectangle ($bild, 10, 25, $breite-10, 35, $weiss);
imagefilledrectangle ($bild, 10, 75, $breite-10, 85, $weiss);

//$verbrauch=$_GET['verbrauch'];
$verbrauch=str_replace(",",".",$_GET['verbrauch']);
//$verbrauch=125.85;
$verbrauchproz=round($verbrauch/10,2);
$verbrauchpos=round($verbrauchproz*10)+10;
//$verbrauchpos=100*10+10;
imagefilledrectangle ($bild, 10, 25, $verbrauchpos*$anzproz, 35, $gruen);

$bisdatum=$_GET['datum'];
$date1 = time();
$date2 = mktime(0, 0, 0, 11,27,2016);
$datum=date('d.m.Y',$date1);
$day1 = date('d', $date1);
$day2 = date('d', $date2);
$maxtage=30;
$anztage=$maxtage-$day2+$day1;
$anztage=4;
$proztage=100-round($anztage/$maxtage*100,2);
$bis=round($proztage*10)+10;
//$bis=3.3*10+10;
imagefilledrectangle ($bild, 10, 75, $bis*$anzproz, 85, $gruen);

$str=$verbrauch." MB von 1 GB verbraucht (".$verbrauchproz."%)";
ImageString ($bild, 20, 50, 45, $str, $gruen);

$difftage=$maxtage-$anztage;
$str="am ".$datum." bis ".$bisdatum." (".$proztage."%) ";
ImageString ($bild, 100, 50, 95, $str, $gruen);
$str=$difftage." von 30 Tage, Rest ".$anztage." Tage";
ImageString($bild, 120,50,115,$str,$gruen);

imageline($bild,110*$anzproz,35,110*$anzproz,40,$gruen);
imageline($bild,210*$anzproz,35,210*$anzproz,40,$gruen);
imageline($bild,310*$anzproz,35,310*$anzproz,40,$gruen);
imageline($bild,410*$anzproz,35,410*$anzproz,40,$gruen);
imageline($bild,510*$anzproz,35,510*$anzproz,40,$gruen);
imageline($bild,610*$anzproz,35,610*$anzproz,40,$gruen);
imageline($bild,710*$anzproz,35,710*$anzproz,40,$gruen);
imageline($bild,810*$anzproz,35,810*$anzproz,40,$gruen);
imageline($bild,910*$anzproz,35,910*$anzproz,40,$gruen);

imageline($bild,110*$anzproz,85,110*$anzproz,90,$gruen);
imageline($bild,210*$anzproz,85,210*$anzproz,90,$gruen);
imageline($bild,310*$anzproz,85,310*$anzproz,90,$gruen);
imageline($bild,410*$anzproz,85,410*$anzproz,90,$gruen);
imageline($bild,510*$anzproz,85,510*$anzproz,90,$gruen);
imageline($bild,610*$anzproz,85,610*$anzproz,90,$gruen);
imageline($bild,710*$anzproz,85,710*$anzproz,90,$gruen);
imageline($bild,810*$anzproz,85,810*$anzproz,90,$gruen);
imageline($bild,910*$anzproz,85,910*$anzproz,90,$gruen);

// Ausgabe des Bildes
imagepng($bild);

?>