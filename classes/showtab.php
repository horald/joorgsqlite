<?php
session_start();
include("bootstrapfunc.php");
include("showtabfunc.php");
$menu=$_GET['menu'];
$filter=$_GET['filter'];
$id=$_GET['id'];
//echo $menu."=menu<br>";
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin($pararray['headline']);

$db = new SQLite3('../data/joorgsqlite.db');

$sql=showtabfilter($filter,$filterarray,$pararray,$menu);

showtabfunc($menu,$sql,$id);

$dbselarr=array();
$results = $db->query($sql);
//echo $sql."<br>";
echo "<table class='table table-hover'>";
echo "<tr>";
foreach ( $listarray as $arrelement ) {
  if ($arrelement['fieldhide']!="true") {
    switch ( $arrelement['type'] )
    {
      case 'icon':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'nummer':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'show':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'text':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'select':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'selectid':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'selectref':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'selectshow':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'time':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'date':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'calcaddsum':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'calcdiffsum':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'calcdiff':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'calc':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'calcsum':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'prozref':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'proz':
        echo "<th>".$arrelement['label']."</th>";
      break;
      case 'timestamp':
        echo "<th>".$arrelement['label']."</th>";
      break;
    }
  }
}
echo "</tr>";

$filterwhere="";
foreach ( $filterarray as $arrelement ) {
  $wert="";	
  $sqlfilter="SELECT * FROM tblfilter WHERE fldName='".$arrelement['name']."' AND fldtablename='".$pararray['dbtable']."'";
  $resfilter = $db->query($sqlfilter);
  if ($rowfilter = $resfilter->fetchArray()) {
    $wert=$rowfilter['fldwert'];
  }
  if ($wert<>"(ohne)" && $wert<>"") { 
    $sign=$arrelement['sign'];
    if ($sign==">=") {
      $sign="<";
    }
    if ($filterwhere=="") {
      $filterwhere = " WHERE ".$arrelement['dbfield'].$sign."'".$wert."'";
    } else {
  	   $filterwhere = $filterwhere." AND ".$arrelement['dbfield'].$sign."'".$wert."'";
    }
  }  
  //echo $sqlfilter."<br>";
}

$calcsum=0;
if ($pararray['calcsum']=='J') {
  if ($filterwhere<>"") {
    if ($pararray['dellogical']=="J") {	
      $filterwhere=$filterwhere." AND flddel='N'";
    }  
    $sqlbetrag="SELECT sum(fldBetrag) as sumbetrag FROM ".$pararray['dbtable'].$filterwhere;
    $resbetrag = $db->query($sqlbetrag);
    if ($rowbetrag = $resbetrag->fetchArray()) {
      $calcsum=$rowbetrag['sumbetrag'];
    }
  } 
}   
//echo $filterwhere."=filterwhere<br>";
//echo $calcsum."=calcsum<br>";

