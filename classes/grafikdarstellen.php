<?php
include('../includes/phpgraphlib/phpgraphlib.php');
include('grafikfunc.php');
$graph = new PHPGraphLib(700, 450);

$db = new SQLite3('../data/joorgsqlite.db');
$query = "SELECT * FROM `tblktokonten` ";
//$graph->setTitle($query);
$result = $db->query($query);
$ktoinhaber="horst_bargeld";
$vondatum="2017-05-01";
$bisdatum="2017-06-30";
//$data_ausgabe = array("sql" => 100);
$data_ausgabe = array();
while ($line = $result->fetchArray()) {
  $qrymon = "SELECT sum(fldBetrag) AS Betrag FROM tblktosal WHERE fldInhaber='".$ktoinhaber."' AND fldKonto='".$line[fldKurz]."' AND fldDatum>='".$vondatum."' AND fldDatum<='".$bisdatum."' AND flddel<>'J' ";
  $resmon = $db->query($qrymon);
  if ($linmon = $resmon->fetchArray()) {
    //$new_array = array("sql" => $linmon[Betrag]); 
	//array_merge($data_ausgabe, "sql" => $linmon[Betrag]);
	if ($linmon[Betrag]<0) {
	  $data_ausgabe = array_push_assoc($data_ausgabe, $line[fldBez], $linmon[Betrag]);
    //array_push($data_ausgabe,array("sql" => $linmon[Betrag]));
   } 
//      array_push($data_ausgabe,10);
  }
}
//$data_ausgabe[0]= {"" => 100};
//$data_ausgabe = array("Pflege" => -23.40,"Haushalt" => -10.50,"Leben" => -67.80);
$graph->addData($data_ausgabe);
$graph->setGradient('red', 'maroon');
$graph->setDataValues(true);
$graph->createGraph();
?>
