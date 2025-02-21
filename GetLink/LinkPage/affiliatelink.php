<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "affingdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['code'])) {
        $trackingcode = htmlspecialchars($_GET['code']);
    }
}  

trackLink($trackingcode, $conn);
function trackLink($trackingcode, $conn) {
    // Hole den Tracking-Link aus der Datenbank
    $stmt = $conn->prepare("SELECT fk_urlid FROM trackinglinks WHERE trackingcode = ?");
    $stmt->bind_param("s", $trackingcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $urlid = $row['fk_urlid'];

        // Erhöhe die Anzahl der Klicks
        $stmt = $conn->prepare("UPDATE trackinglinks SET visits = visits + 1 WHERE trackingcode = ?");
        $stmt->bind_param("s", $trackingcode);
        $stmt->execute();

        // Hole die ursprüngliche URL
        $stmt = $conn->prepare("SELECT url FROM url WHERE urlid = ?");
        $stmt->bind_param("i", $urlid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Leite den Benutzer zur ursprünglichen URL weiter
        header("Location: " . $row['url']);

        echo "http://". $row['url'] . $trackingcode;
    } else {
        echo "Tracking-Code nicht gefunden.";
    }
}
?>