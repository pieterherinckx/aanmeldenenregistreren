<?php
  session_start();
  include_once('inc/conn.inc.php');
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
      //profiel aanpassen
      if(isset($_GET['actie']) && $_GET['actie']=="aanpassen"){
        $klant_id = $_SESSION['klant_id'];
        $voornaam = $_POST['voornaam'];
        $familienaam = $_POST['familienaam'];
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $email = $_POST['email'];
        $wachtwoord = md5($_POST['wachtwoord']);
        $controle_wachtwoord = md5($_POST['controle_wachtwoord']);

        if($wachtwoord != $controle_wachtwoord){
          echo "
          <div class='alert alert-danger' role='alert'>
            De wachtwoorden komen niet overeen!
          </div>";
        }
        else {
          $query = "UPDATE tbl_klant SET voornaam = '$voornaam', familienaam= '$familienaam', gebruikersnaam = '$gebruikersnaam', email = '$email', wachtwoord= '$wachtwoord' WHERE klant_id = $klant_id";
          //echo $query;
          mysqli_query($conn,$query);
          echo "
          <div class='alert alert-success' role='alert'>
            De gegevens zijn aangepast!
          </div>";
          $_SESSION['voornaam'] = $voornaam;
          $_SESSION['familienaam'] = $familienaam;
          $_SESSION['gebruikersnaam'] = $gebruikersnaam;
          $_SESSION['email'] = $email;
        }
      }


      // profiel weergeven
      else if(isset($_GET['actie']) && $_GET['actie']=="profiel"){
        $voornaam = $_SESSION['voornaam'];
        $familienaam = $_SESSION['familienaam'];
        $gebruikersnaam = $_SESSION['gebruikersnaam'];
        $email = $_SESSION['email'];
        $actief = $_SESSION['actief'];
        echo "
        <h1>Profiel</h1>
        <form action='?actie=aanpassen' method='post'>
          <div class='mb-3'>
            <label for='voornaam' class='form-label'>Voornaam:</label>
            <input type='text' name='voornaam' class='form-control' value='$voornaam'>
          </div>
          <div class='mb-3'>
            <label for='familienaam' class='form-label'>Familienaam:</label>
            <input type='text' name='familienaam' class='form-control' value='$familienaam'>
          </div>
          <div class='mb-3'>
            <label for='gebruikersnaam' class='form-label'>Gebruikersnaam:</label>
            <input type='text' name='gebruikersnaam' class='form-control' value='$gebruikersnaam'>
          </div>
          <div class='mb-3'>
            <label for='email' class='form-label'>Email:</label>
            <input type='email' name='email' class='form-control' value='$email'>
          </div>
          <div class='mb-3'>
            <label for='wachtwoord' class='form-label'>Wachtwoord:</label>
            <input type='password' name='wachtwoord' class='form-control' placeholder='Vul hier je nieuw wachtwoord in: '>
          </div>
          <div class='mb-3'>
            <label for='controle_wachtwoord' class='form-label'>Controle wachtwoord:</label>
            <input type='password' name='controle_wachtwoord' class='form-control' placeholder='Vul hier je nieuw controle wachtwoord in: '>
          </div>
          <button type='submit' class='btn btn-primary'>Aanpassen</button>
        </form>";
      }


      // afmelden verwerken
      else if(isset($_GET['actie']) && $_GET['actie']=="afmelden"){
        session_destroy();
        echo "
        <div class='alert alert-success' role='alert'>
          De gebruiker is afgemeld!
        </div>";
      }

      //registratieformulier verwerken - registreren
      else if(isset($_GET['actie']) && $_GET['actie']=="registreren"){
        $voornaam = $_POST['voornaam'];
        $familienaam = $_POST['familienaam'];
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $email = $_POST['email'];
        $wachtwoord = md5($_POST['wachtwoord']);
        $controle_wachtwoord = md5($_POST['controle_wachtwoord']);

        if($wachtwoord != $controle_wachtwoord){
          echo "
          <div class='alert alert-danger' role='alert'>
            De wachtwoorden komen niet overeen!
          </div>";
        }
        else {
          //echo $voornaam." ".$familienaam." ".$gebruikersnaam." ".$email." ".$wachtwoord." ".$controle_wachtwoord;

          $query = "INSERT INTO tbl_klant(voornaam, familienaam, gebruikersnaam, email, wachtwoord) VALUES ('$voornaam', '$familienaam', '$gebruikersnaam', '$email', '$wachtwoord')";
          //echo $query;
          mysqli_query($conn,$query);
        }
      }

      //registratieformulier tonen
      else if(isset($_GET['actie']) && $_GET['actie']=="registratieformulier"){
        echo "
        <h1>Registratieformulier</h1>
        <form action='?actie=registreren' method='post'>
          <div class='mb-3'>
            <label for='voornaam' class='form-label'>Voornaam:</label>
            <input type='text' name='voornaam' class='form-control' placeholder='Vul hier je voornaam in: '>
          </div>
          <div class='mb-3'>
            <label for='familienaam' class='form-label'>Familienaam:</label>
            <input type='text' name='familienaam' class='form-control' placeholder='Vul hier je familienaam in: '>
          </div>
          <div class='mb-3'>
            <label for='gebruikersnaam' class='form-label'>Gebruikersnaam:</label>
            <input type='text' name='gebruikersnaam' class='form-control' placeholder='Vul hier je gebruikersnaam in: '>
          </div>
          <div class='mb-3'>
            <label for='email' class='form-label'>Email:</label>
            <input type='email' name='email' class='form-control' placeholder='Vul hier je email in: '>
          </div>
          <div class='mb-3'>
            <label for='wachtwoord' class='form-label'>Wachtwoord:</label>
            <input type='password' name='wachtwoord' class='form-control' placeholder='Vul hier je wachtwoord in: '>
          </div>
          <div class='mb-3'>
            <label for='controle_wachtwoord' class='form-label'>Controle wachtwoord:</label>
            <input type='password' name='controle_wachtwoord' class='form-control' placeholder='Vul hier je controle wachtwoord in: '>
          </div>
          <button type='submit' class='btn btn-primary'>Registreren</button>
        </form>";
      }

      //aanmeldformulier verwerken - aanmelden
      else if(isset($_GET['actie']) && $_GET['actie']=="aanmelden"){
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = md5($_POST['wachtwoord']);

        $query = "SELECT * FROM tbl_klant WHERE gebruikersnaam = '$gebruikersnaam' AND wachtwoord = '$wachtwoord'";
        $result = mysqli_query($conn, $query);
        $numRows = mysqli_num_rows($result);

        // combinatie gebruikersnaam en wachtwoord bestaat niet
        if($numRows == 0){
          echo "
          <div class='alert alert-danger' role='alert'>
            De combinatie gebruikersnaam en wachtwoord bestaat niet!
          </div>";
        }
        // de gebruiker is aangemeld
        else {
          $_SESSION['aangemeld']=true;

          // de associatieve array van het resultaat ophalen
          $row = mysqli_fetch_assoc($result);
          $_SESSION['klant_id'] = $row['klant_id'];
          $_SESSION['voornaam'] = $row['voornaam'];
          $_SESSION['familienaam'] = $row['familienaam'];
          $_SESSION['gebruikersnaam'] = $row['gebruikersnaam'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['actief'] = $row['actief'];
          echo "
          <div class='alert alert-success' role='alert'>
            De gebruiker is aangemeld!
          </div>";
        }

      }

      // DEFAULT: aanmeldformulier tonen
      else {
        // controleren of de gebruiker al aangemeld is dus aanmeldformulier niet meer tonen
        if(isset($_SESSION['aangemeld']) && $_SESSION['aangemeld']){
          echo "<a href='?actie=afmelden'>Afmelden</a> <br>";
          echo "<a href='?actie=profiel'>Profiel</a>";
        }
        // gebruiker is nog niet aangemeld dus aanmeldformulier tonen
        else {
          echo "
          <h1>aanmeldformulier</h1>
          <form action='?actie=aanmelden' method='post'>
            <div class='mb-3'>
              <label for='gebruikersnaam' class='form-label'>Gebruikersnaam:</label>
              <input type='text' name='gebruikersnaam' class='form-control' placeholder='Vul hier je gebruikersnaam in: '>
            </div>
            <div class='mb-3'>
              <label for='wachtwoord' class='form-label'>Wachtwoord:</label>
              <input type='password' name='wachtwoord' class='form-control' placeholder='Vul hier je wachtwoord in: '>
            </div>
            <button type='submit' class='btn btn-primary'>Aanmelden</button>
            <a href='?actie=registratieformulier'>Registreren</a>
          </form>";
        }
      }


      ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

  </body>
</html>
