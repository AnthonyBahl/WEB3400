<?php
// URL: https://icarus.cs.weber.edu/~ab13559/web3400/project5/
// Database: https://icarus.cs.weber.edu/phpmyadmin/index.php
?>

<?php
require 'config.php';

$pdo = pdo_connect_mysql();

$responses = [];

// Start the session
session_start();

// If the user is not logged in redirect them to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>

<div class="columns">
                <!-- START LEFT NAV COLUMN-->
                <div class="column is-one-quarter">
                    <aside class="menu">
                        <p class="menu-label"> Admin menu </p>
                        <ul class="menu-list">
                            <li><a href="admin.php" class="is-active"> Admin </a></li>
                            <li><a href="profile.php"> Profile </a></li>
                            <li><a href="polls.php"> Polls </a></li>
                            <li><a href="contacts.php"> Contacts </a></li>
                        </ul>
                    </aside>
                </div>
                <!-- END LEFT NAV COLUMN-->

    <!-- START PAGE CONTENT -->
    <h1 class="title">Admin Center</h1>
    <?php if ($responses) : ?>
        <p class="notification is-danger is-light">
            <?php echo implode('<br>', $responses); ?>
        </p>
    <?php endif; ?>
    <!-- END PAGE CONTENT -->
</div>
    </div>
<?= template_footer() ?>