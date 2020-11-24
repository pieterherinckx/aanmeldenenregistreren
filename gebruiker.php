<?php
  include_once("conn.inc.php");
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
    // registreren
    if(isset($_GET['actie']) && $_GET['actie']=="registreren"){
      $voornaam = $_POST['voornaam'];
      $familienaam = $_POST['familienaam'];
      $gebruikersnaam = $_POST['gebruikersnaam'];
      $wachtwoord = md5($_POST['wachtwoord']);
      $wachtwoord_controle = md5($_POST['wachtwoord_controle']);
      $email = $_POST['email'];

      echo "<h1>Registreren</h1>" ;
      if($wachtwoord != $wachtwoord_controle){
        echo "De wachtwoorden komen niet overeen";
      }
      else {
        $query = "INSERT INTO gebruiker(voornaam, familienaam, gebruikersnaam, wachtwoord, email) VALUES ('$voornaam', '$familienaam', '$gebruikersnaam', '$wachtwoord', '$email');";
        mysqli_query($conn, $query);
      }
    }

    // registreerformulier
    else if(isset($_GET['actie']) && $_GET['actie']=="registreerformulier"){
      echo "<h1>Registreerformulier</h1>" ;
      echo "
          <form action='?actie=registreren' method='post'>
            <label for='voornaam'>Voornaam</label>
            <input type='text' name='voornaam' value=''>
            <label for='familienaam'>Familienaam</label>
            <input type='text' name='familienaam' value=''>
            <label for='gebruikersnaam'>Gebruikersnaam</label>
            <input type='text' name='gebruikersnaam' value=''>
            <label for='wachtwoord'>Wachtwoord</label>
            <input type='password' name='wachtwoord' value=''>
            <label for='wachtwoord_controle'>Wachtwoord controle</label>
            <input type='password' name='wachtwoord_controle' value=''>
            <label for='email'>Email</label>
            <input type='text' name='email' value=''>
            <button type='submit' name='registreren'>Registreren</button>
          </form>";
    }

    // bewerken
    else if(isset($_GET['actie']) && $_GET['actie']=="bewerken"){
      $gebruikersnr = $_POST['gebruikersnr'];
      $voornaam = $_POST['voornaam'];
      $familienaam = $_POST['familienaam'];
      $email = $_POST['email'];

      $query = "UPDATE gebruiker SET voornaam = '$voornaam', familienaam = '$familienaam', email = '$email' WHERE gebruikersnr = $gebruikersnr;";
      mysqli_query($conn, $query);

      echo "Uw gegevens zijn aangepast";
    }

    // bewerkformulier
    else if(isset($_GET['actie']) && $_GET['actie']=="bewerkformulier"){
      $gebruikersnaam = $_SESSION['gebruikersnaam'];
      $query = "SELECT * FROM gebruiker WHERE gebruikersnaam = '$gebruikersnaam';";
      $resultaat = mysqli_query($conn, $query);
      $rij = mysqli_fetch_assoc($resultaat);

      $gebruikersnr = $rij['gebruikersnr'];
      $voornaam = $rij['voornaam'];
      $familienaam = $rij['familienaam'];
      $email = $rij['email'];

      echo "<h1>Bewerkformulier</h1>";
      echo "
          <form action='?actie=bewerken' method='post'>
            <input type='hidden' name='gebruikersnr' value='$gebruikersnr'>
            <label for='voornaam'>Voornaam</label>
            <input type='text' name='voornaam' value='$voornaam'>
            <label for='familienaam'>Familienaam</label>
            <input type='text' name='familienaam' value='$familienaam'>
            <label for='email'>Email</label>
            <input type='text' name='email' value='$email'>
            <button type='submit' name='bewerken'>Bewerken</button>
          </form>";
    }

    // verwijderen
    else if(isset($_GET['actie']) && $_GET['actie']=="verwijderen"){
      $gebruikersnaam = $_SESSION['gebruikersnaam'];
      $query = "DELETE FROM gebruiker WHERE gebruikersnaam = '$gebruikersnaam';";

      mysqli_query($conn, $query);
      session_destroy();
    }

    // afmelden
    else if(isset($_GET['actie']) && $_GET['actie']=="afmelden"){
      session_destroy();
      echo "U bent nu afgemeld";
    }

    // aanmelden
    else if(isset($_GET['actie']) && $_GET['actie']=="aanmelden"){
      $gebruikersnaam = $_POST['gebruikersnaam'];
      $wachtwoord = md5($_POST['wachtwoord']);

      $query = "SELECT gebruikersnr FROM gebruiker WHERE gebruikersnaam = '$gebruikersnaam' AND wachtwoord = '$wachtwoord';";

      $resultaat = mysqli_query($conn, $query);
      $resultaatCheck = mysqli_num_rows($resultaat);

      if($resultaatCheck > 0){
        echo "U bent aangemeld";
        $_SESSION['aangemeld'] = true;
        $_SESSION['gebruikersnaam'] = $gebruikersnaam;
      }
      else {
        echo "Gegevens kloppen niet";
      }

    }

    // aanmeldformulier  --> STANDAARD
    else {
      if(isset($_SESSION['aangemeld']) && $_SESSION['aangemeld']){
        echo "<p>Hallo ".$_SESSION['gebruikersnaam'].". U bent al aangemeld</p>";
        echo "<a href='?actie=afmelden'>Afmelden</a> - ";
        echo "<a href='?actie=bewerkformulier'>Profiel bewerken</a> - ";
        echo "<a href='?actie=verwijderen'>Profiel verwijderen</a>";
      }
      else {
        echo "<h1>Aanmeldformulier</h1>" ;
        echo "
            <form action='?actie=aanmelden' method='post'>
              <label for='gebruikersnaam'>Gebruikersnaam</label>
              <input type='text' name='gebruikersnaam' value=''>
              <label for='wachtwoord'>Wachtwoord</label>
              <input type='password' name='wachtwoord' value=''>
              <button type='submit' name='aanmelden'>Aanmelden</button>
            </form>";

        echo "<a href='?actie=registreerformulier'>Registreer</a>";
      }
    }
    ?>
  </body>
</html>
