<?php
$menugrp=$_GET['menugrp'];
echo "<html>";
echo "<head>";
echo "  <meta charset='utf-8'>";
echo "  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>";
echo "  <title>Joorgsqlite</title>";

//      <!-- Bootstrap -->
echo "  <link href='../includes/bootstrap/css/bootstrap.min.css' rel='stylesheet'>";

echo "</head>";
echo "<body>";
echo "<div>";
echo "<h1 align='center'>Joorgportal (Admin)</h1>";
echo "<a href='../index.php?menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Home</a>"; 
//echo "<a href='index.php?menu=SUBMENU&menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Menü</a>"; 
echo "<a href='../classes/showtab.php?menu=menu&menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Menü</a>"; 
echo "<a href='../classes/showtab.php?menu=menugrp&menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Menügruppe</a>"; 
echo "<a href='../classes/showtab.php?menu=menuzuord&menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Menüzuordnung</a>"; 
echo "<a href='../classes/mksqlstruc.php?menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Make SQL-Struc</a>"; 
echo "<a href='../classes/showtab.php?menu=version&menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Version</a>"; 
echo "<a href='../classes/showtab.php?menu=func&menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Funktionen</a>"; 
echo "<a href='../classes/remotetool.php?menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Remote-Tool</a>"; 
echo "<a href='../classes/showtab.php?menu=table&menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Tables</a>"; 
echo "<a href='../classes/showtab.php?menu=helppage&menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Hilfeseiten</a>"; 
echo "<a href='../classes/showtab.php?menu=helprows&menugrp=".$menugrp."' class='btn btn-default btn-lg btn-block' role='button'>Hilfeinhalt</a>"; 
echo "<a href='../classes/dbadmin.php' class='btn btn-default btn-lg btn-block' role='button'>DB Admin</a>"; 
echo "<a href='../classes/autoincupdate.php' class='btn btn-default btn-lg btn-block' role='button'>autoincupdate</a>"; 
echo "</div>";
echo "</body>";
echo "</html>";
?>