<?php
// URL: https://icarus.cs.weber.edu/~ab13559/web3400/project5/
// Database: https://icarus.cs.weber.edu/phpmyadmin/index.php
?>

<?php
require 'config.php';

$responses = [];

//additional php code for this page goes here

?>

<?= template_header('Page Title') ?>
<?= template_nav('Site Title') ?>

<!-- Response -->
<?php if($responses) :?>
            <p class="notification is-danger is-light"><?php echo implode('<br>', $responses);
                echo "<br>";
                var_dump($_POST);?></p>
        <?php endif; ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Welcome Home</h1>
    <h2 class="subtitle">This is where page content goes.</h2>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>