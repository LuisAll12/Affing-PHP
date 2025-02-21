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

    $username = htmlspecialchars(trim($_POST["username"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    $stmt = $conn->prepare("SELECT userid, username, password FROM userdata WHERE username = ?");
    
    $stmt->bind_param("s", $username);
    
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $password;
        echo $row["password"];
        if (password_verify($password, $row["password"])) {
            $_SESSION['user_id'] = $row['userid'];
            header('Location: ../../Affing.php');
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "Username not found. Please try again.";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="LoginRegister.css">
    <link rel="icon" href="/images/Affing_Logo.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Affing</title>
</head>
<body>
    <div class="header">
        <div class="menu-content">
            <div class="menu-logo">
                <img src="../../images/Affing_Logo.png" alt="logo">
            </div>
            <div class="title-container">
                <a href="../../Affing.php"><span class="title">Affing</span></a>
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
        <h2>Login</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
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
