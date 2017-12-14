<?php
include("bootstrapfunc.php");
bootstraphead();
bootstrapbegin("Hochladen");
$menu=$_GET['menu'];
echo "<a href='showtab.php?menu=".$menu."' class='btn btn-primary btn-sm active' role='button'>Zurück</a>"; 
echo "      <form action='uploadfunc.php?menu=".$menu."' method='post' enctype='multipart/form-data'>";
echo "         <input type='file' name='datei'><br>";
echo "         <input type='submit' value='Hochladen'>";
echo "      </form>";
bootstrapend();
?>