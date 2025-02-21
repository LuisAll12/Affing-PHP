<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Aboutusstyle.css">
    <link rel="icon" href="/images/Affing_Logo.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.cdnfonts.com/css/lemon-milk" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Affing</title>
</head>
<body>
    <div class="header">
        <div class="menu-content">
            <div class="menu-logo"><img src="images/Affing_Logo.png" alt="logo"></div>
            <div class="title-container">
                <a href="Affing.php"><span class="title">Affing</span></a>
            </div>
            <button id="menu-button" class="menu-toggle">☰</button>
            <ul id="menu" class="menu-links">
                <li><a href="Affing.php">Home</a></li>
                <li><a href="/Create/create.php">Create Link</a></li>
                <li class="dropdown">
                        <li><a href="/User/LoginRegister/Register.php">Sign up</a></li>
                        <li><a href="/User/LoginRegister/Login.php">Login</a></li>
                </li>
                <li><a href="About.php">About us</a></li>
                <li><a href="/GetLink/GetLink.php">Get Linked</a></li>
            </ul>
        </div>
    </div>
    <div class="content">
       <div class="about-affing-content">
        <h1>About Us</h1>
    
        <div class="content-wrapper">
            <h2>Welcome to Affing</h2>
            <p>
                Affing is your go-to platform for creating and managing affiliate marketing links effortlessly!
            </p>
            <p>
                At Affing, we believe that affiliate marketing should be simple, transparent, and efficient. Whether you're a content creator, influencer, or a business looking to share products, our platform helps you connect with the right brands and products that align with your audience. By providing access to <strong>searchable affiliate links</strong> and real-time performance <strong>charts</strong>, we empower you to make informed decisions that maximize your impact and revenue.
            </p>

            </div>
            <div>
            <h2>What We Do</h2>
            <div class="flex-list">
                <div class="flex-item">
                    <strong>Create Affiliate Links:</strong> Easily generate personalized affiliate links that cater to your audience and content.
                </div>
                <div class="flex-item">
                    <strong>Search for Links:</strong> Explore a wide variety of affiliate opportunities, tailored to your preferences.
                </div>
                <div class="flex-item">
                    <strong>Track Popular Trends:</strong> Stay ahead of the curve by accessing real-time charts showcasing the most popular affiliate links in your niche.
                </div>
            </div>
        </div>
            <p>
                Our platform was developed as part of the <strong>Young Talents Hackathon</strong>, with a mission to make affiliate marketing accessible to everyone.
            </p>
            
            <h2>Meet the Team</h2>
            <div class="flex-team">
                <div class="team-member">
                    <strong>Gregory Ruoss</strong> (Frontend Developer)
                </div>
                <div class="team-member">
                    <strong>Benjamin Maier</strong> (Frontend Developer)
                </div>
                <div class="team-member">
                    <strong>Luis Allamand</strong> (Backend Developer)
                </div>
                <div class="team-member">
                    <strong>Julian Amschwand</strong> (Backend Developer)
                </div>
            </div>
            
            <h2>Contact Us</h2>
            <p>
                For inquiries or support, feel free to get in touch via <a href="mailto:benmai576">email</a>
            </p>
        </div>
    </div>
    
</body>
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
        menu.classList.toggle('show');
    });
});

</script>
</html>