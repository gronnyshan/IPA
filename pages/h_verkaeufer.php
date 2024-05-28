<?php

require_once('../php/db_verbindung.php');

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== 'verkaeufer') {
    
    // Weiterleitung zur Loginseite
    header("location: ../index.php");
    exit;
}

$benutzer_id = $_SESSION["b_id"];

$sql = "SELECT vertrag_id, vertragsbeginndatum, bemerkungen FROM vertraege WHERE benutzer_id = $benutzer_id";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html lang="de">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verkäufer</title>
    <link rel="stylesheet" href="../css/header.stylesheet.cs">
    <!-- Kopiert von Bootstrap-Seite -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
    <style> h1 { margin-top: 100px !important;} </style>

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
                    <a class="nav-link active" aria-current="page" href="h_verkaeufer.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="formular.php?benutzer_id=<?php echo $benutzer_id; ?>">Vertrag erstellen</a>
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

        <h1>Verkäuferseite</h1>
        <p>Benutzer-ID: <?php echo $benutzer_id; ?></p>


        <table class="table">

            <thead>
                <tr>
                    <th scope="col">Vertrags ID</th>
                    <th scope="col">Vertragsbeginndatum</th>
                    <th scope="col">Bemerkungen</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>

            <tbody>
                <?php
        
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["vertrag_id"] . "</td>";
                        echo "<td>" . $row["vertragsbeginndatum"] . "</td>";
                        echo "<td>" . $row["bemerkungen"] . "</td>";
                        echo '<td><a href="vertrag_detailiert.php?vertrag_id=' . $row["vertrag_id"] . '">Details anzeigen</a></td>';
                        echo '<td><a href="../php/vertrag_loeschen.php?vertrag_id=' . $row["vertrag_id"] . '" onclick="return confirm(\'Möchten Sie diesen Vertrag wirklich löschen?\')">Löschen</a></td>';
                        echo "</tr>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Keine Verträge gefunden.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>


</html>
