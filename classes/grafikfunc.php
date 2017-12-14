<?php

function array_push_assoc($array, $key, $value){
  $array[$key] = $value;
  return $array;
}

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
	
  echo "<form name='eingabe' class='form-horizontal' method='post' action='grafik.php?grafik=1&menu=".$menu."&idwert=".$idwert."' enctype='multipart/form-data'>";

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


function grafikanzeigen() {
  //echo "<div id='example-1'>";
  //echo "	<h3>Monatsauswertung</h3>";
  echo "	<img width='700' height='450' src='grafikdarstellen.php' />";
  //echo "</div>";

}

?>