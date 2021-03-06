<?php
// URL: https://icarus.cs.weber.edu/~ab13559/web3400/project5/
// Database: https://icarus.cs.weber.edu/phpmyadmin/index.php
?>

<?php
require 'config.php';

$responses = [];

// use PDO to connect to our database
$pdo = pdo_connect_mysql();

// If there is a query string value for 'id'
if (isset($_GET['id'])) {
    // get the contact from the DB
    $stmt = $pdo->prepare('SELECT * FROM `polls` WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$poll) {
        exit('A poll did not exist with that ID.');
    }

    // Delete the record if the user clicked yes.
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Delete the record
            $stmt = $pdo->prepare('DELETE FROM `polls` WHERE `id` = ?');
            $stmt->execute([$_GET['id']]);
            
            // Delete the answers
            $stmt = $pdo->prepare('DELETE FROM `poll_answers` WHERE `poll_id` = ?');
            $stmt->execute([$_GET['id']]);
            
            $responses[] = "You have deleted the poll! <a href='polls.php'>Return to polls page</a>";
        } else {
            // Redirect backto contacts
            header('Location: polls.php');
        }
    }
} else {
    $responses[] = "No id Found.";
}

?>

<?= template_header('Delete Poll') ?>
<?= template_nav('Site Title') ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Delete Poll</h1>
    <p>Are you sure you want to delete poll?</p>
    <?= $poll['id'] ?> - <?= $poll['title'] ?> ?
    
    <!-- Response -->
    <?php if ($responses) : ?>
        <p class="notification is-danger is-light"><?php echo implode('<br>', $responses);
                                                echo "<br>";
                                                var_dump($_POST); ?></p>
    <?php endif; ?>

    <div class="buttons">
        <a href="?id=<?= $poll['id'] ?>&confirm=yes" class="button is-success">Yes</a>
        <a href="?id=<?= $poll['id'] ?>&confirm=no" class="button is-danger">No</a>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>