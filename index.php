<?php

require_once('php/db_verbindung.php');

// In dieser Zeile wird geprüft ob das Formular abgesendet wurde und die Methode POST ist.
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // E-Mail und Passwort wird abgerufen vom Formular
    $l_mail = $_POST["login_email"];
    $l_password = $_POST["login_password"];

    // SQL-Abfrage
    $sql = "SELECT * FROM mitarbeiter WHERE b_email='".$l_mail."' AND b_passwort ='".$l_password."'";

    $result_sql = mysqli_query($connection,$sql);

    if ($result_sql) {

        // Prüfung ob es übereinstimmende Benutzer gibt
        if (mysqli_num_rows($result_sql) > 0) {

            $row = mysqli_fetch_array($result_sql);

            // Benutzer_id in Session speichern
            $_SESSION["b_id"] = $row["benutzer_id"];

            // Je nach Abteilung wird man auf eine andere Seite weitergeleitet.
            if ($row["b_abteilung"] == "admin"){

                $_SESSION["logged_in"] = 'admin';
                header("Location: pages/h_admin.php");
                exit;

            } elseif ($row["b_abteilung"] == "verkaeufer"){

                $_SESSION["logged_in"] = 'verkaeufer';
                header("Location: pages/h_verkaeufer.php");
                exit;

            } elseif ($row["b_abteilung"] == "buchhaltung"){

                $_SESSION["logged_in"] = 'buchhaltung';
                header("Location: pages/h_buchhaltung.php");
                exit;

            } 

        } else {

            // Bei nicht übereinstimmmende Benutzer wird folgendes ausgegeben
            $meldung_1 = '<div class="alert alert-danger mt-3" role="alert">E-Mail Adresse oder Passwort ist inkorrekt</div>';
        
        }

    } else {

        $meldung_2 = 'Fehler bei der Ausführung der Abfrage: ' . mysqli_error($connection);
    
    }
}

?>


<!-- HTML -->
<!DOCTYPE html>
<html lang="de">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <!-- Kopiert von Bootstrap-Seite -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 

</head>

<body>

    <div class="div-header">
        <header>

            <!-- Navigationsleiste - Bootstrap -->
            <nav class="navbar bg-body-tertiary">
                <div class="container-fluid">
                    
                    <a class="navbar-brand" href="#">
                    <img src="img/Marketingmaster-logo.png" alt="Logo" width="350" height="auto" class="d-inline-block align-text-top">
                    </a>

                </div>
            </nav>

        </header>
    </div>

    
    <!-- Login Formular -->
    <main class="form-signin w-100 m-auto">
  
        <form action="#" method="POST">

            <h1 class="h3 mb-3 fw-normal">Anmelden</h1>

            <div class="form-floating">

                <input type="email" class="form-control" id="login_email" name="login_email" placeholder="beispiel@marketingmaster.ch" required>
                <label for="login_email">E-Mail:</label>

            </div>

            <div class="form-floating">

                <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Passwort" required>
                <label for="login_password">Passwort:</label>

            </div>

            <button class="btn btn-primary w-100 py-2" type="submit" style="background-color:#e041dc; border:none;">Anmelden</button>

        </form>

        <?php

        if(isset($meldung_1) || isset($meldung_2)) {

            if (isset($meldung_1)) {
                echo $meldung_1;
            }

            if(isset($meldung_2)) {
                echo $meldung_2;
            }
  
        } else {
            echo '<div class="alert alert-light" role="alert" style="margin-top:10px;"> Kontaktperson bei Problemen: support@marketingmaster.ch</div>';
        }

        ?>

    </main>

    <!-- Kopiert von Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
