<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datenbankverbindung herstellen
    $servername = "localhost";
    $username = "root";
    $passworddb = "";

    $conn = new mysqli($servername, $username, $passworddb, "affingdb");

    // Verbindung prüfen
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Eingaben sammeln und bereinigen
    $username = htmlspecialchars(trim($_POST["username"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $firstname = htmlspecialchars(trim($_POST["firstname"]));
    $lastname = htmlspecialchars(trim($_POST["lastname"]));
    $continent = htmlspecialchars(trim($_POST["continent"]));
    $countrycode = htmlspecialchars(trim($_POST["countrycode"]));
    $phonenumber = htmlspecialchars(trim($_POST["phonenumber"]));
    $birthdate = htmlspecialchars(trim($_POST["birthdate"]));
    $iban = htmlspecialchars(trim($_POST["iban"]));
    $bic = htmlspecialchars(trim($_POST["bic"]));

    $fullphonenumber = $countrycode . $phonenumber;

    // Passwort hashen, bevor es gespeichert wird
    $password = password_hash(trim($password), PASSWORD_DEFAULT);

    // Überprüfen, ob der Benutzername bereits existiert
    $stmt = $conn->prepare("SELECT username FROM userdata WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Benutzername existiert bereits, zeige eine Fehlermeldung
        echo "<script>showPopup('Der Benutzername ist bereits vergeben. Bitte wähle einen anderen.');</script>";
    } else {
        // Benutzername ist verfügbar, fahre mit der Registrierung fort
        $stmt->close(); // Alte Abfrage schließen

        // Neue SQL-Abfrage zum Einfügen des Benutzers
        $stmt = $conn->prepare("INSERT INTO `userdata` (`username`, `password`, `FirstName`, `LastName`, `Email`, `Continent`, `Phone`, `BirthDate`, `IBAN`, `BIC`, `balance`) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
        $stmt->bind_param('ssssssssss', $username, $password, $firstname, $lastname, $email, $continent, $fullphonenumber, $birthdate, $iban, $bic);

        // Abfrage ausführen
        if ($stmt->execute()) {
            echo "<script>showPopup('Registrierung erfolgreich!');</script>";
            // Optional kannst du die Seite weiterleiten
            header("Location: Login.php");
            exit();
        } else {
            echo "<script>showPopup('Fehler bei der Registrierung: " . $stmt->error . "');</script>";
        }
    }

    // Verbindungen schließen
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="LoginRegister.css">
    <link rel="icon" href="/images/Affing_Logo.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Affing</title>
    <style>
        /* Popup-Design */
        #popup {
            display: none; /* Standardmäßig versteckt */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f44336; /* Rote Farbe für Fehler */
            color: white;
            padding: 15px;
            border-radius: 5px;
            z-index: 1000;
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="menu-content">
            <div class="menu-logo"><img src="../../images/Affing_Logo.png" alt="logo"></div>
            <div class="title-container">
                <a href="../../Affing.php"><span class="title">Affing</span></a>
            </div>
            <button class="menu-toggle" onclick="toggleMenu()">☰</button> 
            <ul class="menu-links">
                <li><a href="/../Affing.php">Home</a></li>
                <li><a href="/../Create/create.php">Create Link</a></li>
                <li><a href="/../User/LoginRegister/Register.php">Sign up</a></li>
                <li><a href="/../User/LoginRegister/Login.php">Login</a></li>
                <li><a href="/../About.php">About us</a></li>
            </ul>
        </div>
    </div>

    <!-- Popup-Bereich -->
    <div id="popup"></div>

    <div class="content">
        <div class="form-container">
            <h2>Register</h2>
        
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="JohnSmith123" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
        
                <label for="confirmpassword">Confirm Password:</label>
                <input type="password" id="confirmpassword" name="confirmpassword" required>

                <label for="email">E-Mail:</label>
                <input type="email" id="email" name="email" placeholder="example.mail@hotmail.com" required>

                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" placeholder="John" required>

                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" placeholder="Smith" required>
        
                <select id="continent" name="continent">
                    <option value="AF">Africa</option>
                    <option value="AN">Antarctica</option>
                    <option value="AS">Asia</option>
                    <option value="EU" selected>Europe</option>
                    <option value="NA">North America</option>
                    <option value="OC">Oceania</option>
                    <option value="SA">South and Central America</option>
                </select>

                <br/>
                <label for="phonenumber">Phone Number:</label>
                <input type="text" id="countrycode" name="countrycode" required placeholder="+41">
                <br>
                <input type="tel" id="phonenumber" name="phonenumber" required placeholder="79 123 45 68">

                <label for="birthdate">Birthdate:</label>
                <input type="date" id="birthdate" name="birthdate" required>

                <label for="iban">IBAN:</label>
                <input type="text" id="iban" name="iban" required placeholder="CH89 3704 0044 0532 0130 00">

                <label for="bic">BIC:</label>
                <input type="text" id="bic" name="bic" required placeholder="KBSGCH22">

                <button type="submit" value="Submit">Submit</button>
            </form>
        </div>
    </div>
    
    <footer class="footer">
        <div class="footer-section">
            <h3>General links</h3>
            <ul>
                <li><a href="/../Affing.php">Home</a></li>
                <li><a href="/../Create/create.php">Create Link</a></li>
                <li><a href="/../User/LoginRegister/Register.php">Sign up</a></li>
                <li><a href="/../User/LoginRegister/Login.php">Login</a></li>
                <li><a href="/../About.php">About us</a></li>
                <li><a href="/../GetLink/GetLink.php">Get Linked</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact</h3>
            <p><a href="mailto:benmai576">email</a></p>
        </div>
    </footer>

    <script>
        // Popup anzeigen und nach 3 Sekunden verschwinden lassen
        function showPopup(message) {
            var popup = document.getElementById('popup');
            popup.innerHTML = message;
            popup.style.display = 'block';
            setTimeout(function() {
                popup.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>
