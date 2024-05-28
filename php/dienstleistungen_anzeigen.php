<?php

// Funktion zum Anzeigen der Dienstleistungen als Checkboxen
function dienstleistungen_anzeigen() {
    
    global $connection;

    // SQL-Abfrage, um alle Dienstleistungen zu laden
    $sql = "SELECT dienstleistung_id, d_name, d_paket, d_preis FROM dienstleistung";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        // Ausgabe der Checkboxen für jede Dienstleistung
        while($row = $result->fetch_assoc()) {
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" name="dienstleistungen[]" id="dienstleistung_' . $row["dienstleistung_id"] . '" value="' . $row["dienstleistung_id"] . '">';
            echo '<label class="form-check-label" for="dienstleistung_' . $row["dienstleistung_id"] . '">';
            echo $row["d_name"] . ' | ' . $row["d_paket"] . ' (CHF ' . number_format($row["d_preis"], 2) . ')';
            echo '</label>';
            echo '</div>';
        }
    } else {
        echo "Keine Dienstleistungen gefunden.";
    }

}

?>