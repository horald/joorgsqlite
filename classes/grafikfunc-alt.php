<?php

function grafikauswahl($menu,$idwert) {
  $db = new SQLite3('../data/joorgsqlite.db');
  $timestamp = time();
  $jahr = date("Y",$timestamp);
  $monat = date("m",$timestamp);
  $pmon=substr($monat,0,1);
  //echo $pmon;
  if ($pmon=="0") {
  	 $monat = substr($monat,1,1);
  }	
	
  echo "<form name='eingabe' class='form-horizontal' method='post' action='grafik-alt.php?grafik=1&menu=".$menu."&idwert=".$idwert."' enctype='multipart/form-data'>";

        $qryflt = "SELECT * FROM tblfilter WHERE fldtablename='tblktosal' AND fldfeld='fldInhaber'";
        $resflt = $db->query($qryflt);
        $inhaber="";
        if ($linres = $resflt->fetchArray()) {
        	 $inhaber=$linres['fldwert'];
        }

        $fquery = "SELECT * FROM tblktoinhaber";
        //$fresult = mysql_query($fquery) or die(mysql_error());
        $fresult = $db->query($fquery);

        echo "<table>";

        $default = date('Y-m-01');
        echo "<tr>";
        echo "<td><label >Von Datum:</label></td>";
        echo "<td><div class='input-group date form_date col-md-12' data-date='' data-date-format='yyyy-mm-dd' data-link-field='dtp_input2' data-link-format='yyyy-mm-dd'>";
        echo "<input class='form-control' size='8' type='text' name='vondatum' value='".$default."' >";
        echo "<span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span>";
        echo "</div></td>";
        echo "<input type='hidden' id='dtp_input2' value='' />";
        echo "</tr>";

        $default = date('Y-m-01');
        $default = strtotime ( '+1 month' , strtotime ( $default ) ) ;
        $default = date ( 'Y-m-d' , $default );        
        echo "<tr>";
        echo "<td><label >Bis Datum:</label></td>";
        echo "<td><div class='input-group date form_date col-md-12' data-date='' data-date-format='yyyy-mm-dd' data-link-field='dtp_input2' data-link-format='yyyy-mm-dd'>";
        echo "<input class='form-control' size='8' type='text' name='bisdatum' value='".$default."' >";
        echo "<span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span>";
        echo "</div></td>";
        echo "<input type='hidden' id='dtp_input2' value='' />";
        echo "</tr>";

        echo "</table>"; 

        echo "<div class='control-group'>";
        echo "  <label class='control-label' style='text-align:left' >Kontoinhaber:</label>";
        echo "  <select name='ktoinhaber' size='1'>";
        //while ($fline = mysql_fetch_array($fresult)) {
        while ($fline = $fresult->fetchArray()) {
          //$index = $fline['fldIndex'];
          if ($inhaber==$fline['fldBez']) {
            echo "<option style='background-color:#c0c0c0;' value=".$fline['fldBez'].">".$fline['fldBez']."</option>";
          }
        }
        echo "  </select>";
        echo "</div>";


  echo "  <div class='form-actions'>";
  echo "     <button type='submit' name='submit' class='btn btn-primary'>Auswerten</button>";
  echo "</div>";
  echo "</form>";
}


function grafikanzeigen($ktoinhaber,$vondatum,$bisdatum) {
  $db = new SQLite3('../data/joorgsqlite.db');
  $query = "SELECT * FROM `tblktokonten` WHERE fldTyp='AUSGABE'";
  $result = $db->query($query);

  $qryein = "SELECT sum(fldBetrag) AS Betrag FROM tblktosal,tblktokonten WHERE fldKurz=fldKonto AND tblktokonten.fldTyp='EINNAHME' AND fldInhaber='".$ktoinhaber."' AND fldDatum>='".$vondatum."' AND fldDatum<='".$bisdatum."' AND flddel<>'J' ";
  $resein = $db->query($qryein);
  $einnahmen=0;
  if ($linein = $resein->fetchArray()) {
  	 $einnahmen=$linein['Betrag'];
  }
	
  $qrysum = "SELECT sum(fldBetrag) AS Betrag FROM tblktosal WHERE fldInhaber='".$ktoinhaber."' AND fldDatum>='".$vondatum."' AND fldDatum<='".$bisdatum."' AND flddel<>'J' ";
  $ressum = $db->query($qrysum);
  $summe=0;
  if ($linsum = $ressum->fetchArray()) {
  	 $summe=$linsum['Betrag'];
  }

echo "<html>";
?>
<head>
	<script type="text/javascript">
		window.onload = function () {
			var chart = new CanvasJS.Chart("chartContainer",
			{
				title:{
<?php

  echo "        text: 'Monatsaufstellung vom ".$vondatum." bis ".$bisdatum." von ".$ktoinhaber."'";              

?>
				},
            axisY:{
              gridThickness: 0
	         },     
	  
				data: [
				{
					type: "column",

					dataPoints: [

<?php
  $ausgaben=0;
  while ($line = $result->fetchArray()) {
    //$qrymon = "SELECT sum(fldBetrag) AS Betrag, strftime('%m',fldDatum) as Monat FROM tblktosal,tblktoinhaber WHERE fldInhaber=tblktoinhaber.fldBez AND fldInhaber='".$ktoinhaber."' AND strftime('%m',fldDatum)=0".$mon." AND fldKonto='".$line[fldKurz]."' AND strftime('%Y',fldDatum)=".$jahr." GROUP BY strftime('%m',fldDatum)";
    $qrymon = "SELECT sum(fldBetrag) AS Betrag FROM tblktosal WHERE fldInhaber='".$ktoinhaber."' AND fldKonto='".$line['fldKurz']."' AND fldDatum>='".$vondatum."' AND fldDatum<='".$bisdatum."' AND flddel<>'J' ";
    //echo $qrymon."<br>";
    $resmon = $db->query($qrymon);
    if ($linmon = $resmon->fetchArray()) {
    	$bez=$line['fldBez'];
    	$betrag=$linmon['Betrag'];
    	$ausgaben=$ausgaben+$betrag;
    	if ($betrag<>0) {
        echo "         { label: '".$bez."', y: ".$linmon['Betrag'].", indexLabel: '".$linmon['Betrag']."' },";
      }
    }
  }
?>

					]
				}
				]
			});

			chart.render();
		}
	</script>
	<script src="../includes/canvasjs/canvasjs.min.js"></script>
	<title>Auswertung</title>
</head>
<?php
echo "<body>";
	echo "<div id='chartContainer' style='height: 300px; width: 100%;'>";
	echo "</div>";
   echo "<div class='alert alert-success'>";
   echo "<table>";
   echo "<tr><td>Einnahmen</td><td> : ".sprintf("%.2f",$einnahmen)."</td></tr>";
   echo "<tr><td>Ausgaben</td><td> : ".sprintf("%.2f",$ausgaben)."</td></tr>";
   $diff=$summe-$ausgaben-$einnahmen;
   echo "<tr><td>Sonstiges</td><td> : ".sprintf("%.2f",$diff)."</td></tr>";
   echo "<tr><td>Summe</td><td> : ".sprintf("%.2f",$summe)."</td></tr>";
   echo "</table>";
   //echo $qryein."<br>";
   echo "</div>";
	
echo "</body>";
echo "</html>";
	
	
}

?>