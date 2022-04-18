<?php
require 'config.php';

// Start the session
session_start();

// If the user is not logged in redirect them to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// use PDO to connect to our database
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM contacts');
$stmt->execute();

?>

<?= template_header('Contacts') ?>
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
        <h1 class="title">Reviews</h1>
        <!-- Responses -->
        <?php if ($responses) : ?>
            <p class="notification is-danger is-light">
                <?php echo implode('<br>', $responses); ?>
            </p>
        <?php endif; ?>        
        <div class="reviews">
            <script>
                fetch("reviews-admin-data.php")
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