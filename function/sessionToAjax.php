<?php 
 session_start();
if (isset($_GET['distanza'])) {
    // return requested value
 echo $_SESSION['distanza'];
} 
if (isset($_GET['latitudine'])) {
    // return requested value
     $_SESSION['latitudine'];
} 
if (isset($_GET['longitudine'])) {
    // return requested value
     $_SESSION['longitudine'];
} 
?>