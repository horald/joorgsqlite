<?php
header("content-type: text/html; charset=utf-8");


?>
<script type="text/javascript">
function myfunc() {
var e = document.getElementByName("etage");
var strUser = e.options[e.selectedIndex].value;
alert(strUser);
}
</script>
<?php        	

function updatepreis($rowid,$show) {
  $db = new SQLite3('../data/joorgsqlite.db');
  $sql = "SELECT * FROM tblartikel WHERE fldBez='".$_POST['fldBez']."' AND fldOrt='".$_POST['kaufort']."'";
  //echo $sql."<br>";
  $results = $db->query($sql);
  $count=0;
  while ($row = $results->fetchArray()) {
    $count=$count+1;
    $arr=$row;
  }	
  //echo $count."=count<br>";
  if ($count==1) {
    if ($_POST['fldPreis']<>"") {
      if ($_POST['kaufort']<>"") {  
        $sql="UPDATE tblartikel SET fldPreis='".$_POST['fldPreis']."' WHERE fldindex=".$arr['fldindex'];
        $db->exec($sql);
        if ($show=="anzeigen") {
          echo "<div class='alert alert-success'>";
          echo $db->lastErrorMsg()."<br>";
          echo $sql."<br>";
          echo "</div>";
        }
      }
    }  
  }
  if ($count==0) {
    if ($_POST['fldPreis']<>"") {
      if ($_POST['kaufort']<>"") {  
        $sql="INSERT INTO tblartikel (fldBez,fldKonto,fldPreis,fldOrt,fldAnz,fldJN) VALUES ('".$_POST['fldBez']."','".$_POST['fldKonto']."','".$_POST['fldPreis']."','".$_POST['kaufort']."','1','J')";
        //echo $sql."<br>";
        $db->exec($sql);
        //echo $db->lastErrorMsg()."<br>";
      }
    }
  }  
}

