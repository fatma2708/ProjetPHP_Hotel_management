<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'receptionniste') {
    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Hotelia - Receptionniste Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Mukta+Mahee:200,300,400|Playfair+Display:400,700" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4 site-logo" data-aos="fade">
                    <a href="landing_page.php"><em>Hotelia</em></a>
                </div>
                <div class="col-8">
                    <div class="site-menu-toggle js-site-menu-toggle" data-aos="fade">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="site-navbar js-site-navbar">
                        <nav role="navigation">
                            <div class="container">
                                <div class="row full-height align-items-center">
                                    <div class="col-md-6">
                                        <ul class="list-unstyled menu">
                                            <li><a href="index.html">Home</a></li>
                                            <li><a href="login.php">Logout</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6 extra-info">
                                        <div class="row">
                                            <div class="col-md-6 mb-5">
                                                <h3>Contact Us</h3>
                                                <p>Elghazela pole technopark<br> Ariana</p>
                                                <p>hotelia@esprit.tn</p>
                                                <p>(+216) 71 353 333</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h3>Follow Us</h3>
                                                <ul class="list-unstyled">
                                                    <li><a href="#">Twitter</a></li>
                                                    <li><a href="#">Facebook</a></li>
                                                    <li><a href="#">Instagram</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="site-hero overlay page-inside" style="background-image: url(assets/img/hero_2.jpg)">
        <div class="container">
            <div class="row site-hero-inner justify-content-center align-items-center">
                <div class="col-md-10 text-center">
                    <h1 class="heading" data-aos="fade-up">Receptionniste Dashboard</h1>
                    <p class="sub-heading mb-5" data-aos="fade-up" data-aos-delay="100">Manage bookings efficiently and effectively.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h1 class="text-center">Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>!</h1>
            <ul class="list-unstyled text-center">
                <li><a href="booking_index.php" class="btn btn-primary">Manage Bookings</a></li>
            </ul>
        </div>
    </section>

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
