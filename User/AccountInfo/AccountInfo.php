<?php session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "affingdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_id = $_SESSION['user_id']; // Assuming you have the user ID from session or other logic

$sql = "SELECT * FROM userdata WHERE userId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data from the form
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $iban = htmlspecialchars(trim($_POST["iban"]));
    $bic = htmlspecialchars(trim($_POST["bic"]));
    $birthdate = htmlspecialchars(trim($_POST["birthdate"]));
    $continent = htmlspecialchars(trim($_POST["continent"]));
    $balance = htmlspecialchars(trim($_POST["balance"]));

    // Update the data in the database
    $sql = "UPDATE userdata SET username = ?, password = ?, Email = ?, IBAN = ?, BIC = ?, BirthDate = ?, Continent = ?, Balance = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $username, $password, $email, $iban, $bic, $birthdate, $continent, $balance,);

    if ($stmt->execute()) {
        echo "Data updated successfully!";
    }
}
$stmt->close();
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/images/Affing_Logo.png" type="image/png">

    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Affing</title>
    <link rel="stylesheet" href="AccountInfo.css">

</head>
<body>

    <div class="header">
        <div class="menu-content">
            <div class="menu-logo"><img src="../../images/Affing_Logo.png" alt="logo"></div>
            <div class="title-container">
                <a href="/../Affing.php"><span class="title">Affing</span></a>
            </div>
            <button class="menu-toggle" onclick="toggleMenu()">☰</button> <!-- Add this for mobile menu -->
            <ul class="menu-links">
                <li><a href="/../Affing.php">Home</a></li>
                <li><a href="/../Create/create.php">Create Link</a></li>
                <li><a href="/../User/LoginRegister/Register.php">Sign up</a></li>
                <li><a href="/../User/LoginRegister/Login.php">Login</a></li>
                <li><a href="/../About.php">About us</a></li>
                <li><a href="/../GetLink/GetLink.php">Get Linked</a></li>
            </ul>
        </div>
    </div>

    <div class="form-container">
        <h2>Account Info</h2>

        <form action="AccountInfo.php" method="POST">
            <!-- Pre-filling the fields with values from the database -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo $user['password']; ?>" required>

            <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['Email']; ?>" required>

            <label for="iban">IBAN:</label>
            <input type="text" id="iban" name="iban" value="<?php echo $user['IBAN']; ?>" required>

            <label for="bic">BIC:</label>
            <input type="text" id="bic" name="bic" value="<?php echo $user['BIC']; ?>" required>

            <label for="birthdate">Birthdate:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo $user['BirthDate']; ?>" required>

            <label for="continent">Continent:</label>
            <select id="continent" name="continent" required>
                <option value="AF" <?php echo $user['Continent'] == 'AF' ? 'selected' : ''; ?>>Africa</option>
                <option value="AN" <?php echo $user['Continent'] == 'AN' ? 'selected' : ''; ?>>Antarctica</option>
                <option value="AS" <?php echo $user['Continent'] == 'AS' ? 'selected' : ''; ?>>Asia</option>
                <option value="EU" <?php echo $user['Continent'] == 'EU' ? 'selected' : ''; ?>>Europe</option>
                <option value="NA" <?php echo $user['Continent'] == 'NA' ? 'selected' : ''; ?>>North America</option>
                <option value="OC" <?php echo $user['Continent'] == 'OC' ? 'selected' : ''; ?>>Oceania</option>
                <option value="SA" <?php echo $user['Continent'] == 'SA' ? 'selected' : ''; ?>>South and Central America</option>
            </select>

            <br><label for="balance">Balance:</label>
            <input type="text" id="balance" name="balance" value="<?php echo $user['Balance']; ?>" required>

            <button type="submit">Save All Info</button>
        </form>
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
</body>
</html> 