function updateinput($pararray,$listarray,$idwert,$menu,$menugrp) {
  $db = new SQLite3('../data/joorgsqlite.db');
  $sql="SELECT * FROM ".$pararray['dbtable']." WHERE fldindex=".$idwert;
  //echo $sql."<br>";
  $results = $db->query($sql);
  while ($row = $results->fetchArray()) {
    $arr=$row;
  }	
  echo "<a href='showtab.php?menu=".$menu."&menugrp=".$menugrp."' class='btn btn-primary btn-sm active' role='button'>Zurück</a>"; 
  echo "<form class='form-horizontal' method='post' action='update.php?update=1&menu=".$menu."&menugrp=".$menugrp."' role='form'>";

  echo "<div class='table-responsive'>";
  echo "<table class='table'>";
  $count=sizeof($listarray);
  foreach ( $listarray as $arrelement ) {
  	 if ($arrelement['fieldsave']<>"NO") {
    switch ( $arrelement['type'] )
    {
      case 'JN':
        echo "<tr>";
        echo "<td class='col-md-1'><label >".$arrelement['label'].":</label></td>";
        echo "<td class='col-md-2'><select name='".$arrelement['name']."' size='1' >";
        if ($row[$arrelement['dbfield']]=="J") {
          echo "<option style='background-color:#c0c0c0;' selected>J</option>";
          echo "<option style='background-color:#c0c0c0;' >N</option>";
        } else {
          echo "<option style='background-color:#c0c0c0;' >J</option>";
          echo "<option style='background-color:#c0c0c0;' selected>N</option>";
        }
        echo "</select></td>";
        echo "</tr>";
      break;
      case 'text':
        $wert=$arr[$arrelement['dbfield']];
        if ($wert=="") {
          if ($arrelement['default']<>"") {
          	$wert=$arrelement['default'];
          }
        }
        echo "<tr>";
        echo "<td class='col-md-1'><label>".$arrelement['label'].":</label></td>";
        echo "<td class='col-md-2'><input type='text' name='".$arrelement['dbfield']."' value='".$wert."'/></td>";
        echo "</tr>";
      break;
      case 'selectid':
        $seldbwhere="";
        if ($arrelement['name']=="zimmer") {
//          $seldbwhere=" WHERE fldid_etage=(SELECT fldindex FROM tblorte WHERE fldBez='2. Stock')";
        }
        if ($arrelement['seldbwhere']<>"") {
        	 if ($seldbwhere<>"") {
            $seldbwhere=$seldbwhere." AND ".$arrelement['seldbwhere'];
        	 } else {
            $seldbwhere=" WHERE ".$arrelement['seldbwhere'];
          }
        }
        $sql="SELECT * FROM ".$arrelement['dbtable'].$seldbwhere;
        //echo $sql."<br>";
        $results = $db->query($sql);
        echo "<tr>";
        echo "<td class='col-md-1'><label >".$arrelement['label'].":</label></td>";
        echo "<td class='col-md-2'><select name='".$arrelement['name']."' size='1' onchange='myfunc()'>";
        echo "<option style='background-color:#c0c0c0;' >(ohne)</option>";
        while ($row = $results->fetchArray()) {
          if ($arr[$arrelement['dbfield']]==$row[$arrelement['seldbindex']]) {
            echo "<option style='background-color:#c0c0c0;' selected value=".$row[$arrelement['seldbindex']].">".$row[$arrelement['seldbfield']]."</option>";
          } else {
            echo "<option style='background-color:#c0c0c0;' value=".$row[$arrelement['seldbindex']].">".$row[$arrelement['seldbfield']]."</option>";
          }
        }
        echo "</select></td>";
        echo "</tr>";
      break;
      case 'select':
        $seldbwhere="";
        if ($arrelement['seldbwhere']<>"") {
          $seldbwhere=" WHERE ".$arrelement['seldbwhere'];
        }
        $sql="SELECT * FROM ".$arrelement['dbtable'].$seldbwhere;
        $results = $db->query($sql);
        echo "<tr>";
        echo "<td class='col-md-1'><label >".$arrelement['label'].":</label></td>";
        echo "<td class='col-md-2'><select name='".$arrelement['name']."' size='1'>";
        echo "<option style='background-color:#c0c0c0;' >(ohne)</option>";
        while ($row = $results->fetchArray()) {
          if ($arr[$arrelement['dbfield']]==$row[$arrelement['seldbfield']]) {
            echo "<option style='background-color:#c0c0c0;' selected>".$row[$arrelement['seldbfield']]."</option>";
          } else {
            echo "<option style='background-color:#c0c0c0;' >".$row[$arrelement['seldbfield']]."</option>";
          }
        }
        echo "</select></td>";
        echo "</tr>";
      break;
      case 'time':
        echo "<tr>";
        echo "<td class='col-md-1'><label >".$arrelement['label'].":</label></td>";
        echo "<td class='col-md-2'><input type='text' name='".$arrelement['dbfield']."' value='".$arr[$arrelement['dbfield']]."'/></td>";
        echo "</tr>";
      break;
      case 'calc':
        echo "<tr>";
        echo "<td><label >".$arrelement['label'].":</label></td>";
        echo "<td><input type='text' name='".$arrelement['dbfield']."' value='".$arr[$arrelement['dbfield']]."'/></td>";
        echo "</tr>";
      break;
      case 'date':
        echo "<tr>";
        echo "<td class='col-md-1'><label >".$arrelement['label'].":</label></td>";
        echo "<td class='col-md-2'><div class='input-group date form_date col-md-2' data-date='' data-date-format='yyyy-mm-dd' data-link-field='dtp_input2' data-link-format='yyyy-mm-dd'>";
        echo "<input class='form-control' size='8' type='text' name='".$arrelement['dbfield']."' value='".$arr[$arrelement['dbfield']]."' >";
		  echo "<span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span>";
        echo "</div>";
		  echo "<input type='hidden' id='dtp_input2' value='' /><br/></td>";
        echo "</tr>";
      break;
      case 'prozref':
        $proz="0";
        $sqlfil="SELECT * FROM tblfilter WHERE fldtablename='tblorte' AND fldfeld='fldid_suchobj'";
        $resfil = $db->query($sqlfil);
        if ($rowfil = $resfil->fetchArray()) {
          if ($rowfil['fldwert']<>"(ohne)") {
            $sqlsuch="SELECT * FROM tblsuchobj WHERE fldbez='".$rowfil['fldwert']."'";
            $ressuch = $db->query($sqlsuch);
            if ($rowsuch = $ressuch->fetchArray()) {
              $refwhere="fldid_suchobj=".$rowsuch['fldindex']." AND fldid_orte=".$arr['fldindex'];
              $sqlref="SELECT * FROM tblrefsuchobj WHERE ".$refwhere;
              $resref = $db->query($sqlref);
              if ($rowref = $resref->fetchArray()) {
                $proz=$rowref[$arrelement['dbfield']];
              }
            }
          }
        }        
        echo "<dl>";
        echo "<dt><label >".$arrelement['label'].":</label></dt>";
        echo "<dd><input type='text' name='".$arrelement['dbfield']."' value='".$proz."'/></dd>";
        echo "</dl>";
      break;
      case 'calc':
        echo "<dl>";
        echo "<dt><label >".$arrelement['label'].":</label></dt>";
        echo "<dd><input type='text' name='".$arrelement['dbfield']."' value='".$default."'/></dd>";
        echo "</dl>";
      break;
      case 'proz':
        echo "<dl>";
        echo "<dt><label >".$arrelement['label'].":</label></dt>";
        echo "<dd><input type='text' name='".$arrelement['dbfield']."' value='".$arr[$arrelement['dbfield']]."'/></dd>";
        echo "</dl>";
      break;
      case 'zahl':
        echo "<tr>";
        echo "<td><label >".$arrelement['label'].":</label></td>";
        echo "<td><input type='text' name='".$arrelement['dbfield']."' value='".$arr[$arrelement['dbfield']]."'/></td>";
        echo "</tr>";
      break;
    }
    }
  }
  echo "</table>";
  echo "</div>";

  echo "<input type='hidden' name='id' value=".$idwert.">";
  if ($pararray['chkpreis']=="J") {
    //echo "<input type='checkbox' name='chkpreis' value='preis' checked> Preis speichern<br>";
  }
  echo "<input type='checkbox' name='chkanzeigen' value='anzeigen'> Speichern anzeigen<br>";
  echo "<input type='checkbox' name='resync' value='yes'> Resync<br>";
  echo "<input type='checkbox' name='dscopy'> Kopieren<br>";

  echo "<dd><input type='submit' value='Speichern' /></dd>";
  echo "</form>";

}

