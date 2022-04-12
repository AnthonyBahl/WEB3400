<?php
// Database: https://icarus.cs.weber.edu/phpmyadmin/index.php
?>

<?php
require 'config.php';

// Start the session
session_start();

// If the user is not logged in redirect them to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

?>

<?= template_header('Page Title') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->
<div class="columns">
    <!-- START LEFT NAV COLUMN -->
    <div class="column is-one-fifth">
        <?= admin_nav(basename(__FILE__)) ?>
    </div>
    <!-- END LEFT NAV COLUMN -->
    <!-- START RIGHT CONTENT COLUMN-->
    <div class="column">
        <h1 class="title">Admin Dashboard</h1>
        <!-- Responses -->
        <?php if ($responses) : ?>
            <p class="notification is-danger is-light">
                <?php echo implode('<br>', $responses); ?>
            </p>
        <?php endif; ?>
        <div class="blog-posts">
            <script>
                fetch("blog-admin.php")
                    .then(response => response.text())
                    .then(data => {
                        document.querySelector(".blog-posts").innerHTML = data;
                    });
            </script>
        </div>
        <br />
        <div class="reviews">
            <script>
                fetch("reviews-admin.php")
                    .then(response => response.text())
                    .then(data => {
                        document.querySelector(".reviews").innerHTML = data;
                    });
            </script>
        </div>
    </div>
    <!-- END RIGHT CONTENT COLUMN-->
</div>
<!-- END PAGE CONTENT -->
<?= template_footer() ?>