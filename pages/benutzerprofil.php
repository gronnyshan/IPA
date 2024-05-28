<?php

require_once('../php/db_verbindung.php');

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== 'admin' &&  $_SESSION["logged_in"] !== 'verkaeufer' && $_SESSION["logged_in"] !== 'buchhaltung') {
    
    // Weiterleitung zur Loginseite
    header("location: ../index.php");
    exit;
    
}

$benutzer_id = $_SESSION["b_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Aktuelle Passwörter aus dem Formular holen
        $aktuelles_passwort = $_POST["aktuell"];
        $neues_passwort = $_POST["passwort"];
        $neues_passwort_wiederholen = $_POST["passwort-2"];

        // Neue Passwörter überprüfen, bevor die SQL-Abfragen durchgeführt werden
        if ($neues_passwort === $neues_passwort_wiederholen) {

            // SQL-Abfrage, um das aktuelle Passwort des Benutzers abzurufen
            $sql = "SELECT b_passwort FROM mitarbeiter WHERE benutzer_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("i", $benutzer_id);
            $stmt->execute();
            $stmt->store_result();

                    

            // Überprüfen, ob ein Ergebnis gefunden wurde
            if ($stmt->num_rows == 1) {

                // Ergebnisvariablen binden
                $stmt->bind_result($db_passwort);
                $stmt->fetch();

                // Passwortvergleich überprüfen
                if ($aktuelles_passwort === $db_passwort) {

                    // Passwort aktualisieren
                    // SQL-Abfrage, um das Passwort in der Datenbank zu aktualisieren
                    $update_sql = "UPDATE mitarbeiter SET b_passwort = ? WHERE benutzer_id = ?";
                    $update_stmt = $connection->prepare($update_sql);
                    $update_stmt->bind_param("si", $neues_passwort, $benutzer_id);

                    // Versuche, die Aktualisierungsanweisung auszuführen
                    if ($update_stmt->execute()) {
        
                        $meldung_1 = '<div class="alert alert-success mt-3" role="alert">Passwort erfolgreich geändert!</div>';

                    } else {

                        $meldung_2 = '<div class="alert alert-danger mt-3" role="alert">Fehler beim Aktualisieren des Passworts:' . $update_stmt->error . '</div>';
                    
                    }

                           
                } else {
                    $meldung_5 = '<div class="alert alert-danger mt-3" role="alert">Aktuelles Passwort ist falsch! Bitte nochmals versuchen</div>';
                
                }
            
            } else {
                     $meldung_6 = '<div class="alert alert-danger mt-3" role="alert">Benutzer mit der angegebenen ID nicht gefunden.</div>';
            
            }
            
            // Anweisung schließen
            $stmt->close();
            

            // Datenbankverbindung schließen
            $connection->close();

        } else {
            $meldung_9 = '<div class="alert alert-danger mt-3" role="alert">Die neuen Passwörter stimmen nicht überein!</div>';
        }

}

?>

<!DOCTYPE html>
<html lang="de">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passwort ändern</title>
    <link rel="stylesheet" href="../css/header.stylesheet.cs">
    <!-- Kopiert von Bootstrap-Seite -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
    <style> h1{ margin-top: 100px !important; } </style>


</head>

<body>

<!-- Navigationsleiste von Bootstrap -->
<nav class="navbar bg-body-tertiary fixed-top">

        <div class="container-fluid">

            <a class="navbar-brand" href="#">
            <img src="../img/Marketingmaster-logo.png" alt="Logo" width="350" height="auto" class="d-inline-block align-text-top">
            </a>
    
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      
        <div class="offcanvas-header">
                
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menü</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

        </div>

        <div class="offcanvas-body">

            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                <li class="nav-item">
                    <a class="nav-link" href="javascript:history.go(-2)">Zurück</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="benutzerprofil.php" aria-current="page">Passwort ändern</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../php/logout.php">Abmelden</a>
                </li>

            </ul>

            </div>
        </div>
    </div>
</nav>
    
    <div class="container mt-5">

    <form action="#" method="POST">

            <h1>Passwort ändern:</h1>

            <div class="row" style="margin-top: 15px;">
                
                <div class="col">
                    <label for="vorname" class="form-label">Neues Passwort:*</label>
                    <input type="password" class="form-control" id="passwort" name="passwort" required>
                </div>

                <div class="col">
                    <label for="nachname" class="form-label">Passwort wiederholen:*</label>
                    <input type="password" class="form-control" id="passwort-2" name="passwort-2" required>
                </div>

            </div>

            <div class="mb-3" style="margin-top: 15px;">

            <label for="aktuell" class="form-label">Aktuelles Passwort</label>
            <input type="password" class="form-control" id="aktuell" name="aktuell" required>

            </div>


            <button type="submit" class="btn btn-primary" style="margin-top:15px;background-color:#e041dc;border:none;">Passwort ändern</button>

        </form>

        <?php

            if(isset($meldung_1) || isset($meldung_2) || isset($meldung_3) || isset($meldung_4) || isset($meldung_5) || isset($meldung_6) || isset($meldung_7) || isset($meldung_8) || isset($meldung_9)) {

                if (isset($meldung_1)) {
                    echo $meldung_1;
                }
                if (isset($meldung_2)) {
                    echo $meldung_2;
                }
                if (isset($meldung_3)) {
                    echo $meldung_3;
                }
                if (isset($meldung_4)) {
                    echo $meldung_4;
                }
                if (isset($meldung_5)) {
                    echo $meldung_5;
                }
                if (isset($meldung_6)) {
                    echo $meldung_6;
                }
                if (isset($meldung_7)) {
                    echo $meldung_7;
                }
                if (isset($meldung_8)) {
                    echo $meldung_8;
                }
                if (isset($meldung_9)) {
                    echo $meldung_9;
                }


            } else {
                echo '<div class="alert alert-light" role="alert" style="margin-top:10px;"> Kontaktperson bei Problemen: support@marketingmaster.ch</div>';
            }


        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>


</html>
