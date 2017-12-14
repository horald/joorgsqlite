<?php
include("bootstrapfunc.php");
include("delfilefunc.php");
bootstraphead();
bootstrapbegin('Datei löschen');
$id=$_GET['id'];
$del=$_GET['del'];
if ($del==1) {
  if ($_POST['Abbruch']=='Abbrechen') {
    echo "Abbruch";
  } else {
    delfiledelete();
  }
  echo "<meta http-equiv='refresh' content='0; URL=filemanager.php?menu=filemanager&id=".$id."'>";  
} else {
  delfileinput();
}  
bootstrapend();
  
  
?>