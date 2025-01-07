<?php
$host = "localhost"; // Database host
$user = "root";      // Database gebruiker
$password = "";      // Database wachtwoord
$database = "thuiszorg_reservering"; // Naam van de database

// Maak verbinding met de database
$db = mysqli_connect($host, $user, $password, $database);

if (!$db) {
    die("Databaseverbinding mislukt: " . mysqli_connect_error());
}
?>