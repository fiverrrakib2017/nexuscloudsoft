
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Welcome Our Website</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

   <!-- Vendor CSS Files -->
    <link href="{{ asset('Frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

<!-- Main CSS File -->
<link href="{{ asset('Frontend/assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="assets/img/logo.png" alt="">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home<br></a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#team">Team</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted flex-md-shrink-0" href="index.html#about">Demo request</a>

    </div>
  </header>

  <main class="main">@yield('content')</main>

 <!-- Footer -->
<footer id="footer" class="footer">

    <!-- CTA Section -->
    <div class="footer-newsletter">

        <div class="container">

            <div class="row justify-content-center text-center">

                <div class="col-lg-8">

                    <h3 class="fw-bold">
                        Ready to Grow Your ISP Business?
                    </h3>

                    <p class="mt-3">

                        Automate billing, manage customers, monitor networks,
                        and scale your ISP with our all-in-one Billing Management Software.

                    </p>

                    <div class="mt-4">

                        <a href="#pricing" class="btn btn-primary me-2">

                            View Pricing

                        </a>

                        <a href="#contact" class="btn btn-outline-primary">

                            Contact Us

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Footer Top -->

    <div class="container footer-top">

        <div class="row gy-4">

            <!-- About -->

            <div class="col-lg-4 col-md-6 footer-about">

                <a href="index.html" class="d-flex align-items-center">

                    <span class="sitename">
                        ISP Billing
                    </span>

                </a>

                <div class="footer-contact pt-3">

                    <p>
                    A complete ISP Billing & Network Management solution for Internet Service Providers. Automate billing, manage customers, monitor MikroTik & OLT devices, and grow your business with confidence.
                    </p>

                    <p class="mt-3">

                        <strong>Phone :</strong>

                        <span>+880 1700-000000</span>

                    </p>

                    <p>

                        <strong>Email :</strong>

                        <span>support@yourdomain.com</span>

                    </p>

                </div>

            </div>

            <!-- Quick Links -->

            <div class="col-lg-2 col-md-3 footer-links">

                <h4>Quick Links</h4>

                <ul>

                    <li><i class="bi bi-chevron-right"></i> <a href="#hero">Home</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#about">About</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#features">Features</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#pricing">Pricing</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#contact">Contact</a></li>

                </ul>

            </div>

            <!-- Services -->

            <div class="col-lg-3 col-md-3 footer-links">

                <h4>Our Solutions</h4>

                <ul>

                    <li><i class="bi bi-chevron-right"></i> <a href="#">ISP Billing</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#">MikroTik Automation</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#">OLT Monitoring</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#">Payment Gateway</a></li>

                    <li><i class="bi bi-chevron-right"></i> <a href="#">Customer Portal</a></li>

                </ul>

            </div>

            <!-- Follow -->

            <div class="col-lg-3 col-md-12">

                <h4>Connect With Us</h4>

                <p>

                    Follow us for software updates,
                    feature releases, and ISP industry news.

                </p>

                <div class="social-links d-flex">

                    <a href="#">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a href="#">
                        <i class="bi bi-youtube"></i>
                    </a>

                    <a href="#">
                        <i class="bi bi-linkedin"></i>
                    </a>

                    <a href="#">
                        <i class="bi bi-github"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- Copyright -->

    <div class="container copyright text-center mt-4">

        <p>

            © <strong class="px-1">ISP Billing Management Software</strong>

            All Rights Reserved.

        </p>

        <div class="credits">

            Designed & Developed by
            <strong>Your Company Name</strong>

        </div>

    </div>

</footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
<script src="{{ asset('Frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('Frontend/assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('Frontend/assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('Frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('Frontend/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('Frontend/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('Frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('Frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

<!-- Main JS File -->
<script src="{{ asset('Frontend/assets/js/main.js') }}"></script>

</body>

</html>