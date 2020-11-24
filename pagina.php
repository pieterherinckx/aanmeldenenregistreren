<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
  <?php
  if(isset($_SESSION['aangemeld'])){
    echo "Hallo ".$_SESSION['gebruikersnaam'];
  }
  else {
    echo "Hallo vreemdeling";
  }
  ?>
  </body>
</html>
