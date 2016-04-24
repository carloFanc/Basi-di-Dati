<?php 
 session_start();
if (isset($_GET['distanza'])) {
    // return requested value
 print json_encode ($_SESSION['distanza']);
} 
if (isset($_GET['latitudine'])) {
    // return requested value
    print json_encode ($_SESSION['latitudine']);
} 
if (isset($_GET['longitudine'])) {
    // return requested value
  print json_encode   ($_SESSION['longitudine']);
} 
if (isset($_GET['requested'])) {
    // return requested value
  print json_encode   ($_SESSION['origine']);
} 
?>