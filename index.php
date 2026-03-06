<?php
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domain Search & Registration | GoDaddy Clone</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <nav>
        <a href="index.php" class="logo">GoClone<span>.</span></a>
        <div class="nav-links">
            <a href="#">Domains</a>
            <a href="#">Hosting</a>
            <a href="#">Security</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="btn-login">Dashboard</a>
                <a href="logout.php" class="btn-signup">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn-login">Sign In</a>
                <a href="signup.php" class="btn-signup">Join Now</a>
            <?php endif; ?>
        </div>
    </nav>

    <section class="hero">
        <div class="content">
            <?php if(isset($_GET['error'])): ?>
                <div style="max-width: 600px; margin: 0 auto 2rem auto; padding: 1rem; background: #feebeb; color: var(--error); border-radius: 10px; font-weight: 600; border: 1px solid rgba(217, 48, 37, 0.2);">
                    <?php 
                        if($_GET['error'] == 'taken') echo "Sorry, " . htmlspecialchars($_GET['domain'] ?? '') . " was just taken or already registered to your account.";
                        else echo "Something went wrong. Please try again.";
                    ?>
                </div>
            <?php endif; ?>

            <h1>Find your perfect domain.</h1>
            <p>The world's largest domain registrar. Get started for as low as $9.99/yr</p>
            
            <div class="search-container">
                <form id="searchForm" class="search-box">
                    <input type="text" id="domainInput" placeholder="Search for your next idea (e.g. mybrand.com)" required autocomplete="off">
                    <button type="submit" id="searchBtn" class="btn-search">
                        <span class="btn-text">Search Domain</span>
                        <div class="loader"></div>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <div class="results-area" id="resultsArea">
        <div class="result-card" id="resultCard">
            <!-- Results will be injected here via script.js -->
        </div>
    </div>

    <section style="padding: 5rem 10%; background: #fff;">
        <h2 style="text-align: center; margin-bottom: 3rem; font-size: 2.5rem;">Why choose us?</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="padding: 2rem; border-radius: 15px; background: #f9f9f9;">
                <h3 style="margin-bottom: 1rem;">24/7 Support</h3>
                <p>We're here to help you every step of the way, day or night.</p>
            </div>
            <div style="padding: 2rem; border-radius: 15px; background: #f9f9f9;">
                <h3 style="margin-bottom: 1rem;">Secure & Reliable</h3>
                <p>Your data and domains are protected with industry-leading security.</p>
            </div>
            <div style="padding: 2rem; border-radius: 15px; background: #f9f9f9;">
                <h3 style="margin-bottom: 1rem;">Easy Management</h3>
                <p>Manage all your domains and hosting from one simple dashboard.</p>
            </div>
        </div>
    </section>

    <footer style="background: #111; color: #fff; padding: 4rem 10%; text-align: center;">
        <p>&copy; <?php echo date('Y'); ?> GoClone Domain Platform. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
