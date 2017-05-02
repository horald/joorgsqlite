<?php

function updatetable($newvers) {
  $pfad="../sites/update/";	
  $datei="Updatetable".$newvers.".sql";
  if (file_exists($pfad.$datei)) {
    $handfile = fopen($pfad.$datei, "r");
    if ($handfile) {
      $db = new SQLite3('../data/joorgsqlite.db');
      echo "<div class='alert alert-info'>";
      while (($line = fgets($handfile)) !== false) {
     	  $db->exec($line);
        echo $line."<br>";
      }
      echo "</div>";
      $db->close();
      fclose($handfile);
      echo "<div class='alert alert-success'>";
      echo "Daten von ".$datei." eingelesen!";
      echo "</div>";
    } else {
      echo "<div class='alert alert-danger'>";
      echo "Öffnen von ".$datei." fehlgeschlagen!";
      echo "</div>";
    }
  } else {
    echo "<div class='alert alert-danger'>";
    echo "Keine Updatedatei ".$datei." gefunden!";
    echo "</div>";
  }   
}

function checkupdatefiles($newvers,$oldvers) {
  $pfad="../sites/update/";	
  $handle=opendir ($pfad);
  
  while($getdatei=readdir($handle)){
    $dat_array[] = $getdatei;
  }
  sort($dat_array);
  
  //echo "Verzeichnisinhalt:".$oldvers."<br>";
  foreach($dat_array as $datei) {
  //while ($datei = readdir ($handle)) {
  	 $substr=substr($datei,-4);
  	 if ($substr==".sql") {
  	 	$substr=substr($datei,6,strlen($datei)-10);
  	 	if ($oldvers<=$substr) {
        //echo "$substr , $datei<br>";
        
        $handfile = fopen($pfad.$datei, "r");
        if ($handfile) {
          $db = new SQLite3('../data/joorgsqlite.db');
          while (($line = fgets($handfile)) !== false) {
          	$db->exec($line);
            //echo $line."<br>";
          }
          $db->close();
          fclose($handfile);
          echo "<div class='alert alert-success'>";
          echo "Daten von ".$datei." eingelesen!";
          echo "</div>";
        } else {
          echo "<div class='alert alert-danger'>";
          echo "Öffnen von ".$datei." fehlgeschlagen!";
          echo "</div>";
        }         
        
      }  
    }   
  }
  closedir($handle);
}

function updatedbversion($newversion,$versdat) {
  $db = new SQLite3('../data/joorgsqlite.db');
  $sql = "INSERT INTO tblversion (fldbez,fldversion,flddatum) VALUES ('Version ".$newversion."','".$newversion."','".$versdat."')";
  $db->exec($sql);
  echo "<div class='alert alert-success'>";
  echo "Neue Version ".$newversion." vom ".$versdat." aktualisiert.<br>";
  echo $db->lastErrorMsg()."<br>";
  echo "</div>";
  //echo $sql."<br>";
}

function checktables($tablearray) {
  $anznew=0;
  $anzmodify=0;
  $newtables="";
  $mdytables="";
  $db = new SQLite3('../data/joorgsqlite.db');
  $sql="DELETE FROM tbltable ";
  $results = $db->query($sql);
  foreach ( $tablearray as $arrelement ) {
  	 //echo $arrelement['tablename']."<br>";
  	 $sql="SELECT name FROM sqlite_master WHERE type='table' AND name='".$arrelement['tablename']."'";
    $results = $db->query($sql);
    while ($row = $results->fetchArray()) {
      $arr=$row;
    }	
    $typ="exist";
    if ($arrelement['tablename']<>$arr['name']) {
    	$sql=$arrelement['sql'];
    	$typ="new";
      if ($newtables=="") {
        $newtables=$arrelement['tablename'];
      } else {
        $newtables=$newtables.",".$arrelement['tablename'];
      } 
  	   $anznew=$anznew+1;
  	   $db->exec($sql);
  	 } else {
  	 }
    $qryins="INSERT INTO tbltable (fldbez,fldtyp) VALUES ('".$arrelement['tablename']."','".$typ."')";
	 $db->exec($qryins);
  }  
  foreach ( $tablearray as $arrelement ) {
  	 $sql="SELECT sql FROM sqlite_master WHERE type='table' AND name='".$arrelement['tablename']."'";
    $results = $db->query($sql);
    if ($row = $results->fetchArray()) {
      if ($arrelement['sql']<>$row['sql']) {
        if ($mdytables=="") {
          $mdytables=$arrelement['tablename'];
        } else {
          $mdytables=$mdytables.",".$arrelement['tablename'];
        } 
        $anzmodify=$anzmodify+1;
        $pos = strpos($row['sql'], '(', 0);
        $column=substr($row['sql'],$pos+1,-1);
        $column=str_replace(chr(34),"",$column);
        $column=str_replace("text NULL","TEXT",$column);
        //echo "<br>".$column."<br>";	
        echo "<br>";
        $colarr = explode(",", $column);
        $count=sizeof($colarr); 
        for ( $x = 0; $x < $count; $x++ ) {
        	 $colarr[$x]=trim($colarr[$x]);
        } 
        $newcol=$arrelement['column'];
        $count=sizeof($newcol); 
        for ( $x = 0; $x < $count; $x++ ) {
        	 $newcol[$x]=trim($newcol[$x]);
        } 
        //foreach ( $colarr as $colelement ) { 
        //  echo $colelement.",".strlen($colelement)."=old<br>";
        //}       
        foreach ( $newcol as $colelement ) { 
          if (in_array($colelement, $colarr)) {
            //echo $colelement.",ok=new<br>";
          } else {
            echo $colelement.",".strlen($colelement).",no=new<br>";
          }
        }       
      }
    }	
  }
  echo "<div class='alert alert-success'>";
  if ($anznew==0) {
  	 echo "Keine Tables angelegt<br>";
  } else {
    echo $anznew." Tables angelegt. (".$newtables.")<br>";
  }
  if ($anzmodify==0) {
  	 echo "Keine Tables geändert";
  } else {
    echo $anzmodify." Tables geändert. (".$mdytables.")";
  }
  echo "</div>";
  
  $db->close();
}

?>