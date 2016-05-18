<?php 
 session_start();
if (isset($_GET['distanza'])) {
 
 print json_encode ($_SESSION['distanza']);
} 
if (isset($_GET['latitudine'])) {
    
    print json_encode ($_SESSION['latitudine']);
} 
if (isset($_GET['longitudine'])) {
    
  print json_encode   ($_SESSION['longitudine']);
} 
if (isset($_GET['requested'])) {
    
  print json_encode   ($_SESSION['origine']);
} 
?>