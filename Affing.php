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

$sql = "SELECT urlid, company, category, case when sum(visits) is null then maxnumclick else maxnumclick - sum(visits) end as clicksavailable, amountperclick FROM url left join trackinglinks on urlid = fk_urlid group by url.urlid, url.company, url.category, url.maxnumclick, url.amountperclick";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $rank1 = $result->fetch_assoc(); // Fetch first result
    if ($result->num_rows > 1) {
        $rank2 = $result->fetch_assoc(); // Fetch second result
    }
    if ($result->num_rows > 2) {
        $rank3 = $result->fetch_assoc(); // Fetch third result  
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/images/Affing_Logo.png" type="image/png">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Affing</title>
</head>
<body>
    <div class="header">
        <div class="menu-content">
            <div class="menu-logo"><img src="images/Affing_Logo.png" alt="logo"></div>
            <div class="title-container">
                <span class="title">Affing</span>
            </div>
            <button id="menu-button" class="menu-toggle">☰</button>
            <ul id="menu" class="menu-links">
                <li><a href="Affing.php">Home</a></li>
                <li><a href="/Create/create.php">Create Link</a></li>
                <li><a href="/User/LoginRegister/Register.php">Sign up</a></li>
                <li><a href="/User/LoginRegister/Login.php">Login</a></li>
                <li><a href="/User/AccountInfo/AccountInfo.php">Account Info</a></li>
                <li><a href="About.php">About us</a></li>
                <li><a href="/GetLink/GetLink.php">Get Linked</a></li>
                
            </ul>
        </div>
    </div>

    <div class="content">
        <div class="info-grid">
            <!-- Section 1: What is Affiliate Marketing -->
            <section class="info-table">
                <div class="info-content-wrapper">
                    <div class="info-image">
                        <img src="/images/InfoAffiliate1.png" alt="InfoAffiliate">
                    </div>
                    <div class="info-content red-box">
                        <h2 class="info-title">What is affiliate marketing?</h2>
                        <p>You promote products and earn commissions when someone buys through your link. It's an easy way to earn revenue online by promoting products that fit your target audience.</p>
                        <a href="/User/LoginRegister/Register.php" class="button">Offers</a>
                        <a href="/GetLink/GetLink.php" class="button">Top links</a>
                    </div>
                </div>
            </section>

            <!-- Section 2: Create a Link -->
            <section class="info-table">
                <div class="info-content-wrapper">
                    <div class="info-content green-box">
                        <h2 class="info-title">Create a link for your company</h2>
                        <p>Create a link in under 5 minutes, in order to market your company on Affing.</p>
                        <a href="/User/LoginRegister/Register.php" class="button">Get started</a>
                        <a href="About.php" class="button">Learn more</a>
                    </div>
                    <div class="info-image">
                        <img src="/images/createLink2.png" alt="Create link">
                    </div>
                </div>
            </section>

            <!-- Section 3: Use a Link -->
            <section class="info-table">
                <div class="info-content-wrapper">
                    <div class="info-image">
                        <img src="/images/UseLink2.png" alt="Use link">
                    </div>
                    <div class="info-content red-box">
                        <h2 class="info-title">Use a link</h2>
                        <p>Search for a link, for which you can create content and earn money for each click.</p>
                        <a href="/User/LoginRegister/Register.php" class="button">Get started</a>
                        <a href="About.php" class="button">Learn more</a>
                    </div>
                </div>
            </section>

            <!-- Section 4: Top Links -->
            <div class="top-link-container">
                <section class="chart">
                <label for="Company"><li><h3><?php echo $rank1["company"] ?></h3></li> </label>
                    <ul class="chart_list">
                        <label for="Company"><li><?php echo $rank1["category"] ?></li> </label>
                        <label for="avclicks"><li><?php echo "$rank1[clicksavailable] Clicks" ?></li> </label>
                        <label for="amount per Click"><li><?php echo "$rank1[amountperclick]$/Click" ?></li> </label>
                        <div class="linkthingi"><a href="/GetLink/GetLink.php" class="button">See more</a> </div>
                    </ul>
                </section>

                <section class="chart">
                <label for="Company"><li><h3><?php echo $rank2["company"] ?></h3></li> </label>
                    <ul class="chart_list">
                        <label for="Company"><li><?php echo $rank2["category"] ?></li> </label>
                        <label for="avclicks"><li><?php echo "$rank2[clicksavailable] Clicks remaining" ?></li> </label>
                        <label for="amount per Click"><li><?php echo "$rank2[amountperclick]$/Click" ?></li> </label>
                        <div class="linkthingi"><a href="/GetLink/GetLink.php" class="button">See more</a> </div>

                    </ul>
                </section>

                <section class="chart">
                <label for="Company"><li><h3><?php echo $rank3["company"] ?></h3></li> </label>
                    <ul class="chart_list">
                        <label for="Company"><li><?php echo $rank3["category"] ?></li> </label>
                        <label for="avclicks"><li><?php echo "$rank3[clicksavailable] Clicks remaining" ?></li> </label>
                        <label for="amount per Click"><li><?php echo "$rank3[amountperclick]$/Click" ?></li> </label>
                        <div class="linkthingi"><a href="/GetLink/GetLink.php" class="button">See more</a> </div>

                    </ul>
                </section>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-section">
            <h3>General links</h3>
            <ul>
                <li><a href="Affing.php">Home</a></li>
                <li><a href="Create/create.php">Create Link</a></li>
                <li><a href="/User/LoginRegister/Register.php">Sign up</a></li>
                <li><a href="/User/LoginRegister/Login.php">Login</a></li>
                <li><a href="About.php">About us</a></li>
                
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact</h3>
            <p><a href="mailto:benmai576">email</a></p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('menu-button');
            const menu = document.getElementById('menu');

            menuButton.addEventListener('click', function() {
                if (menu.classList.contains('show')) {
                    menu.classList.remove('show');
                } else {
                    menu.classList.add('show');
                }
            });
        });
    </script>
</body>
</html>
