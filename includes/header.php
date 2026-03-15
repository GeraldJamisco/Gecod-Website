<?php
// Track this page visit (requires $conn to already be set by the calling page)
if (isset($conn)) { include_once __DIR__ . '/tracker.php'; }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php
        $protocol     = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $siteBase     = $protocol . '://' . $_SERVER['HTTP_HOST'];
        $canonicalUrl = $siteBase . strtok($_SERVER['REQUEST_URI'], '?');
        $defaultTitle = 'GECOD Initiative | Empowering Communities in Uganda';
        $defaultDesc  = 'Go Empower Communities for Development Initiative (GECOD) is a youth-led non-profit CBO in Uganda empowering vulnerable communities through education, health, and economic empowerment since 2018. Donate or sponsor a child today.';
        $defaultKw    = 'GECOD Initiative, Uganda NGO, charity Uganda, community development, orphan support Uganda, Lyantonde Uganda, youth empowerment, donate Uganda';
        $metaTitle    = isset($pageTitle)    ? $pageTitle    : $defaultTitle;
        $metaDesc     = isset($pageDesc)     ? $pageDesc     : $defaultDesc;
        $metaKw       = isset($pageKeywords) ? $pageKeywords : $defaultKw;
        $ogImage      = $siteBase . '/img/gecod_intitiative_logo.png';
        ?>
        <title><?php echo htmlspecialchars($metaTitle); ?></title>
        <meta name="viewport"    content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo htmlspecialchars($metaDesc); ?>">
        <meta name="keywords"    content="<?php echo htmlspecialchars($metaKw);   ?>">
        <meta name="robots"      content="index, follow">
        <link rel="canonical"    href="<?php echo htmlspecialchars($canonicalUrl); ?>">

        <!-- Open Graph — Facebook, WhatsApp, LinkedIn previews -->
        <meta property="og:type"        content="website">
        <meta property="og:site_name"   content="GECOD Initiative">
        <meta property="og:locale"      content="en_US">
        <meta property="og:title"       content="<?php echo htmlspecialchars($metaTitle); ?>">
        <meta property="og:description" content="<?php echo htmlspecialchars($metaDesc);  ?>">
        <meta property="og:url"         content="<?php echo htmlspecialchars($canonicalUrl); ?>">
        <meta property="og:image"       content="<?php echo htmlspecialchars($ogImage); ?>">

        <!-- Twitter Card -->
        <meta name="twitter:card"        content="summary_large_image">
        <meta name="twitter:title"       content="<?php echo htmlspecialchars($metaTitle); ?>">
        <meta name="twitter:description" content="<?php echo htmlspecialchars($metaDesc);  ?>">
        <meta name="twitter:image"       content="<?php echo htmlspecialchars($ogImage); ?>">

        <!-- JSON-LD: tells Google exactly what GECOD is -->
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "NGO",
          "name": "Go Empower Communities for Development Initiative",
          "alternateName": "GECOD Initiative",
          "url": "<?php echo $siteBase; ?>",
          "logo": "<?php echo $ogImage; ?>",
          "description": "A youth, women and young people led Non-profit CBO founded in 2018 in Lyantonde, Uganda, empowering vulnerable communities.",
          "foundingDate": "2018",
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "Lyantonde",
            "addressRegion": "Central Uganda",
            "addressCountry": "UG"
          },
          "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+256772586918",
            "contactType": "customer support",
            "email": "info@gecodinitiative.org"
          },
          "sameAs": [
            "https://www.facebook.com/sabiiti.gordan",
            "https://instagram.com/gecodinitiative2018"
          ]
        }
        </script>

        <!-- Favicon -->
        <link href="img/gecod_intitiative_logo.png" rel="icon">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
        

    </head>

    <body>
        <!-- Top Bar Start -->
        <div class="top-bar d-none d-md-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="top-bar-left">
                            <div class="text">
                                <a href="tel:+256 772 586 918" class="text-white">
                                    <p>
                                <i class="fa fa-phone-alt"></i>
                                +256 772 586 918</a>
                            </p>
                            </div>
                            <div class="text">
                                <i class="fa fa-envelope"></i>
                                <p><a href="mailto: info@gecodinitiative.org" class="text-white"> info@gecodinitiative.org</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="top-bar-right">
                            <div class="social">
                                <a href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.facebook.com/sabiiti.gordan" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://instagram.com/gecodinitiative2018?igshid=ZDdkNTZiNTM=" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                                <a href="https://wa.me/message/5Q3X42M7NFYSA1" target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Bar End -->

        <!-- Nav Bar Start -->
        <div class="navbar navbar-expand-lg bg-dark navbar-dark">
            <div class="container-fluid">
                <a href="index.php" class="navbar-brand"><img src="./img/GECOD LOGO NO BACKGROUND.fw.png" alt=""> GECOD INITIATIVE UGANDA</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav ml-auto">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        <a href="Orphans.php" class="nav-item nav-link">Beneficiaries</a>
                        <a href="Road%20Map.php" class="nav-item nav-link">Road Map</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu">
                                <a href="event.php" class="dropdown-item">Events</a>
                                <a href="careers-and-jobs.php" class="dropdown-item">Careers / Jobs</a>
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                        <a href="#donate-section" class="nav-item nav-link nav-donate-btn">
                            <i class="fa fa-heart"></i> Donate Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Nav Bar End -->
