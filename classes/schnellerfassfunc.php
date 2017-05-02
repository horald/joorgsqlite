<?php
header("content-type: text/html; charset=utf-8");
function schnellerfass_abfrage($listarray,$menu) {
  $db = new SQLite3('../data/joorgsqlite.db');
  echo "<a href='showtab.php?menu=".$menu."' class='btn btn-primary btn-sm active' role='button'>Zurück</a>"; 
  echo "<form class='form-horizontal' method='post' action='schnellerfass.php?schnellerfass=1&menu=".$menu."'>";
  foreach ( $listarray as $arrelement ) {
    if (!(($arrelement['fieldsave']=="NO") || ($arrelement['schnellerfass']=="NO"))) {
      $default="";
      $defwert='';
      if ($arrelement['default']!="") {
        $default=$arrelement['default'];
      }
      if ($arrelement['name']<>"") {
        if ($arrelement['getdefault']=="true") {
          $defquery="SELECT * FROM tblfilter WHERE fldmaske='".strtoupper($menu)."_DEFAULT' AND fldName='".$arrelement['name']."'";
          $defresult = $db->query($defquery);
          if ($defrow = $defresult->fetchArray()) {
        	 $defwert=$defrow['fldwert'];
          }	
        }  
      }  
      if ($arrelement['schnellerfass']=="key") {
        echo "<input type='hidden' name='key' value='".$arrelement['dbfield']."'/>";
	  }
      if ($arrelement['schnellerfass']=="ort") {
        echo "<input type='hidden' name='ort' value='".$arrelement['dbfield']."'/>";
	  }
      switch ( $arrelement['type'] )
      {
        case 'text':
		    if ($defwert<>"") {
		      $default=$defwert;
		    }
          if ($arrelement['barcode']=="YES") {
            if ($_GET['barcode']<>"") {
		    	  $default=substr($_GET['barcode'],0,13);
		      }
		    }  	
          echo "<dl>";
          echo "<dt><label >".$arrelement['label'].":</label></dt>";
          echo "<dd><input type='text' name='".$arrelement['dbfield']."' value='".$default."'/> ";
          if ($arrelement['barcode']=="YES") {
            echo "<a href='getbarcode.php?menu=".$menu."' class='btn btn-info' role='button'>Barcode</a>";
          }  
          echo "</dd>";
          echo "</dl>";
          break;
        case 'select':
		  $seldbwhere="";
          if ($arrelement['seldbwhere']<>"") {
            $seldbwhere=" WHERE ".$arrelement['seldbwhere'];
          }
          $sqlsel="SELECT * FROM ".$arrelement['dbtable'].$seldbwhere;
          $ressel = $db->query($sqlsel);
          echo "<dl>";
          echo "<dt><label >".$arrelement['label'].":</label></dt>";
          echo "<select name='".$arrelement['dbfield']."' size='1'>";
          echo "<option style='background-color:#c0c0c0;' >(ohne)</option>";
          while ($rowsel = $ressel->fetchArray()) {
            if ($defwert==$rowsel[$arrelement['seldbfield']]) {
              echo "<option style='background-color:#c0c0c0;' selected>".$rowsel[$arrelement['seldbfield']]."</option>";
            } else {
              echo "<option style='background-color:#c0c0c0;' >".$rowsel[$arrelement['seldbfield']]."</option>";
            }
          }
          echo "</select> ";
          echo "</dl>";
		  break;
      }
    }
  }
  echo "<input type='checkbox' name='chkanzeigen' value='anzeigen'> Speichern anzeigen<br>";
  echo "<dd><input type='submit' name='submit' value='Hinzufügen' /> ";
  echo "<input type='submit' name='submit' value='Aktualisieren' /> ";
  echo "<input type='submit' name='submit' value='vermindern' /></dd>";
  echo "</form>";  
}
function schnellerfass_verarbeiten($pararray,$listarray,$submit,$key,$keyvalue,$keyort,$ortvalue,$show,$autoinc_start,$autoinc_step,$menu) {
  $db = new SQLite3('../data/joorgsqlite.db');
  $dbtable=$pararray['dbtable'];
  $select="SELECT * FROM ".$dbtable." WHERE ".$key."='".$keyvalue."' AND ".$keyort."='".$ortvalue."'";
  $results = $db->query($select);
  if ($row = $results->fetchArray()) {
    $anz=0;
    $sql="UPDATE ".$dbtable." SET ";
    foreach ( $listarray as $arrelement ) {
      if ($arrelement['fieldsave']<>"NO") {
        switch ( $arrelement['schnellerfass'] ) {
          case 'anz':
            switch ( $submit ) {
              case 'Hinzufügen':	
			    $chgwert=$_POST[$arrelement['dbfield']]; 
                $anz=$row[$arrelement['dbfield']]+$_POST[$arrelement['dbfield']];
                break;
              case 'Aktualisieren':	
                $anz=$_POST[$arrelement['dbfield']];
                break;
              case 'vermindern':	
			    $chgwert=$_POST[$arrelement['dbfield']]; 
                $anz=$row[$arrelement['dbfield']]-$_POST[$arrelement['dbfield']];
                break;
            }
            $sql=$sql.$arrelement['dbfield']."='".$anz."', ";
          break;  
        }
      }
    } 
    $sql=substr($sql,0,-2);
    $sql=$sql." WHERE fldindex=".$row['fldindex'];
  } else {
    $sqlid="SELECT * FROM tblindex WHERE fldtable='".$pararray['dbtable']."'";
    //echo $sqlid."<br>";
    $resid = $db->query($sqlid);
    if ($rowid = $resid->fetchArray()) {
      $newrowid=$rowid['fldid'] + $autoinc_step;
      //echo $newrowid."=newrowid<br>";
    } else {
      $newrowid=$autoinc_start;  
    }
    //echo "INSERT<br>";
    $sql="INSERT INTO ".$dbtable." (".$pararray['fldindex'].",";
    foreach ( $listarray as $arrelement ) {
  	  if ($arrelement['fieldsave']<>"NO") {
	    $sql=$sql.$arrelement['dbfield'].",";
      }
    } 
    $sql=substr($sql,0,-1);
    if ($pararray['dbsyncnr']=="J") {
   	  $sql=$sql.",flddbsyncnr";
  	  $sql=$sql.",fldtimestamp";
    }  
    $sql=$sql.") VALUES (".$newrowid.",";
    foreach ( $listarray as $arrelement ) {
  	  if ($arrelement['fieldsave']<>"NO") {
  	    if ($arrelement['schnellerfass']=="anz") {
		  $chgwert=$_POST[$arrelement['dbfield']];
		}
        $sql=$sql."'".$_POST[$arrelement['dbfield']]."',";
	  }
	}  
    $sql=substr($sql,0,-1);
    if ($pararray['dbsyncnr']=="J") {
  	  $sql=$sql.",".$autoinc_start;
  	  $sql=$sql.",datetime('now', 'localtime')";
    }
    $sql=$sql.")";
	
    $sqlupd="UPDATE tblindex SET fldid=".$newrowid."  WHERE fldtable='".$pararray['dbtable']."'";
    $db->exec($sqlupd);
	
  }
  $db->exec($sql);

  $artikel=""; 
  $qryart="SELECT * FROM tblartikel WHERE ".$key."='".$keyvalue."'"; 
  //echo $qryart."<br>";
  $resart = $db->query($qryart);
  if ($rowart = $resart->fetchArray()) {
    $artikel=" (".$rowart['fldBez'].")";
  }
  echo "<div class='alert alert-success'>";
  switch ( $submit ) {
    case 'Hinzufügen':	
	  echo "Artikelbestand von ".$keyvalue.$artikel." mit ".$chgwert." auf ".$anz." erhöht.<br>";
      break;
    case 'Aktualisieren':	
	  echo "Artikelbestand von ".$keyvalue.$artikel." auf ".$anz." aktualisiert.<br>";
      break;
    case 'vermindern':	
	  echo "Artikelbestand von ".$keyvalue.$artikel." mit ".$chgwert." auf ".$anz." vermindert.<br>";
      break;
  }
  echo "</div>";  
  
    foreach ( $listarray as $arrelement ) {
  	  if ($arrelement['fieldsave']<>"NO") {
        if ($arrelement['getdefault']=="true") {
            $sqlflt="SELECT * FROM tblfilter WHERE fldmaske='".strtoupper($menu)."_DEFAULT' AND fldName='".$arrelement['name']."'";
            //echo $sqlflt."<br>";
            $resflt = $db->query($sqlflt);
            if ($rowflt = $resflt->fetchArray()) {
              $sqldef="UPDATE tblfilter SET fldwert='".$_POST[$arrelement['dbfield']]."' WHERE fldmaske='".strtoupper($menu)."_DEFAULT' AND fldName='".$arrelement['name']."'"; 
            } else {
              $sqldef="INSERT INTO tblfilter (fldmaske,fldName,fldwert) VALUES('".strtoupper($menu)."_DEFAULT','".$arrelement['name']."','".$_POST[$arrelement['dbfield']]."')";
            }
            //echo $sqldef."<br>";
            $qrydef = $db->exec($sqldef);  
        }
      }
	}
	
  if ($show=="anzeigen") {
    echo "<div class='alert alert-success'>";
    echo $sql."<br>";
    echo $db->lastErrorMsg()."<br>";
    echo "</div>";
  }  
	  
}
?>