<?php
// URL: https://icarus.cs.weber.edu/~ab13559/web3400/project5/
// Database: https://icarus.cs.weber.edu/phpmyadmin/index.php
?>

<?php
require 'config.php';

$pdo = pdo_connect_mysql();

$responses = [];

// Check if there was an ID passed
if (isset($_GET['id'])) {

    // Get the poll answers for the poll that matches the id
    $stmt = $pdo->prepare('SELECT * FROM `polls` WHERE `id` = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the poll exists
    if ($poll) {

        // Get the responses
        $stmt = $pdo->prepare('SELECT * FROM `poll_answers` WHERE `poll_id` = ?');
        $stmt->execute([$_GET['id']]);
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Total number of votes
        $total_votes = 0;
        foreach ($poll_answers as $poll_answer) {
            $total_votes += $poll_answer['votes'];
        }

    } else {
        $responses[] = "There was an error grabing poll with ID of " . $_GET['id'];
    }
} else {
    $responses[] = "You must provide a poll ID.";
}

?>

<?= template_header('Poll Results') ?>
<?= template_nav('Site Title') ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Poll Results</h1>
    <?php if ($responses) : ?>
        <p class="notification is-danger is-light">
            <?php echo implode('<br>', $responses); ?>
        </p>
    <?php endif; ?>
    <h2 class="subtitle"><?= $poll['title']?> (Total votes: <?=$total_votes?>)</h2>

    <div class="container">
        <?php foreach ($poll_answers as $poll_answer) :?>
            <p><?=$poll_answer['title']?> (<?=$poll_answer['votes']?>)</p>
            <progress class="progress is-info is-large"
            value="<?= $poll_answer['votes']?>"
            max="<?= $total_votes?>"></progress>
        <?php endforeach;?>
        <a href="polls.php">Return to polls page</a>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>