$nummer=0;
$prozsum=0;
$count=0;
//$calcsum=0;
//$calcsum=8.16;
$sum=$calcsum;
$summe=$sum;
$sumcalc=0;
$sumdiff=0;
while ($row = $results->fetchArray()) {
  if ($pararray['getindex']<>"") {	
    $index=$row[$pararray['getindex']];	
  } else {
    $index=$row[$pararray['fldindex']];	
  }  
  //echo $index."=index<br>";
  if ($pararray['markseldb']=="J") {
  	 $summe=$summe+$row['fldBetrag'];
  	 //echo "#".number_format($row['fldFix'],2).",".$summe."#<br>";
    if ($row['fldFix']<>"") {
      if (number_format($row['fldFix'],2)==number_format($summe,2)) {
        echo "<tr bgcolor=#00ff00>";
      } else {  
        echo "<tr bgcolor=#ff6699>";
      }  
    } else {
      echo "<tr>";
    }
  } else {  
    echo "<tr>";
  }  
  foreach ( $listarray as $arrelement ) {
    if ($arrelement['fieldhide']!="true") {
      switch ( $arrelement['type'] )
      {
        case 'icon':
            echo "<td><a href='".$arrelement['func']."&id=".$row['fldindex']."' class='btn btn-primary btn-sm active' role='button'>".$arrelement['label']."</a></td> ";
        break;
        case 'nummer':
          $nummer=$nummer+1;
          echo "<td>".$nummer."</td>";
        break;
        case 'show':
          echo "<td>".$row[$arrelement['dbfield']]."</td>";
        break;
        case 'timestamp':
          echo "<td>".$row[$arrelement['dbfield']]."</td>";
        break;
        case 'text':
          $linkfield="";
          $linkwert="";
          if (isset($arrelement['linkfield'])) {
            $linkfield=$arrelement['linkfield'];        
            if ($linkwert=="") {
              $linkwert=$row[$linkfield];
            }
          }
          $targetfield="";
          if (isset($arrelement['targetfield'])) {
            $targetfield=$arrelement['targetfield'];        
          }
        
          if ($arrelement['grafiklink']=="J") {
            echo "<td><a href='".$arrelement['grafikurl']."?id=".$id."&etagenid=".$row[$arrelement['grafiketageid']]."&roomtyp=".$arrelement['roomtyp']."&menu=".$menu."'>".$row[$arrelement['dbfield']]."</a></td>";
          } else {	
            if ($linkwert!="") {
              if ($line[$targetfield]!="") {
                echo "<td><a href='".$linkwert."' target='".$targetfield."'>".$row[$arrelement['dbfield']]."</a></td>";
              } else {
                echo "<td><a href='".$linkwert."' >".$row[$arrelement['dbfield']]."</a></td>";
              }  
            } else {
              echo "<td>".$row[$arrelement['dbfield']]."</td>";
            }
          }
        break;
        case 'select':
          echo "<td>".$row[$arrelement['dbfield']]."</td>";
        break;
        case 'selectid':
          $selid=$row[$arrelement['dbfield']];
          if ($selid=="") {
            $selid='0';          
          }
          $sqlsel = "SELECT * FROM ".$arrelement['dbtable']." WHERE ".$arrelement['seldbindex']."=".$selid;
          //echo $sqlsel."<br>";           
          $ressel = $db->query($sqlsel);
          $arrsel=array();
          while ($rowsel = $ressel->fetchArray()) {
          	$arrsel=$rowsel;
          }	
          if (isset($arrsel)) {
          	//$bez=$arrsel[$arrelement['seldbfield']];
            $arrdbfield = explode(",", $arrelement['seldbfield']);
        	   $arrcnt=count($arrdbfield);
            $bez=$arrsel[$arrdbfield[0]];
        	   for ($i = 1; $i < $arrcnt; $i++) {
              $bez=$bez.",".$arrsel[$arrdbfield[$i]];
            }
          } else {
          	$bez="";
          }
          //echo $bez."=bez<br>";	
          echo "<td>".$bez."</td>";
        break;
        case 'selectref':
          $pos = strpos($sql, "JOIN");
          if ($pos !== false) {
            $sqlsel = "SELECT * FROM ".$arrelement['dbtable']." WHERE ".$arrelement['fldindex']."=".$row[$arrelement['fldindex']];
          } else {
            $sqlsel = "SELECT * FROM ".$arrelement['dbtable']." WHERE ".$arrelement['fldindex']."=".$row[$arrelement['dbindex']];
          }  
          //echo $sqlsel."<br>";
          $ressel = $db->query($sqlsel);
          echo "<td>";
          echo "<select name='".$arrelement['name']."' size='1'>";
          while ($rowsel = $ressel->fetchArray()) {
            $sqlref = "SELECT * FROM ".$arrelement['reftable']." WHERE ".$arrelement['fldrefindex']."=".$rowsel[$arrelement['dbrefindex']];
            $resref = $db->query($sqlref);
            $bez="<unbekannt>";
            if ($rowref = $resref->fetchArray()) {
              $bez=$rowref[$arrelement['dbfield']];
            }
            echo "<option style='background-color:#c0c0c0;' >".$bez."</option>";
          }
          echo "</select>";
          echo "</td>";
        break;
        case 'selectshow':
		  $wert="";
          $sqlsel = "SELECT * FROM ".$arrelement['dbtable']." WHERE ".$arrelement['seldbfield']."='".$row[$arrelement['selfield']]."'";
          $ressel = $db->query($sqlsel);
          if ($rowsel = $ressel->fetchArray()) {
		    $wert=$rowsel[$arrelement['seldbbez']];
		  }
		  //echo $sqlsel."<br>";
          echo "<td>".$wert."</td>";
        break;
        case 'time':
          echo "<td>".$row[$arrelement['dbfield']]."</td>";
        break;
        case 'date':
          echo "<td>".$row[$arrelement['dbfield']]."</td>";
        break;
        case 'calcaddsum':
          $nachkomma=2;
          $wert=strval($row[$arrelement['dbfield']]);
          if ($arrelement['calcfield']!="") {
            $wert=$wert - strval($row[$arrelement['calcfield']]);
            $wert=$wert * strval($arrelement['calcfix']);
            $zeitpreis=strval($row[$arrelement['calcaddfield']])*strval($row[$arrelement['calcadddbfield']]);
            //echo $arrelement['calcaddfield']."<br>"; 
            $wert=$wert + $zeitpreis;
          }
          $sumadd=$sumadd+$wert;
          echo "<td style='text-align:right;padding-right:10px;' width='".$arrelement['width']."'>".sprintf("%.".$nachkomma."f",$wert)."</td>";
        break;
        case 'calcdiffsum':
          $nachkomma=2;
          $wert=strval($row[$arrelement['dbfield']]);
          if ($arrelement['calcfield']!="") {
            $wert=$wert - strval($row[$arrelement['calcfield']]);
            $wert=$wert * strval($arrelement['calcfix']);
          }
          $sumdiff=$sumdiff+$wert;
          echo "<td style='text-align:right;padding-right:10px;' width='".$arrelement['width']."'>".sprintf("%.".$nachkomma."f",$wert)."</td>";
        break;
        case 'calcdiff':
          $nachkomma=0;
          $wert=strval($row[$arrelement['dbfield']]);
          if ($arrelement['calcfield']!="") {
            $wert=$wert - strval($row[$arrelement['calcfield']]);
          }
          echo "<td style='text-align:right;padding-right:10px;' width='".$arrelement['width']."'>".sprintf("%.".$nachkomma."f",$wert)."</td>";
        break;
        case 'calc':
          $nachkomma=2;
          $wert=strval($row[$arrelement['dbfield']]);
          if ($arrelement['calcfield']!="") {
            $wert=$wert * strval($row[$arrelement['calcfield']]);
          }
          $sum=$sum+$wert;
      	 $sumcalc=$sumcalc+$wert;
          echo "<td style='text-align:right;padding-right:10px;' width='".$arrelement['width']."'>".sprintf("%.".$nachkomma."f",$wert)."</td>";
        break;
        case 'calcsum':
          $nachkomma=2;
          $wert=strval($row[$arrelement['dbfield']]);
          //$calcsum=$calcsum+$wert+$startsum;
          $calcsum=$calcsum+$wert;
          echo "<td style='text-align:right;padding-right:10px;' width='".$arrelement['width']."'>".sprintf("%.".$nachkomma."f",$calcsum)."</td>";
        break;
        case 'prozref':
          //echo "<br>";
          $nachkomma=1;
          $count=$count+1;
          $wert=0;
          $sqlfil="SELECT * FROM tblfilter WHERE (fldtablename='tblorte' OR fldtablename='tbletagen') AND fldfeld='fldid_suchobj'";
          $resfil = $db->query($sqlfil);
          if ($rowfil = $resfil->fetchArray()) {
            if ($rowfil['fldwert']<>"(ohne)") {
              $sqlsuch="SELECT * FROM tblsuchobj WHERE fldbez='".$rowfil['fldwert']."'";
              $ressuch = $db->query($sqlsuch);
              if ($rowsuch = $ressuch->fetchArray()) {
              	 //echo $rowfil['fldtablename']."=tablename<br>";
                $refwhere="fldid_suchobj=".$rowsuch['fldindex']." AND ".$arrelement['roomid']."=".$row['fldindex'];
                $sqlref="SELECT * FROM tblrefsuchobj WHERE ".$refwhere;
 //echo $sqlref."<br>";
                $resref = $db->query($sqlref);
                if ($rowref = $resref->fetchArray()) {
             	   $wert=strval($rowref[$arrelement['dbfield']]);
                }
              }
            }
          }        
          $prozsum=$prozsum+$wert;
          $prozposdif=100-$wert;
          echo "<td style='text-align:right;padding-right:10px;' width='".$arrelement['width']."'>";
          echo "<div style='float:left; background-color:darkgreen; color:lightgreen; height:16px; width:".$wert."px; top:0; left:0;' align=center></div>";
          echo "<div style='float:left; background-color:lightgreen; color:white; height:16px; width:".$prozposdif."px; top:0; left:0;' align=center></div>";
          echo sprintf("%.".$nachkomma."f",$wert)."</td>";
        break;
        case 'proz':
          $nachkomma=1;
          $count=$count+1;
          $wert=strval($row[$arrelement['dbfield']]);
          $prozsum=$prozsum+$wert;
          $prozposdif=100-$wert;
          echo "<td style='text-align:right;padding-right:10px;' width='".$arrelement['width']."'>";
          echo "<div style='float:left; background-color:darkgreen; color:lightgreen; height:16px; width:".$wert."px; top:0; left:0;' align=center></div>";
          echo "<div style='float:left; background-color:lightgreen; color:white; height:16px; width:".$prozposdif."px; top:0; left:0;' align=center></div>";
          echo sprintf("%.".$nachkomma."f",$wert)."</td>";
        break;
      }
    }
  }
  echo "<td><a href='mark.php?menu=".$menu."&id=".$index."' class='btn btn-primary btn-sm active' role='button'>OK</a></td> ";
  echo "<td><a href='update.php?menu=".$menu."&id=".$index."' class='btn btn-primary btn-sm active' role='button'>U</a></td> ";
  echo "<td><a href='delete.php?menu=".$menu."&id=".$index."' class='btn btn-primary btn-sm active' role='button'>D</a></td>";
  echo "</tr>";
  $menge = array_push ( $dbselarr, $row[$pararray['fldindex']] );
}
$_SESSION['DBSELARR']=$dbselarr;
echo "<tr>";
foreach ( $listarray as $arrelement ) {
  if ($arrelement['fieldhide']!="true") {
    switch ( $arrelement['type'] )
    {
      case 'nummer':
        echo "<td></td>";
      break;
      case 'text':
        echo "<td></td>";
      break;
      case 'select':
        echo "<td></td>";
      break;
      case 'selectid':
        echo "<td></td>";
      break;
      case 'date':
        echo "<td></td>";
      break;
      case 'time':
        echo "<td></td>";
      break;
      case 'calcdiffsum':
        $nachkomma=2;
        echo "<td style='text-align:right;padding-right:10px;'>".sprintf("%.".$nachkomma."f",$sumdiff)."</td>";
      break;
      case 'calcdiff':
        echo "<td></td>";
      break;
      case 'calc':
        $nachkomma=2;
        echo "<td style='text-align:right;padding-right:10px;'>".sprintf("%.".$nachkomma."f",$sumcalc)."</td>";
      break;
      case 'calcaddsum':
        $nachkomma=2;
        echo "<td style='text-align:right;padding-right:10px;'>".sprintf("%.".$nachkomma."f",$sumadd)."</td>";
      break;
      case 'prozref':
        $nachkomma=1;
        $wert=$prozsum / $count;
        $prozposdif=100-$wert;
        echo "<td style='text-align:right;padding-right:10px;' width='".$arrelement['width']."'>";
        echo "<div style='float:left; background-color:darkgreen; color:lightgreen; height:16px; width:".$wert."px; top:0; left:0;' align=center></div>";
        echo "<div style='float:left; background-color:lightgreen; color:white; height:16px; width:".$prozposdif."px; top:0; left:0;' align=center></div>";
        echo sprintf("%.".$nachkomma."f",$wert)."</td>";
      break;
      case 'proz':
        $nachkomma=1;
        $wert=$prozsum / $count;
        $prozposdif=100-$wert;
        echo "<td style='text-align:right;padding-right:10px;' width='".$arrelement['width']."'>";
        echo "<div style='float:left; background-color:darkgreen; color:lightgreen; height:16px; width:".$wert."px; top:0; left:0;' align=center></div>";
        echo "<div style='float:left; background-color:lightgreen; color:white; height:16px; width:".$prozposdif."px; top:0; left:0;' align=center></div>";
        echo sprintf("%.".$nachkomma."f",$wert)."</td>";
      break;
    }
  }
}
echo "</tr>";
echo "</table>";
bootstrapend();
?>