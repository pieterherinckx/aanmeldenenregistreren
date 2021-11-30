<?php
  include_once("inc/conn.inc.php");
  session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
      <?php
      // verwerken van invoerformulier
      if(isset($_GET['actie']) && $_GET['actie']=="invoeren"){
        $titel=$_POST['titel'];
        $omschrijving=$_POST['omschrijving'];
        $uitbrengjaar=$_POST['uitbrengjaar'];
        $taal_id=$_POST['taal_id'];
        $extra_taal_id=$_POST['extra_taal_id'];
        $verhuurtijd=$_POST['verhuurtijd'];
        $verhuurkost=$_POST['verhuurkost'];
        $lengte=$_POST['lengte'];
        $vervangingskost=$_POST['vervangingskost'];

        $query = "INSERT INTO tbl_film(titel, omschrijving, uitbrengjaar, taal_id, extra_taal_id, verhuurtijd, verhuurkost, lengte, vervangingskost) VALUES ('$titel', '$omschrijving', $uitbrengjaar, $taal_id, $extra_taal_id, $verhuurtijd, $verhuurkost, $lengte, $vervangingskost)";
        echo $query;
        mysqli_query($conn, $query);
      }

      // tonen invoerformulier
      else if(isset($_GET['actie']) && $_GET['actie']=="invoerformulier"){
        echo "
        <h1>Nieuwe film invoeren</h1>
        <form action='?actie=invoeren' method='post'>
          <div class='mb-3'>
            <label for='titel' class='form-label'>Titel:</label>
            <input type='text' class='form-control' name='titel'>
          </div>
          <div class='mb-3'>
            <label for='omschrijving' class='form-label'>Omschrijving:</label>
            <input type='text' class='form-control' name='omschrijving'>
          </div>
          <div class='mb-3'>
            <label for='uitbrengjaar' class='form-label'>Uitbrengjaar:</label>
            <input type='text' class='form-control' name='uitbrengjaar'>
          </div>
          <div class='mb-3'>
            <label for='taal_id' class='form-label'>Taal id:</label>
            <input type='text' class='form-control' name='taal_id'>
          </div>
          <div class='mb-3'>
            <label for='extra_taal_id' class='form-label'>Extra taal id:</label>
            <input type='text' class='form-control' name='extra_taal_id'>
          </div>
          <div class='mb-3'>
            <label for='verhuurtijd' class='form-label'>Verhuurtijd:</label>
            <input type='text' class='form-control' name='verhuurtijd'>
          </div>
          <div class='mb-3'>
            <label for='verhuurkost' class='form-label'>Verhuurkost:</label>
            <input type='text' class='form-control' name='verhuurkost'>
          </div>
          <div class='mb-3'>
            <label for='lengte' class='form-label'>Lengte:</label>
            <input type='text' class='form-control' name='lengte'>
          </div>
          <div class='mb-3'>
            <label for='vervangingskost' class='form-label'>Vervangingskost:</label>
            <input type='text' class='form-control' name='vervangingskost'>
          </div>
          <button type='submit' class='btn btn-primary'>Invoeren</button>
        </form>
        ";
      }

      //verwerken aanpasformulier
      else if(isset($_GET['actie']) && $_GET['actie']=="aanpassen"){
        $film_id=$_POST['film_id'];
        $titel=$_POST['titel'];
        $omschrijving=$_POST['omschrijving'];
        $uitbrengjaar=$_POST['uitbrengjaar'];
        $taal_id=$_POST['taal_id'];
        $extra_taal_id=$_POST['extra_taal_id'];
        $verhuurtijd=$_POST['verhuurtijd'];
        $verhuurkost=$_POST['verhuurkost'];
        $lengte=$_POST['lengte'];
        $vervangingskost=$_POST['vervangingskost'];

        $query = "UPDATE tbl_film SET titel = '$titel' WHERE film_id = $film_id";
        //echo $query;
        mysqli_query($conn, $query);
      }

      //tonen aanpasformulier
      else if(isset($_GET['actie']) && $_GET['actie']=="aanpasformulier"){
        $film_id = $_GET['film_id'];
        $query = "SELECT * FROM tbl_film WHERE film_id = $film_id";

        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $titel=$row['titel'];
        $omschrijving=$row['omschrijving'];
        $uitbrengjaar=$row['uitbrengjaar'];
        $taal_id=$row['taal_id'];
        $extra_taal_id=$row['extra_taal_id'];
        $verhuurtijd=$row['verhuurtijd'];
        $verhuurkost=$row['verhuurkost'];
        $lengte=$row['lengte'];
        $vervangingskost=$row['vervangingskost'];

        echo "
        <h1>Film aanpassen</h1>
        <form action='?actie=aanpassen' method='post'>
          <input type='hidden' name='film_id' value='$film_id'>
          <div class='mb-3'>
            <label for='titel' class='form-label'>Titel:</label>
            <input type='text' class='form-control' name='titel' value='$titel'>
          </div>
          <div class='mb-3'>
            <label for='omschrijving' class='form-label'>Omschrijving:</label>
            <input type='text' class='form-control' name='omschrijving' value='$omschrijving'>
          </div>
          <div class='mb-3'>
            <label for='uitbrengjaar' class='form-label'>Uitbrengjaar:</label>
            <input type='text' class='form-control' name='uitbrengjaar' value='$uitbrengjaar'>
          </div>
          <div class='mb-3'>
            <label for='taal_id' class='form-label'>Taal id:</label>
            <input type='text' class='form-control' name='taal_id' value='$taal_id'>
          </div>
          <div class='mb-3'>
            <label for='extra_taal_id' class='form-label'>Extra taal id:</label>
            <input type='text' class='form-control' name='extra_taal_id' value='$extra_taal_id'>
          </div>
          <div class='mb-3'>
            <label for='verhuurtijd' class='form-label'>Verhuurtijd:</label>
            <input type='text' class='form-control' name='verhuurtijd' value='$verhuurtijd'>
          </div>
          <div class='mb-3'>
            <label for='verhuurkost' class='form-label'>Verhuurkost:</label>
            <input type='text' class='form-control' name='verhuurkost' value='$verhuurkost'>
          </div>
          <div class='mb-3'>
            <label for='lengte' class='form-label'>Lengte:</label>
            <input type='text' class='form-control' name='lengte' value='$lengte'>
          </div>
          <div class='mb-3'>
            <label for='vervangingskost' class='form-label'>Vervangingskost:</label>
            <input type='text' class='form-control' name='vervangingskost' value='$vervangingskost'>
          </div>
          <button type='submit' class='btn btn-primary'>Aanpassen</button>
        </form>
        ";
      }

      // DEFAULT: films tonen
      else{
        $query = "SELECT * from tbl_film";
        $result = mysqli_query($conn, $query);
        //bestaat de sessie variabele aangemeld en is de waarde true dan tonen van de link om nieuwe film aan te maken
        if(isset($_SESSION['aangemeld']) && $_SESSION['aangemeld']){
          echo "<a href='?actie=invoerformulier'>Nieuwe film aanmaken</a>";
        }
        while ($row = mysqli_fetch_assoc($result)){
          echo "<h1>".$row['titel']." (".$row['uitbrengjaar'].")</h1>";
          echo "<p>".$row['omschrijving']."</p>";
          if(isset($_SESSION['aangemeld']) && $_SESSION['aangemeld']){
            echo "<a href='?actie=aanpasformulier&film_id=".$row['film_id']."'>Film aanpassen</a>";
          }
        }
      }
      ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

  </body>
</html>
