<?php 
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $db_username = "root";  
    $db_password = "";      
    $dbname = "affingdb";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $company = htmlspecialchars(trim($_POST["company"]));
    $category = htmlspecialchars(trim($_POST["category"]));
    $url = htmlspecialchars(trim($_POST["link"]));
    $maxclicks = htmlspecialchars(trim($_POST["maxclicks"]));
    $amountperclick = htmlspecialchars(trim($_POST["amountperclick"]));
    $contentinfo = htmlspecialchars(trim($_POST["contentinfo"]));
    $userid = $_SESSION["user_id"];

    $stmt = $conn->prepare("INSERT INTO `url` (`company`, `category`, `url`, `maxnumclick`, `amountperclick`, `contentinfo`, `fk_userid`) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
                          
  $stmt->bind_param('sssssss', $company, $category, $url, $maxclicks, $amountperclick, $contentinfo, $userid);

  // Execute the statement
  $stmt->execute();

  // Close connections
  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="create.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/images/Affing_Logo.png" type="image/png">

    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Affing</title>
    <style>
        .popup {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #073F4D;
            color: #ffff;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 15px;
            display: none; 
            z-index: 1000; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .popup button {
            margin: 5px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .popup .register {
            background-color: #7abf50; 
            color: white;
        }

        .popup .login {
            background-color: #bac8d9; 
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="menu-content">
            <div class="menu-logo"><img src="../images/Affing_Logo.png" alt="logo"></div>
            <div class="title-container">
                <a href="../Affing.php"><span class="title">Affing</span></a>
            </div>
            <ul class="menu-links">
                <li><a href="/../Affing.php">Home</a></li>
                <li><a href="/../Create/create.php">Create Link</a></li>
                <li><a href="/../User/LoginRegister/Register.php">Sign up</a></li>
                <li><a href="/../User/LoginRegister/Login.php">Login</a></li>
                <li><a href="/../About.php">About us</a></li>
                <li><a href="/../GetLink/GetLink.php">Get Link</a></li>
            </ul>
        </div>
    </div>

    <!-- Popup für nicht eingeloggt Benutzer -->
    <div class="popup" id="notificationPopup">
        <p>Your not logged in yet. Registerd a new account or sign in.</p>
        <button class="register" onclick="register()">Register</button>
        <button class="login" onclick="login()">Sign in</button>
    </div>
    <script>
        function showPopup() {
            document.getElementById("notificationPopup").style.display = "block";
            document.getElementById("submitButton").disabled = true; // Deaktiviert den Submit-Button
        }
        function register() {
            window.location.href = '../User/LoginRegister/Register.php'; 
        }
        function login() {
            window.location.href = '../User/LoginRegister/Login.php'; 
        }
        window.onload = function() {
            <?php if (!isset($_SESSION['user_id'])): ?>
                showPopup();
            <?php endif; ?>
        };
    </script>

    <div class="form">
        <div class="form-container">
            <h2>Create your Link</h2>
        
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="name">Company:</label>
                <input type="text" id="company" name="company" placeholder="YourCompany" required><br>
        
                <label for="Category">Category:</label>
                <select id="category" name="category" required>
                    <option value="tech">Technology</option>
                    <option value="finance">Finance</option>
                    <option value="healthcare">Healthcare</option>
                    <option value="education">Education</option>
                    <option value="construction">Construction</option>
                    <option value="manufacturing">Manufacturing</option>
                    <option value="retail">Retail</option>
                    <option value="hospitality">Hospitality</option>
                    <option value="real_estate">Real Estate</option>
                    <option value="transportation">Transportation</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="agriculture">Agriculture</option>
                    <option value="energy">Energy</option>
                    <option value="consulting">Consulting</option>
                    <option value="marketing">Marketing</option>
                </select><br>
        <script>
            function calculateTotal() {
            // Holen der Werte aus den Eingabefeldern
            let maxclicks = parseFloat(document.getElementById('maxclicks').value);
            let amountperclick = parseFloat(document.getElementById('amountperclick').value);

            // Sicherstellen, dass beide Werte numerisch sind
            if (!isNaN(maxclicks) && !isNaN(amountperclick)) {
                // Berechne den Totalbetrag
                let totalAmount = maxclicks * amountperclick;

                // Zeige das Ergebnis an
                document.getElementById('totamount_output').innerHTML = totalAmount.toFixed(2) + ' CHF';
            } else {
                // Setze das Ergebnis zurück, wenn die Eingaben ungültig sind
                document.getElementById('totamount_output').innerHTML = '0.00 CHF';
            }
        }
        </script>
                <label for="link">Website Link:</label>
                <input type="url" id="link" name="link" placeholder="https://Affing.com" required><br>
        
                <label for="maxclicks">Max. Number Clicks:</label>
        <input type="text" id="maxclicks" name="maxclicks" placeholder="200" oninput="calculateTotal()" required><br>

        <label for="amountperclick">Amount per Click:</label>
        <input type="text" id="amountperclick" name="amountperclick" placeholder="0.4 USD" oninput="calculateTotal()" required><br>

                <div id="tot_amount_output">
                    <!--Folie06 Total amount -->
                    <label for="totamount_lbl">Total Amount:</label>
                    <label id="totamount_output">0.00 CHF</label>
                </div>
                
                <label for="contentinfo">Content Info:</label>
                <textarea name="contentinfo" id="contentinfo" rows="6" required></textarea>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-section">
            <h3>General links</h3>
            <ul>
                <li><a href="Affing.php">Home</a></li>
                <li><a href="Create/create.php">Create Link</a></li>
                <li><a href="/../User/LoginRegister/Register.php">Sign up</a></li>
                <li><a href="/../User/LoginRegister/L">Login</a></li>
                <li><a href="About.html">About us</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact</h3>
            <p><a href="mailto:benmai576">email</a></p>
        </div>
    </footer>
</body>
</html>
