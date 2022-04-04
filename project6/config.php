<?php
// URL: https://icarus.cs.weber.edu/~ab13559/WEB3400/project5/
// Database: https://icarus.cs.weber.edu/phpmyadmin/index.php
?>

<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'W01113559';
$DATABASE_PASS = 'Anthonycs!';
$DATABASE_NAME = 'W01113559';

// Try to connect to our db
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
  // If there is an error with the connection, stop the script and display the error
  exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

function pdo_connect_mysql()
{
  // create the db connection variables
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'W01113559';
  $DATABASE_PASS = 'Anthonycs!';
  $DATABASE_NAME = 'W01113559';

  // db connection
  try {
    return new PDO(
      'mysql:host=' . $DATABASE_HOST .
      ';dbname=' . $DATABASE_NAME .
      ';charset=utf8',
      $DATABASE_USER,
      $DATABASE_PASS
    );

  } catch (PDOException $exception) {
    die('PDO Failed to connect to the database.');
  }
}

function getMyUrl()
{
  $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  $regex_pattern = '/(.*)\/.*\.php/'; // remove file name
  return 'https://' . preg_replace($regex_pattern, '$1', $url);
}

function template_header($title = "Page title")
{
  echo <<<EOT
 <!DOCTYPE html>
  <html>

    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>$title</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
     <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
     <script defer src="js/bulma.js"></script>
    </head>

  <body>
EOT;
}

function template_nav($siteTitle = "Site Title")
{
  echo <<<EOT
  <!-- START NAV -->
    <nav class="navbar is-light">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item" href="index.php">
            <span class="icon is-large">
              <i class="fas fa-home"></i>
            </span>
            <span>$siteTitle</span>
          </a>
          <div class="navbar-burger burger" data-target="navMenu">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <div id="navMenu" class="navbar-menu">
          <div class="navbar-start">
            <!-- navbar link go here -->
          </div>
          <div class="navbar-end">
            <div class="navbar-item">
              <div class="buttons">
                <a href="profile.php" class="button">
                  <span class="icon"><i class="fas fa-user"></i></span>
                  <span>Profile</span>
                </a>
                <a href="polls.php" class="button">
                  <span class="icon"><i class="fas fa-poll"></i></span>
                  <span>Polls</span>
                </a>
                <a href="contacts.php" class="button">
                  <span class="icon"><i class="fas fa-address-book"></i></span>
                  <span>Contacts</span>
                </a>
                <a href="logout.php" class="button">
                  <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                  <span>Sign Out</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- END NAV -->

    <!-- START MAIN -->
    <section class="section">
        <div class="container">
EOT;
}

function template_footer()
{
  echo <<<EOT
        </div>
    </section>
    <!-- END MAIN-->

    <!-- START FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>Footer content goes here</p>
        </div>
    </footer>
    <!-- END FOOTER -->
    </body>
  </html>
EOT;
}
