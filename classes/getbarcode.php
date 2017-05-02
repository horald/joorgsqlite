<?php
include("bootstrapfunc.php");
bootstraphead();
bootstrapbegin("Getbarcode");
$menu=$_GET['menu'];
echo "<script>";
echo "function barcode(cmenu) {";
echo "var url='schnellerfass.php';";
echo "var lbarcode=document.getElementById('decoded');";
echo "var cbarcode='';";
echo "var lis = lbarcode.children;";
echo "for(var i = 0; i < lis.length; i++) {";
echo "    cbarcode=lis[i].innerHTML;"; 
echo "}";
echo "window.location.href='schnellerfass.php?menu=vorrat&barcode='+cbarcode;";
echo "}";
echo "</script>";
echo "<a href='javascript:barcode();' class='btn btn-primary btn-sm active' role='button'>Zurück</a>"; 
echo "<div>";
echo "  <video autoplay></video>";
echo "  <div id='inner'></div>";
echo "  <div id='redline'></div>";
echo "</div>";
echo "<ul id='decoded'>Barcodes:</ul>";
echo "<canvas style='display:none;'></canvas>";
echo "<script src='barcode.js'></script>";


bootstrapend();
?>