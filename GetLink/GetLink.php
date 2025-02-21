<?php
session_start();

// Database connection details
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "affingdb";

// Verbindung zur Datenbank herstellen
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Default SQL query without filters
$sql = "SELECT urlid, company, category, case when sum(visits) is null then maxnumclick else maxnumclick - sum(visits) end as clicksavailable, amountperclick AS amount_per_click FROM url left join trackinglinks on urlid = fk_urlid group by url.urlid, url.company, url.category, url.maxnumclick, url.amountperclick";

// Process POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize the form inputs
    $categoryfilter = htmlspecialchars(trim($_POST["categoryfilter"]));
    $numbers = htmlspecialchars(trim($_POST["numbers"]));
    $order = htmlspecialchars(trim($_POST["order"]));

    // Base query with category filter
    if ($categoryfilter !== "none") {
        $sql .= " WHERE category = ?";
    }

    // Validate `numbers` and `order` for sorting
    if ($numbers !== "none") {
        // Ensure column and order are safe and valid
        $validColumns = ['clicksavailable', 'amountperclick'];
        $validOrder = ['asc', 'desc'];

        if (in_array($numbers, $validColumns) && in_array($order, $validOrder)) {
            $sql .= $categoryfilter !== "none" ? " ORDER BY $numbers $order" : " ORDER BY $numbers $order";
        }
    }

    // Prepared statement with category filter if applicable
    if ($categoryfilter !== "none") {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $categoryfilter);  // Bind category filter
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query($sql);  // Execute query without category filter
    }
} else {
    // Default case: execute without filters
    $result = $conn->query($sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="GetLink.css">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Affing</title>
    <style>
        a {

            color: #193940;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        td:has(a) {
            background-color: #9BF272;
        }
        table {
            margin-top: 10px;
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: center;
        } 

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        th {
            background-color: #0F5973;
            color: white;
        }

        caption {
            font-size: 1.5em;
            margin-bottom: 10px;
            font-weight: bold;
            color: #0F5973;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

    </style>
</head>

<body>
    <div class="header">
        <div class="menu-content">
            <div class="menu-logo"><img src="/../images/Affing_Logo.png" alt="logo"></div>
            <div class="title-container">
                <a href="../Affing.php"><span class="title">Affing</span></a>
            </div>
            <button class="menu-toggle" onclick="toggleMenu()">☰</button> <!-- Add this for mobile menu -->
            <ul class="menu-links">
                <li><a href="/../Affing.php">Home</a></li>
                <li><a href="/../Create/create.php">Create Link</a></li>
                <li><a href="/../User/LoginRegister/Register.php">Sign up</a></li>
                <li><a href="/../User/LoginRegister/Login.php">Login</a></li>
                <li><a href="/../About.php">About us</a></li>
            </ul>
        </div>
    </div>
    <div class="popup" id="notificationPopup">
        <p>Your not logged in yet. Register a new account or sign in.</p>
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
    <table id="leaderboard" class="leaderboard-table">
        <caption>Leaderboard</caption>
        <form method="POST">
        <label for="categoryfilter">Category Filter: </label>
            <select id="categoryfilter" name="categoryfilter">
                <option value="none">- None -</option>
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
            </select>
        <label for="numbers">Numbers:</label>
            <select id="numbers" name="numbers">
                <option value="none">- None -</option>
                <option value="clicksavailable">Clicks Available</option>
                <option value="amountperclick">Amount Per Click</option>
            </select>
        <label for="order">Order:</label>
            <select id="order" name="order">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        <button type="submit">Set Filter</button>
        </form>
        <tr>
            <th>Company</th>
            <th>Category</th>
            <th>Available Clicks</th>
            <th>Amount per Click</th>
            <th>Get Link</th>
        </tr>

        <!-- PHP zum Abrufen und Anzeigen der Daten -->
        <?php
        if ($result->num_rows > 0) {
            // Ausgabe der Daten in jede Tabellenzeile
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['company']) . "</td>";
                echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                echo "<td>" . htmlspecialchars($row['clicksavailable']) . "</td>";
                echo "<td>" . htmlspecialchars($row['amount_per_click']) . "</td>";
                echo "<td><a href=LinkPage/LinkPage.php?urlid=" . $row["urlid"] . ">Show Link</a></td>";
            }
        } else {
            echo "<tr><td colspan='4'>No links found</td></tr>";
        }

        // Verbindung zur Datenbank schließen
        $conn->close();
        ?>

    </table>
</body>
<footer class="footer">
    <div class="footer-section">
        <h3>General links</h3>
        <ul>
            <li><a href="/../Affing.php">Home</a></li>
            <li><a href="/../Create/create.php">Create Link</a></li>
            <li><a href="/../User/LoginRegister/Register.php">Sign up</a></li>
            <li><a href="/../User/LoginRegister/Login.php">Login</a></li>
            <li><a href="/../About.html">About us</a></li>
            <li><a href="GetLink/GetLink.php">Get Linked</a></li>
        </ul>
    </div>
    <div class="footer-section">
        <h3>Contact</h3>
        <p><a href="mailto:benmai576">email</a></p>
    </div>
</footer>
<script>
        function toggleMenu() {
            const menuLinks = document.querySelector('.menu-links');
            menuLinks.classList.toggle('show'); 
        }
    </script>



</html>