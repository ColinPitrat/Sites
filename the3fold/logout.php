<?php
  session_start();
  header("Cache-control: private");
  require("./include/cadre.php");
  
  top("membres.php");
  
  $_SESSION["authent"]=0;
  session_destroy();
  bottom();
?> 
