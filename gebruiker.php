<?php
  include_once("conn.inc.php");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <?php
        // registreren
        if(isset($_GET['actie']) && $_GET['actie']=="registreren"){
          $voornaam = $_POST['voornaam'];
          $achternaam = $_POST['achternaam'];
          $email = $_POST['email'];
          $gebruikersnaam = $_POST['gebruikersnaam'];
          $wachtwoord = md5($_POST['wachtwoord']);
          $wachtwoordcontrole = md5($_POST['wachtwoordcontrole']);

          if($wachtwoord != $wachtwoordcontrole){
            echo "De wachtwoorden komen niet overeen";
          }
          else {
            $query = "INSERT INTO gebruikers(voornaam, achternaam, email, gebruikersnaam, wachtwoord) VALUES ('$voornaam', '$achternaam', '$email', '$gebruikersnaam', '$wachtwoord')";

            mysqli_query($conn, $query);
          }
        }
        // registreerformulier
        else if(isset($_GET['actie']) && $_GET['actie']=="registreerformulier"){
          echo "
          <h1>Registreren</h1>
          <form action='?actie=registreren' method='post'>
            <div class='form-group'>
              <label for='voornaam'>Voornaam</label>
              <input type='text' class='form-control' name='voornaam' placeholder='Voornaam'>
            </div>
            <div class='form-group'>
              <label for='achternaam'>Achternaam</label>
              <input type='text' class='form-control' name='achternaam' placeholder='Achternaam'>
            </div>
            <div class='form-group'>
              <label for='email'>Email</label>
              <input type='email' class='form-control' name='email' placeholder='Email'>
            </div>
            <div class='form-group'>
              <label for='gebruikersnaam'>Gebruikersnaam</label>
              <input type='text' class='form-control' name='gebruikersnaam' placeholder='Gebruikersnaam'>
            </div>
            <div class='form-group'>
              <label for='wachtwoord'>Wachtwoord</label>
              <input type='password' class='form-control' name='wachtwoord' placeholder='Wachtwoord'>
            </div>
            <div class='form-group'>
              <label for='wachtwoordcontrole'>Wachtwoord controle</label>
              <input type='password' class='form-control' name='wachtwoordcontrole' placeholder='Wachtwoordcontrole'>
            </div>
            <button type='submit' class='btn btn-primary'>Registreer</button>
          </form>
          ";
        }
        //aanmelden
        else if(isset($_GET['actie']) && $_GET['actie']=="aanmelden"){
          $gebruikersnaam = $_POST['gebruikersnaam'];
          $wachtwoord = md5($_POST['wachtwoord']);

          $query = "SELECT gebruikersnr FROM gebruiker WHERE gebruikersnaam = '$gebruikersnaam' AND wachtwoord = '$wachtwoord'";
          $resultaat = mysqli_query($conn, $query);
          $resultaatCheck = mysqli_num_rows($resultaat);
          if($resultaatCheck > 0){
            echo "Je bent aangemeld";
            $_SESSION['aangemeld'] = true;
            $_SESSION['gebruikersnaam'] = $gebruikersnaam;
          }
          else {
            echo "De opgegeven combinatie bestaat niet";
          }
        }
        //afmelden
        else if(isset($_GET['actie']) && $_GET['actie']=="afmelden"){
          session_destroy();
        }
        //bewerken
        else if(isset($_GET['actie']) && $_GET['actie']=="bewerken"){
          $gebruikersID = $_POST['gebruikersID'];
          $voornaam = $_POST['voornaam'];
          $achternaam = $_POST['achternaam'];
          $gebruikersnaam = $_POST['gebruikersnaam'];
          $email = $_POST['email'];
          $_SESSION['gebruikersnaam'] = $gebruikersnaam;

          $query = "UPDATE gebruikers SET voornaam = '$voornaam', achternaam = '$achternaam', gebruikersnaam = '$gebruikersnaam', email = '$email' WHERE gebruikersID = $gebruikersID";
          mysqli_query($conn, $query);
        }

        //bewerkformulier
        else if(isset($_GET['actie']) && $_GET['actie']=="bewerkformulier"){
          $gebruikersnaam = $_SESSION['gebruikersnaam'];
          $query = "SELECT * FROM gebruikers WHERE gebruikersnaam = '$gebruikersnaam'";
          $resultaat = mysqli_query($conn, $query);

          $row = mysqli_fetch_assoc($resultaat);

          $gebruikersID = $row['gebruikersID'];
          $voornaam = $row['voornaam'];
          $achternaam = $row['achternaam'];
          $email = $row['email'];

          echo "
          <h1>Profiel bewerken</h1>
          <form action='?actie=bewerken' method='post'>
            <input type='hidden' name='gebruikersID' value ='$gebruikersID'>
            <div class='form-group'>
              <label for='voornaam'>Voornaam</label>
              <input type='text' class='form-control' name='voornaam' value='$voornaam'>
            </div>
            <div class='form-group'>
              <label for='achternaam'>Achternaam</label>
              <input type='text' class='form-control' name='achternaam' value='$achternaam'>
            </div>
            <div class='form-group'>
              <label for='email'>Email</label>
              <input type='email' class='form-control' name='email' value='$email'>
            </div>
            <div class='form-group'>
              <label for='gebruikersnaam'>Gebruikersnaam</label>
              <input type='text' class='form-control' name='gebruikersnaam' value='$gebruikersnaam'>
            </div>
            <button type='submit' class='btn btn-primary'>Opslaan</button>
          </form>
          ";
        }

        //aanmeldformulier
        else{
          if(isset($_SESSION['aangemeld']) && $_SESSION['aangemeld']){
            echo "<h1>Hallo ".$_SESSION['gebruikersnaam']."</h1>";
            echo "<p><a href='?actie=afmelden'>Afmelden</a></p>";
            echo "<p><a href='?actie=bewerkformulier'>Profiel bewerken</a></p>";
          }
          else {
            echo "
            <h1>Aanmelden</h1>
            <form action='?actie=aanmelden' method='post'>
              <div class='form-group'>
                <label for='gebruikersnaam'>Gebruikersnaam</label>
                <input type='text' class='form-control' name='gebruikersnaam' placeholder='Gebruikersnaam'>
              </div>
              <div class='form-group'>
                <label for='wachtwoord'>Wachtwoord</label>
                <input type='password' class='form-control' name='wachtwoord' placeholder='Wachtwoord'>
              </div>
              <button type='submit' class='btn btn-primary'>Aanmelden</button>
              <a href='?actie=registreerformulier'>Registreren</a>
            </form>
            ";
          }
        }
      ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
  </body>
</html>
