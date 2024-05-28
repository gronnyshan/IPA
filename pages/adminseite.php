<?php

require_once('../php/db_verbindung.php');

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== 'admin') {
    
    // Weiterleitung zur Loginseite
    header("location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $vorname = $_POST["vorname"];
    $nachname = $_POST["nachname"];
    $abteilung_select= $_POST["abteilung_select"];
    $email = $_POST["email"];
    $telefon = $_POST["tel"];
    $passwort = $_POST["password"];
    $passwort2 = $_POST["password_2"];
   

    if($passwort !== $passwort2) {

        $meldung_1 = '<div class="alert alert-danger mt-3" role="alert"> Passwörter stimmen nicht überein.</div>';

    } else {

        $sql = "INSERT INTO mitarbeiter (b_vorname, b_nachname, b_abteilung, b_email, b_tel, b_passwort) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssss", $vorname, $nachname, $abteilung_select, $email, $telefon, $passwort);
        

        if ($stmt->execute()) {

            $meldung_2 = '<div class="alert alert-success mt-3" role="alert">Neuer Mitarbeiter erfolgreich hinzugefügt.</div>';
            
        } else {

            $meldung_3 = '<div class="alert alert-danger mt-3" role="alert">Fehler:' . $stmt->error . '</div>';
        }

         $stmt->close();   

    }


} else {

    $meldung_4 = '<div class="alert alert-light" role="alert" style="margin-top:10px;"> Kontaktperson bei Problemen: support@marketingmaster.ch</div>';

}
?>


<!DOCTYPE html>
<html lang="de">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer erstellen</title>
    
    <link rel="stylesheet" href="../css/header.stylesheet.css">
    <!-- Kopiert von Bootstrap-Seite -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
    <style> h1 { margin-top: 100px !important; } </style>   

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
                    <a class="nav-link " href="h_admin.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="adminseite.php" aria-current="page">Benutzer erstellen</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="benutzerprofil.php">Passwort ändern</a>
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

            <h1>Benutzer erstellen:</h1>

            <div class="row" style="margin-top: 15px;">
                
                <div class="col">
                    <label for="vorname" class="form-label">Vorname:*</label>
                    <input type="text" class="form-control" id="vorname" name="vorname" required>
                </div>

                <div class="col">
                    <label for="nachname" class="form-label">Nachname:*</label>
                    <input type="text" class="form-control" id="nachname" name="nachname" required>
                </div>

            </div>

            <div class="row" style="margin-top: 15px;">
                
                <div class="col">
                    <label for="tel" class="form-label">Telefon:*</label>
                    <input type="tel" class="form-control" id="tel" name="tel" required>
                </div>

                <div class="col">
                    <label for="email" class="form-label">E-Mail:*</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

            </div>

            <div class="row" style="margin-top: 15px;">
                
                <div class="col"> 
                    <label for="password" class="form-label">Neues Passwort:*</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="col">
                    <label for="password_2" class="form-label">Passwort wiederholen:*</label>
                    <input type="password" class="form-control" id="password_2" name="password_2" required>
                </div>

            </div>

            <label for="pabteilung_select" class="form-label" style="margin-top: 15px;" >Abteilung auswählen:*</label>    
            <select class="form-select" aria-label="Default select example" name="abteilung_select">
                <option value="verkaeufer">Verkäufer</option>
                <option value="admin">Admin</option>
                <option value="buchhaltung">Buchhaltung</option>
            </select>

            <button type="submit" class="btn btn-primary" style="margin-top:15px;background-color:#e041dc;border:none;">Passwort ändern</button>

        </form>

        <?php

                if(isset($meldung_1) || isset($meldung_2) || isset($meldung_3) || isset($meldung_4)) {

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

                } else {

                    echo '<div class="alert alert-light" role="alert" style="margin-top:10px;"> Kontaktperson bei Problemen: support@marketingmaster.ch</div>';
                }


                ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>


</html>
