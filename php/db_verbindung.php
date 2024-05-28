<?php

session_start();

 // Informationen um die Verbindung zu herstellen
 $servername = "localhost";
 $database = "marketingmaster";
 $username = "marketing";
 $password = "Marketingmaster@483020";

 // Hier wird die Verbindung hergestellt
 $connection = mysqli_connect($servername, $username, $password, $database);

 // Bei einer fehlgeschlagener Anmeldung gibt es eine Fehlermeldung
 if($connection->connect_error){
     die("Verbindung zur Datenbank ist fehlgeschlagen:" . $connection->connect_error);
 } 

 ?>