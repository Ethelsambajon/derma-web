<?php
session_start();
include '../dbcon.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../design.css">
    <title>About Us</title>

</head>

<body style = "background-color: violet">
    <!-- Navbar -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="customers-page.php">
                <img src="../resources/dmlogo.jpg" alt="Starbucks Logo" class="logo" style="width: 100px; height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="customers-page.php">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link bg-secondary rounded" href="about-us.php">
                            <i class="bi bi-info-circle"></i> About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact-us.php">
                            <i class="bi bi-envelope"></i> Contact Us
                        </a>
                    </li>
                </li>
                </ul>
                
                <!-- Right-aligned links -->
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id'])) : ?>
                        <!-- If customer is logged in -->
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#cartModal"><i class="bi bi-cart4"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person"></i> Settings
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownAuthLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Authenticate
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAuthLink">
                                <li><a class="dropdown-item" href="../customers-login.php">Login</a></li>
                                <li><a class="dropdown-item" href="../customers-signup.php">Sign Up</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- About Us Content -->
    <div class="container mt-4">
            <div class="d-flex justify-content-center mb-2">
        <div class="row">
            <div class="col-lg-8 mx-auto">
            <h2 class="mb-4"><b>A Commitment To Beauty And Wellness</b></h2>
                <p>Welcome to <b>Dermcare</b>, one of the Philippines leading skin, hair, and wellness centers. We invite you to escape from life’s daily stresses, and bask in pure body and soul pampering in our network of branches all over the country.</p>
                <p>At <b>Dermcare</b>, you can indulge with a relaxing and therapeutic facials, or retreat to our luxurious spa for a soothing massage that will stimulate your body’s own healing process. Our lavish body scrubs and signature skin and body treatments, are sure to delight and make you feel good all over.</p>
                <p>Indulge in one of our transforming cosmetic skin services that will result in fresher and youthful looking skin. As a total center for wellness and beauty, we also have specialized services for the hair, and other Dermatological treatments provided by duly-licensed physicians and therapists.</p>
                <p>You deserve this opportunity to make a difference in your own well being. Come to <b>Dermcare</b> Professional Skin, Hair and Spa, your trusted partner for more than 30 years now.</p>
                <p>We encourage you to learn more about our services, team of experienced professionals, and commitment to our clients... right now.</p>
                <p>You’ll certainly love the unique <b>Dermcare</b> touch and pampering.</p>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <?php include 'cart.php'; ?>

</body>
</html>
