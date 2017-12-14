<?php
  include("bootstrapfunc.php");
  bootstraphead();
  bootstrapbegin("Installation");
  $dir=getcwd();

  $file = $dir.'/install/joorgsqlite.db';
  $newfile = $dir.'/data/joorgsqlite.db';

  if (!copy($file, $newfile)) {
    echo "<div class='alert alert-warning'>";
    echo "copy $file schlug fehl...\n<br>";
    echo "Installation der Datenbank (".$file.") fehlgeschlagen!";
    echo "</div>";
  } else {
    echo "<div class='alert alert-success'>";
    echo "Datenbank erfolgreich installiert. (".$newfile.")";
    echo "</div>";
  }
  bootstrapend();  
?>