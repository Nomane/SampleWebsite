<!DOCTYPE html>
<html lang="en">

<?php

require __DIR__ . '/vendor/aws/aws-autoloader.php';

use Aws\Ssm\SsmClient;
$client = new SsmClient([
    'version' => 'latest',
    'region' => 'eu-west-1',
]);

$servernameRaw = $client->getParameters([
    'Names' => ['SSM_DB_ENDPOINT'],
    'WithDecryption' => true
]);
$usernameRaw = $client->getParameters([
    'Names' => ['SSM_DB_USERNAME'],
    'WithDecryption' => true
]);
$passwordRaw = $client->getParameters([
    'Names' => ['SSM_DB_PASSWORD'],
    'WithDecryption' => true
]);
$databaseRaw = $client->getParameters([
    'Names' => ['SSM_DB_DATABASE'],
    'WithDecryption' => true
]);

$servername = $servernameRaw['Parameters'][0]['Value'];
$username = $usernameRaw['Parameters'][0]['Value'];
$password = $passwordRaw['Parameters'][0]['Value'];
$database = $databaseRaw['Parameters'][0]['Value'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


$sql = "SELECT name FROM country ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $country = $row['name'];
}

$instance_id = file_get_contents("http://instance-data/latest/meta-data/instance-id");

?>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>

    <title>Stylish Portfolio - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic"
          rel="stylesheet" type="text/css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Navigation -->
<a class="menu-toggle rounded" href="#">
    <i class="fas fa-bars"></i>
</a>
<nav id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a class="js-scroll-trigger" href="#page-top">Start Bootstrap</a>
        </li>
        <li class="sidebar-nav-item">
            <a class="js-scroll-trigger" href="#page-top">Home</a>
        </li>
        <li class="sidebar-nav-item">
            <a class="js-scroll-trigger" href="#about">About</a>
        </li>
        <li class="sidebar-nav-item">
            <a class="js-scroll-trigger" href="#services">Services</a>
        </li>
        <li class="sidebar-nav-item">
            <a class="js-scroll-trigger" href="#portfolio">Portfolio</a>
        </li>
        <li class="sidebar-nav-item">
            <a class="js-scroll-trigger" href="#contact">Contact</a>
        </li>
    </ul>
</nav>

<!-- Header -->
<header class="masthead d-flex">
    <div class="container text-center my-auto">
        <h1 class="mb-1">Welcome <?php echo $country; ?> !</h1>
        <h3 class="mb-5">
            <em>This is server #<?php echo $instance_id; ?> managed by <span id="administrator">Nomane</span></em>
        </h3>
        <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">M2C Offers</a>
    </div>
    <div class="overlay"></div>
</header>

<!-- About -->
<section class="content-section bg-light" id="about">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h2>Speed your ascent with M2C !</h2>
                <p class="lead mb-5">
                    Group IS&T provide M2C resources to support BU in their migration
                </p>
                <a class="btn btn-dark btn-xl js-scroll-trigger" href="#services">What We Offer</a>
            </div>
        </div>
    </div>
</section>

