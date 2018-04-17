<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>NYC-reise</title>
    <link rel="stylesheet" href="stilark/style.css">
    <link href='https://fonts.googleapis.com/css?family=Text Me One' rel='stylesheet'>
  </head>
  <body>

      <div class="container">
      <div class="nav">
        <a href="index.php" class="btn">Hjem</a>
        <a href="overnatting.php" class="btn">Overnatting</a>
        <a href="reisedit.php" class="btn">Reise dit</a>
        <a href="attraksjoner.php" class="btn">Attraksjoner</a>
        <a href="about.php" class="btn">Om oss</a>
        <a href="admin/adminindex.php" class="btn">Admin</a>
      </div>
        <div class="logo">
          <h1><u>New York Reiser</u></h1>
        </div>

        <video id="ad" width="600" height="100" controls="false" autoplay="autoplay" loop>
          <source src="bilder/animasjon.mp4" type="video/mp4">
              Your browser does not support the video tag.
        </video>

        <center>
          <div id="slideshow">
          <div class="arrow-left" onclick="slideVenstre()"></div>
          <div class="arrow-right" onclick="slideHoyre()"></div>
          <div class='alleSlides'>
            <div class="slide" style="left:0%;">
              <img id="collage" src="bilder/collage.jpg" width="80%">
            </div>
            <div class="slide" style="left:100%;">
              <?php
               include_once 'yr/xml.php';
              ?>
            </div>
          </div>
          </div>
        </center>
      </div>
    <div class="footer">
       <p>NYC-Reise &trade;</p>
    </div>

    <script src="js/slideshow.js"></script>
    <script>
      document.getElementById("ad").controls = false;
    </script>
  </body>
</html>
