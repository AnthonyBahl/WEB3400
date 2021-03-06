<?php
// URL: https://icarus.cs.weber.edu/~ab13559/web3400/project5/
// Database: https://icarus.cs.weber.edu/phpmyadmin/index.php
?>

<?php
require 'config.php';

$pdo = pdo_connect_mysql();
$responses = [];

if (!empty($_POST)) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $desc = isset($_POST['desc']) ? $_POST['desc'] : '';

    $stmt = $pdo->prepare('INSERT INTO `polls`(`title`, `desc`) VALUES (?,?)');
    $stmt->execute([$title, $desc]);

    $poll_id = $pdo->lastInsertId();

    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';

    // for each answer in the answers array, do an insert into the poll_answers table
    foreach ($answers as $answer) {
        $stmt = $pdo->prepare('INSERT INTO `poll_answers` (`poll_id`, `title`) VALUES (?,?)');
        $stmt->execute([$poll_id, $answer]);
    }

    $responses[] = "Your poll was created successfully! <a href='polls.php'>Click Here</a> to return to the polls page.";
}

?>

<?= template_header('Create Poll') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Create Poll</h1>
<?php if ($responses) : ?>
    <p class="notification is-danger is-light">
        <?php echo implode('<br>', $responses); ?>
    </p>
<?php endif; ?>
<form action="" method="post">
    <div class="field">
        <label class="label" for="title">Title</label>
        <div class="control">
            <input id="title" class="input" name="title" placeholder="Poll Title">
        </div>
    </div>
    <div class="field">
        <label class="label" for="desc">Description</label>
        <div class="control">
            <input id="desc" class="input" name="desc" placeholder="Poll Description">
        </div>
    </div>
    <div class="field">
        <label class="label" for="answers">Answers (one answer per line)</label>
        <div class="control">
            <textarea class="textarea" name="answers" id="answers" placeholder="Answers go here..."></textarea>
        </div>
    </div>
    <div class="field is-grouped is-grouped-left">
        <div class="field">
            <div class="control">
                <button class="button is-link">Create Poll</button>
            </div>
        </div>
        <!-- Cancel Button -->
        <p class="control">
            <a href="polls.php" class="button is-light">
                Cancel
            </a>
        </p>
    </div>
</form>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>