<?php session_start(); 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "affingdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id']; // Hole die Benutzer-ID aus der Sitzung
    // Weiterverarbeiten, z.B. den Tracking-Link erstellen
}

if (isset($_GET['urlid'])) {
    $urlid = htmlspecialchars($_GET['urlid']);
}
$stmt = $conn->prepare("SELECT * FROM url WHERE urlid = ?");
$stmt->bind_param("i", $urlid);
$stmt->execute();
$result = $stmt->get_result();

// Überprüfen, ob ein Ergebnis vorhanden ist
if ($result->num_rows > 0) {
    // Holen der ersten Zeile als assoziatives Array
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Generate a unique tracking code for the link
    $trackingcode = substr(md5(uniqid(rand(), true)), 0, 8);
    
    // Insert the new tracking link into the `tracking_links` table
    $stmt = $conn->prepare("INSERT INTO trackinglinks (fk_urlid, visits, trackingcode, fk_userid) VALUES (?, 0, ?, ?)");
    $stmt->bind_param("isi", $urlid, $trackingcode, $userid);

    if ($stmt->execute()) {
        // Generate the link to share
        $trackinglink = "http://192.168.188.59/GetLink/LinkPage/affiliatelink.php?code=" . $trackingcode;
    }
    echo $trackinglink;
    
    $stmt->close();
    $conn->close();
    exit();
}

$trackingcode = createTrackingLink($urlid, $userid, $conn);
function createTrackingLink($urlid, $userid, $conn) {
    // Generiere einen Tracking-Code (z.B. eine zufällige Zeichenfolge)
    $trackingcode = bin2hex(random_bytes(5)); // Erzeugt einen zufälligen Tracking-Code

    // Gibt den Tracking-Link zurück
    return $trackingcode;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Linkpage.css">
    <link rel="icon" href="/images/Affing_Logo.png" type="image/png">
    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Affing</title>
</head>
<body>
    <header class="header">
        <div class="menu-content">
            <div class="menu-logo">
                <img src="../../images/Affing_Logo.png" alt="logo">
            </div>
            <div class="title-container">
                <span class="title">Affing</span>
            </div>
            <nav>
                <ul class="menu-links">
                    <li><a href="/../Affing.php">Home</a></li>
                    <li><a href="/../Create/create.php">Create Link</a></li>
                    <li><a href="/../User/LoginRegister/Register.php">Sign up</a></li>
                    <li><a href="/../User/LoginRegister/Login.php">Login</a></li>
                    <li><a href="/../About.php">About us</a></li>
                    <li><a href="/../GetLink/GetLink.php">Get Linked</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="content">
        <div class="info-grid">
            <div class="info-table">
                <div class="info-content">
                    <h2 class="info-title">Company:</h2>
                    <p><?php echo htmlspecialchars($row["company"]); ?></p>
                    <h2 class="info-title">Category:</h2>
                    <p><?php echo htmlspecialchars($row["category"]); ?></p>
                    <h2 class="info-title">URL:</h2>
                    <p><?php echo htmlspecialchars($row["url"]); ?></p>
                    <h2 class="info-title">Max. Clicks:</h2>
                    <p><?php echo htmlspecialchars($row["maxnumclick"]); ?></p>
                    <h2 class="info-title">Amount per Click:</h2>
                    <p><?php echo htmlspecialchars($row["amountperclick"]); ?></p>
                    <h2 class="info-title">Content Info:</h2>
                    <p><?php echo htmlspecialchars($row["contentinfo"]); ?></p>
                </div>
            </div>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?urlid=<?php echo htmlspecialchars($urlid); ?>" method="POST">
            <button type="submit" class="button">Get Link</button>
        </form>
    </main>

    <footer class="footer">
        <div class="footer-section">
            <h3>General Links</h3>
            <ul>
                <li><a href="/../Affing.html">Home</a></li>
                <li><a href="/../Create/create.php">Create Link</a></li>
                <li><a href="/../User/LoginRegister/Register.php">Sign up</a></li>
                <li><a href="/../User/LoginRegister/Login.php">Login</a></li>
                <li><a href="/../About.php">About us</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact</h3>
            <p><a href="mailto:benmai576">email</a></p>
        </div>
    </footer>
</body>
</html>