<!-- Services -->
<section class="content-section bg-primary text-white text-center" id="services">
    <div class="container">
        <div class="content-section-heading">
            <h3 class="text-secondary mb-0">Services</h3>
            <h2 class="mb-5">What We Offer</h2>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
          <span class="service-icon rounded-circle mx-auto mb-3">
            <i class="icon-screen-smartphone"></i>
          </span>
                <h4>
                    <strong>Technical expertise</strong>
                </h4>
                <p class="text-faded mb-0">Our team is composed of Senior Cloud Architect and they will happy to guide
                    you</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
          <span class="service-icon rounded-circle mx-auto mb-3">
            <i class="icon-pencil"></i>
          </span>
                <h4>
                    <strong>Advisory</strong>
                </h4>
                <p class="text-faded mb-0">Take the good decision and be sure to be compliant with the Cloud best
                    practices</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
          <span class="service-icon rounded-circle mx-auto mb-3">
            <i class="icon-like"></i>
          </span>
                <h4>
                    <strong>Migration Tools</strong>
                </h4>
                <p class="text-faded mb-0">Cost and Speed</p>
            </div>
            <div class="col-lg-3 col-md-6">
          <span class="service-icon rounded-circle mx-auto mb-3">
            <i class="icon-mustache"></i>
          </span>
                <h4>
                    <strong>Spirit of sharing</strong>
                </h4>
                <div class="container text-center w-50 p-7">
                    <p class="text-faded mb-0">Learn quickly and avoid pitfalls</p>
                </div>
            </div>
        </div>
        <div class="container text-center w-25 p-1">
            <a class="btn btn-dark btn-xl js-scroll-trigger" href="#callout">Introduction to M2C</a>
        </div>
    </div>
</section>

<!-- Callout -->
<section class="callout" id="callout">
    <div class="container text-center w-50 p-3">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/FtFXU60OikE?rel=0"
                    allowfullscreen></iframe>
        </div>
    </div>
    <div class="container text-center p-2">
        <p>
            <a class="btn btn-dark btn-xl js-scroll-trigger" href="#projects">Recent projects</a>
        </p>
    </div>
</section>

<!-- Portfolio -->
<section class="content-section" id="projects">
    <div class="container">
        <div class="content-section-heading text-center">
            <h3 class="text-secondary mb-0">Portfolio</h3>
            <h2 class="mb-5">Recent Projects</h2>
        </div>
        <div class="row no-gutters">
            <div class="col-lg-6">
                <a class="portfolio-item" href="#">
            <span class="caption">
              <span class="caption-content">
                <h2>Singapor</h2>
                <p class="mb-0">Tell the story!</p>
              </span>
            </span>
                    <img class="img-fluid" src="img/portfolio-1.jpg" alt="">
                </a>
            </div>
            <div class="col-lg-6">
                <a class="portfolio-item" href="#">
            <span class="caption">
              <span class="caption-content">
                <h2>Sweden</h2>
                <p class="mb-0">Tell the story!</p>
              </span>
            </span>
                    <img class="img-fluid" src="img/portfolio-2.jpg" alt="">
                </a>
            </div>
            <div class="col-lg-6">
                <a class="portfolio-item" href="#">
            <span class="caption">
              <span class="caption-content">
                <h2>Germany</h2>
                <p class="mb-0">Tell the story!</p>
              </span>
            </span>
                    <img class="img-fluid" src="img/portfolio-3.jpg" alt="">
                </a>
            </div>
            <div class="col-lg-6">
                <a class="portfolio-item" href="#">
            <span class="caption">
              <span class="caption-content">
                <h2>North America</h2>
                <p class="mb-0">Tell the story.</p>
              </span>
            </span>
                    <img class="img-fluid" src="img/portfolio-4.jpg" alt="">
                </a>
            </div>
        </div>
    </div>
</section>


<!-- Map -->
<section id="contact" class="map">
    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
            src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=veolia headquarters&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
    <br/>
    <small>
        <a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=veolia headquarters&amp;aq=0&amp;oq=veolia&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A"></a>
    </small>
</section>

<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <ul class="list-inline mb-5">
            <li class="list-inline-item">
                <a class="social-link rounded-circle text-white mr-3" href="#">
                    <i class="icon-social-facebook"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a class="social-link rounded-circle text-white mr-3" href="#">
                    <i class="icon-social-twitter"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a class="social-link rounded-circle text-white" href="#">
                    <i class="icon-social-github"></i>
                </a>
            </li>
        </ul>
        <p class="text-muted small mb-0">Copyright &copy; Your Website 2019</p>
    </div>
</footer>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded js-scroll-trigger" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for this template -->
<script src="js/stylish-portfolio.min.js"></script>

<script src="js/conf.js"></script>

</body>

</html>
