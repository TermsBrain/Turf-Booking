<!DOCTYPE html>
<html lang="en">

<?php include_once('includes/header.php'); ?>

<body>
  <nav class="navbar navbar-expand-lg navbar-light " style="background-color:#e9e7e7;">
    <!-- Logo -->
    <img src="assets/img/logo.png">
    <a class="navbar-brand" href="#" style="font-family: 'Your Font', sans-serif; font-size: 20px; font-weight: bold; color: #454545;">Terms Sports Arena</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contact">Contact</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Left Side (Button and Tagline) -->
  <!-- Cover Photo -->
  <div class="cover-content">
    <img src="assets/img/cover.jpg" alt="Cover Photo" class="cover-photo">
  </div>
  <div class="left-content">
    <h3 style="color:#000000">Unleash Your Inner Athlete</h3>
    <p class="tagline">Your tagline goes here</p>
    <a href="#" id="bookNowButton">
      <button class="cta-button">Book Now</button>
    </a>
  </div>

  <!-- ======= About Section ======= -->
  <section id="about" class="about section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>About Us</h2>
        <h3><span>Discover More About Turf</span></h3>
        <p></p>
      </div>
      <div class="row">
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
          <img src="assets/img/about.jpg" class="img-fluid" alt=" [Name] Turf Image" style="max-width: 100%; height: 80%;">
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
          <!-- <h3 class="mb-4">Unleash Your Inner Athlete</h3> -->
          <h3 class="mb-4">Terms Brain Sports Arena</h3>
          <p>
            Experience the perfect fusion of passion and sportsmanship at [Name] Turf – your unrivaled destination for heart-pounding Olympic-style football played on meticulously maintained turf courts. Immerse yourself in the game, book your playtime slots, and savor the thrill of competition. [Name] Turf: Where Football and Fun Collide!</p>
        </div>
      </div>
    </div>
  </section>
  <section id="features" class="features section-bg">
    <div class="container">
      <div class="features-section">
      <div class="section-title text-center pb-4">
        <h2>Special Features</h2>
      </div>
        <div class="features-container">
          <div class="features-box" style="background-image: url('assets/img/football.jpg');">
            <!--<img src="img/icons8-dollar-48.png" alt="Micro features" />-->
            <h3 class="features-title">Football Turf</h3>
          </div>
          <div class="features-box" style="background-image: url('assets/img/badminton.jpg');">
            <!--<img src="img/icons8-dollar-48.png" alt="Standard features" />-->
            <h3 class="features-title">Badminton</h3>
          </div>
          <div class="features-box" style="background-image: url('assets/img/cricket.jpg');">
            <!--<img src="img/icons8-dollar-48.png" alt="ECN features" />-->
            <h3 class="features-title">Cricket</h3>
          </div>
          <div class="features-box" style="background-image: url('assets/img/carparking.jpg');">
            <!--<img src="img/icons8-dollar-48.png" alt="Customiz features" />-->
            <h3 class="features-title">Car Parking</h3>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="features" class="features section-bg">
    <div class="container" data-aos="fade-up">

      <!-- <div class="section-title">
        <h2 class="text-center">Features & Facilities</h2>
        <p>Explore the Exceptional Amenities at Kick OFF Football Ground</p>
      </div> -->

      <div class="section-title text-center pb-4">
        <h2>Features & Facilities</h2>
        <p class="mb-4">Explore the Exceptional Amenities at Kick OFF Football Ground</p>
      </div>
      <div class="row">
        <div class="col-lg-6 " data-aos="fade-right" data-aos-delay="100">
          <!-- <h3>Facilities</h3> -->
          <!-- <ul>
            <li>Two Separate team rooms with toilet and change rooms</li>
            <li>Drinks available to buy</li>
            <li>Seating arrangement in the roof</li>
            <li>Kitchen facilities</li>
            <li>Adequate lighting and Generator</li>
            <li>Car Parking Facilities</li>
            <li>Top-notch sound system with wireless microphone</li>
            <li>CCTV Camera surveillance & Free Wifi</li>
          </ul> -->
          <!-- Facilities Section start Here! -->
          <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne"  style="font-weight: bold;">
                Facilities #1
                </button>
              </h2>
              <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo"  style="font-weight: bold;">
                Facilities #2
                </button>
              </h2>
              <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree"  style="font-weight: bold;">
                Facilities #3
                </button>
              </h2>
              <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
              </div>
            </div>
          </div>
        </div>
        <!-- Facilities Section End Here! -->

        <div class="col-lg-6 pt-4 pt-lg-0" data-aos="fade-up" data-aos-delay="100">
          <!-- <h3>Key Features</h3> -->
          <!-- <ul>
            <li>The Grass of Kick OFF Football Ground has been manufactured by FIFA Licensee manufacturer of artificial turf in China</li>
            <li>Dual-colored Astro turf</li>
            <li>Excellent view from the roof for enjoying the match while having food</li>
            <li>Excellent drainage system allowing players to play during rain</li>
            <li>Rainwater does not clog</li>
          </ul> -->

          <!-- Key Features Section start Here! -->
          <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne1">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne1" aria-expanded="false" aria-controls="flush-collapseOne"  style="font-weight: bold;">
                Key Features #1
                </button>
              </h2>
              <div id="flush-collapseOne1" class="accordion-collapse collapse" aria-labelledby="flush-headingOne1" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingTwo2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo2" aria-expanded="false" aria-controls="flush-collapseTwo"  style="font-weight: bold;">
                Key Features #2
                </button>
              </h2>
              <div id="flush-collapseTwo2" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo2" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingThree3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree3" aria-expanded="false" aria-controls="flush-collapseThree"  style="font-weight: bold;">
                Key Features #3
                </button>
              </h2>
              <div id="flush-collapseThree3" class="accordion-collapse collapse" aria-labelledby="flush-headingThree3" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- Key Features Section End Here! -->

  <section class="map-container">
    <!-- <div class="section-title text-center">
  <h3> <span>Find Us On Map</span></h3> -->
    <div class="section-title text-center pb-4 mb-4 pt-4">
      <h2>Find Us On Map</h2>
    </div>

    </div>
    <div class="container responsive-map" data-wow-delay="0.1s">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387.67299698642506!2d91.86598556300748!3d22.421952870828974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30ad287ed3af39d1%3A0xcb2295afdaae100d!2sOli%20Ahmed%20CNG%20station!5e0!3m2!1sen!2sbd!4v1702215951917!5m2!1sen!2sbd" style="border:1;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </section>


  <!-- Footer Start -->

  <footer class="text-white text-center text-lg-start bg-dark">
    <!-- Grid container -->
    <div class="container p-4">
      <!--Grid row-->
      <div class="row mt-4">
        <!--Grid column-->
        <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">Terms Brain Sports Arena</h5>

          <p>
            At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium
            voluptatum deleniti atque corrupti.
          </p>

          <p>
            Blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas
            molestias.
          </p>

          <div class="mt-4">
            <!-- Facebook -->
            <a class="btn btn-primary" style="background-color: #3b5998;" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>
            <!-- Whatsapp -->
            <a class="btn btn-primary" style="background-color: #25d366;" href="#!" role="button"><i class="fab fa-whatsapp"></i></a>
            <!-- Instagram -->
            <a class="btn btn-primary" style="background-color:  #bc2a8d;" href="#!" role="button"><i class="fab fa-instagram"></i></a>
            <!-- Youtube -->
            <a class="btn btn-primary" style="background-color: #ed302f;" href="#!" role="button"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
          <ul class="fa-ul" style="margin-left: 1.65em;">
            <li class="mb-3">
              <span class="fa-li"><i class="fas fa-home"></i></span><span class="ms-2">Lalkhan Bazar, 00-967, Poland</span>
            </li>
            <li class="mb-3">
              <span class="fa-li"><i class="fas fa-home"></i></span><span class="ms-2">Sub Branch ,89-961, Australia</span>
            </li>
            <li class="mb-3">
              <span class="fa-li"><i class="fas fa-envelope"></i></span><span class="ms-2">contact@example.com</span>
            </li>
            <li class="mb-3">
              <span class="fa-li"><i class="fas fa-phone"></i></span><span class="ms-2">+ 48 234 567 88</span>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">Opening hours</h5>

          <table class="table text-center text-white">
            <tbody class="fw-normal">
              <tr>
                <td>Mon - Thu:</td>
                <td>8am - 9pm</td>
              </tr>
              <tr>
                <td>Fri - Sat:</td>
                <td>8am - 1am</td>
              </tr>
              <tr>
                <td>Sunday:</td>
                <td>9am - 10pm</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2020 Copyright:
      <a class="text-white" href="https://mdbootstrap.com/">Termsbrain.com</a>
    </div>
    <!-- Copyright -->
  </footer>

  <!-- Messenger Chat Plugin Code -->
  <!-- <div id="fb-root"></div> -->

  <!-- Your Chat Plugin code -->
  <!-- <div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "113909748473078");
  chatbox.setAttribute("attribution", "biz_inbox");
</script> -->

  <!-- Your SDK code -->
  <!-- <script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml: true,
      version: 'v18.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script> -->
  <!-- End of .container -->

  <!-- ./Footer -->

  <!-- Bootstrap JS and Popper.js (Required for Bootstrap components) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/your_font_awesome_kit.js" crossorigin="anonymous"></script> <!-- Replace with your Font Awesome kit URL -->
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'></script>
  <script src="assets/js/home.js"></script>
</body>

</html>