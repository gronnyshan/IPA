<?php 
    require_once('../php/db_verbindung.php'); 

    if(isset($_GET['vertrag_id'])){
        $vertrag_id = $_GET['vertrag_id'];

        // Query to get contract details
        $sql = "SELECT v.vertragsbeginndatum, 
                       v.bemerkungen,
                       m.b_vorname, 
                       m.b_nachname, 
                       m.b_abteilung, 
                       m.b_email,
                       k.k_vorname, 
                       k.k_nachname, 
                       k.k_firmenname, 
                       k.k_strasse, 
                       k.k_plz, 
                       k.k_ort, 
                       k.k_email, 
                       k.k_telefon, 
                       k.k_webseite,
                       d.d_name, 
                       d.d_paket, 
                       d.d_preis

                FROM vertraege v
                JOIN mitarbeiter m ON v.benutzer_id = m.benutzer_id
                JOIN kunden k ON v.kunden_id = k.kunden_id
                JOIN vd ON v.vertrag_id = vd.vertrag_id
                JOIN dienstleistung d ON vd.dienstleistung_id = d.dienstleistung_id
                WHERE v.vertrag_id = ?";
        
        if($stmt = $connection->prepare($sql)){
          
            $stmt->bind_param("i", $vertrag_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows > 0){
                $vertrag = $result->fetch_all(MYSQLI_ASSOC);

                $chf_insgesamt = 0;
                foreach($vertrag as $service) {
                    $chf_insgesamt += $service['d_preis'];
                }

            } else {
                echo "Keine Informationen gefunden für Vertrag ID: $vertrag_id";
                exit();
            }
            
            $stmt->close();

        } else {

            echo "Fehler bei der Datenbankabfrage: " . $connection->error;
            exit();

        }
    } else {

        echo "Vertrag ID wurde nicht gefunden";
        exit();

    }

    $benutzer_id = $_SESSION["b_id"];
?>

<!DOCTYPE html>
<html lang="de">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertrag Details</title>
    <link rel="stylesheet" href="../css/header.stylesheet.cs">
    <!-- Kopiert von Bootstrap-Seite -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
    <style> .titel { margin-top: 100px !important; } </style>


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
                    <a class="nav-link"  href="javascript:history.go(-2)">Home</a>
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

    <?php if(isset($vertrag)): ?>

        <h1 class="titel"><?php echo nl2br($vertrag[0]['bemerkungen']); ?></h1>
        
        <!-- Mitarbeiter -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Mitarbeiter</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Vorname:</td>
                    <td><?php echo $vertrag[0]['b_vorname']; ?></td>
                </tr>
                <tr>
                    <td>Nachname:</td>
                    <td><?php echo $vertrag[0]['b_nachname']; ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo $vertrag[0]['b_email']; ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Kunde -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Kunde</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Vorname:</td>
                    <td><?php echo $vertrag[0]['k_vorname']; ?></td>
                </tr>
                <tr>
                    <td>Nachname:</td>
                    <td><?php echo $vertrag[0]['k_nachname']; ?></td>
                </tr>
                <tr>
                    <td>Firmenname:</td>
                    <td><?php echo $vertrag[0]['k_firmenname']; ?></td>
                </tr>
                <tr>
                    <td>Strasse:</td>
                    <td><?php echo $vertrag[0]['k_strasse']; ?></td>
                </tr>
                <tr>
                    <td>PLZ:</td>
                    <td><?php echo $vertrag[0]['k_plz']; ?></td>
                </tr>
                <tr>
                    <td>Ort:</td>
                    <td><?php echo $vertrag[0]['k_ort']; ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo $vertrag[0]['k_email']; ?></td>
                </tr>
                <tr>
                    <td>Telefon:</td>
                    <td><?php echo $vertrag[0]['k_telefon']; ?></td>
                </tr>
                <tr>
                    <td>Webseite:</td>
                    <td><?php echo $vertrag[0]['k_webseite']; ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Dienstleistungen -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Dienstleistungen</th>
                    <th scope="col">Paket</th>
                    <th scope="col">Preis (CHF)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($vertrag as $service): ?>
                    <tr>
                        <td><?php echo $service['d_name']; ?></td>
                        <td><?php echo $service['d_paket']; ?></td>
                        <td><?php echo $service['d_preis']; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2"><strong>Gesamtpreis aller Dienstleistungen:</strong></td>
                    <td><?php echo $chf_insgesamt; ?> CHF</td>
                </tr>
            </tbody>
        </table>

        <!-- Vertragsdetails -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Vertragsdetails</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Vertragsbeginn:</td>
                    <td><?php echo $vertrag[0]['vertragsbeginndatum']; ?></td>
                </tr>
            </tbody>
        </table>

    <?php endif; ?>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>