function updatesave($pararray,$listarray,$menu,$show,$chkpreis,$menugrp,$autoinc_start,$resync,$timezonediff,$autoinc) {
  echo "<a href='showtab.php?menu=".$menu."&menugrp=".$menugrp."' class='btn btn-primary btn-sm active' role='button'>Liste</a>"; 
  $db = new SQLite3('../data/joorgsqlite.db');

  $strset="";
  $strfld="";
  $sql="UPDATE ".$pararray['dbtable']." SET ";
  foreach ( $listarray as $arrelement ) {
  	 if ($arrelement['fieldsave']<>"NO") {
  	 	$dbwert=$_POST[$arrelement['name']];
      switch ( $arrelement['type'] )
      {
        case 'text':
      	 $dbwert=$_POST[$arrelement['dbfield']];
          $sql=$sql.$arrelement['dbfield']."='".$_POST[$arrelement['dbfield']]."', ";
        break;
        case 'zahl':
          $sql=$sql.$arrelement['dbfield']."='".$_POST[$arrelement['dbfield']]."', ";
        break;
        case 'selectid':
          $wert=$_POST[$arrelement['name']];
          if ($wert=="(ohne)") {
          	$wert=0;
          }
          $sql=$sql.$arrelement['dbfield']."='".$wert."', ";
        break;
        case 'select':
          $sql=$sql.$arrelement['dbfield']."='".$_POST[$arrelement['name']]."', ";
        break;
        case 'JN':
      	  $dbwert=$_POST[$arrelement['dbfield']];
          $sql=$sql.$arrelement['dbfield']."='".$_POST[$arrelement['dbfield']]."', ";
        break;
        case 'time':
      	 $dbwert=$_POST[$arrelement['dbfield']];
          $sql=$sql.$arrelement['dbfield']."='".$_POST[$arrelement['dbfield']]."', ";
        break;
        case 'date':
      	 $dbwert=$_POST[$arrelement['dbfield']];
          $sql=$sql.$arrelement['dbfield']."='".$_POST[$arrelement['dbfield']]."', ";
        break;
        case 'calc':
      	 $dbwert=$_POST[$arrelement['dbfield']];
          $sql=$sql.$arrelement['dbfield']."='".$_POST[$arrelement['dbfield']]."', ";
        break;
        case 'proz':
          $sql=$sql.$arrelement['dbfield']."='".$_POST[$arrelement['dbfield']]."', ";
        break;
        case 'timestamp':
          $sql=$sql.$arrelement['dbfield']."=CURRENT_TIMESTAMP, ";
        break;
        case 'prozref':
          $sqlfil="SELECT * FROM tblfilter WHERE fldtablename='tblorte' AND fldfeld='fldid_suchobj'";
          echo $sqlfil."<br>";
          $resfil = $db->query($sqlfil);
          if ($rowfil = $resfil->fetchArray()) {
          	if ($rowfil['fldwert']<>"(ohne)") {
              $sqlsuch="SELECT * FROM tblsuchobj WHERE fldbez='".$rowfil['fldwert']."'";
              $ressuch = $db->query($sqlsuch);
              if ($rowsuch = $ressuch->fetchArray()) {
                $refwhere="fldid_suchobj=".$rowsuch['fldindex']." AND fldid_orte=".$_POST['id'];
                $sqlref="SELECT * FROM tblrefsuchobj WHERE ".$refwhere;
                $resref = $db->query($sqlref);
                if ($rowref = $resref->fetchArray()) {
                  $sqlupdref="UPDATE tblrefsuchobj SET ".$arrelement['dbfield']."=".$_POST[$arrelement['dbfield']].",fldtyp='".$arrelement['reftyp']."',fldid_moebel=".$_POST['moebel'].",fldid_zimmer=".$_POST['zimmer']." AND fldid_etage=".$_POST['etage']." WHERE ".$refwhere;          
                } else {
                  $sqlupdref="INSERT INTO tblrefsuchobj (fldid_suchobj,fldid_orte,".$arrelement['dbfield'].",fldtyp) VALUES(".$rowsuch['fldindex'].",".$_POST['id'].",'".$_POST[$arrelement['dbfield']]."','".$arrelement['reftyp']."')";          
                }	
                echo "<div class='alert alert-success'>";
                echo $sqlupdref."=prozref";
                echo "</div>";
                //$reserr = $db->exec($sqlupdref);
              }  
            }  
          }  
        break;
      }
      
      switch ( $arrelement['type'] )
      {
        case 'calcsum':
        break;
        default:
          if ($strset=="") {
            $strset=$arrelement['dbfield']."='".$wert."'";
          } else {
            $strset=$strset.",".$arrelement['dbfield']."='".$wert."'";
          }  
          if ($strfld=="") {
            $strfld=$arrelement['dbfield'];
            $strval="'".$dbwert."'";
          } else {
            $strfld=$strfld.",".$arrelement['dbfield'];
            $strval=$strval.",'".$dbwert."'";
          }    
          //echo $arrelement['dbfield']."=".$dbwert."<br>";  
      }  
      
      
    }  
  }

  $sql=substr($sql,0,-2);
  if ($pararray['dbsyncnr']=="J") {
  	 $sql=$sql.",flddbsyncnr=".$autoinc_start;
  	 if ($timezonediff<>"") {
  	   $sql=$sql.",fldtimestamp=datetime('now', 'localtime','".$timezonediff."')";
  	 } else {
  	   $sql=$sql.",fldtimestamp=datetime('now', 'localtime')";
  	 }  
  }
  if ($resync="yes") {
    $sql=$sql.",flddbsyncstatus='SYNC'";
  }  
  $sql=$sql." WHERE fldindex=".$_POST['id'];
  $query = $db->exec($sql);
  if ($pararray['chkpreis']=="J") {
//    if ($chkpreis=="preis") {
      $rowid=$_POST['id'];
      updatepreis($rowid,$show);
//    }
  }

    $dscopy=$_POST['dscopy'];
    if ($dscopy==true) {
      if ($pararray['dbsyncnr']=="J") {
        $strfld=$strfld.",flddbsyncnr,fldtimestamp,flddbsyncstatus";	
        if ($timezonediff<>"") {
          $strval=$strval.",".$autoinc_start.",datetime('now', 'localtime','".$timezonediff."'),'SYNC'";
        } else {  
          $strval=$strval.",".$autoinc_start.",datetime('now', 'localtime'),'SYNC'";
        }  
      }	
      
      if ($autoinc=="J") {
        $sqlid="SELECT * FROM tblindex WHERE fldtable='".$pararray['dbtable']."'";
        $results = $db->query($sqlid);
        if ($row = $results->fetchArray()) {
          $newrowid=$row['fldid'] + $autoinc_step;
          //echo $newrowid."=newrowid<br>";
        } else {
          $newrowid=$autoinc_start;  
        }
        $strfld=$pararray['fldindex'].",".$strfld;
        $strval=$newrowid.",".$strval;
      }
      
      $qrycopy = "INSERT INTO ".$pararray['dbtable']." (".$strfld.") VALUES(".$strval.") ";
      //echo $qrycopy."<br>";
      //mysql_query($qrycopy) or die("Error using mysql_query($qrycopy): ".mysql_error());
      $qryins = $db->exec($qrycopy);
    }


  if ($show=="anzeigen") {
    echo "<div class='alert alert-success'>";
    echo $db->lastErrorMsg()."<br>";
    echo $sql."<br>";
    if ($dscopy==true) {
      echo $qrycopy."<br>";
    }  
    echo "</div>";
  }
  $fldbez="fldbez";
  if ($pararray['fldbez']<>"") {
  	 $fldbez=$pararray['fldbez'];
  }
  echo "<div class='alert alert-success'>";
  echo "Daten '".$_POST[$fldbez]."' aktualisiert.";
  echo "</div>";
}
?>