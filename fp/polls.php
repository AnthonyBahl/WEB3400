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

//connect to our database using pdo
$pdo = pdo_connect_mysql();

// get all the polls
$stmt = $pdo->query("SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers
                     FROM polls p
                     LEFT JOIN poll_answers pa ON pa.poll_id = p.id
                     GROUP BY p.id");
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Polls') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<div class="columns">
    <!-- START LEFT NAV COLUMN -->
    <div class="column is-one-fifth">
        <?= admin_nav(basename(__FILE__)) ?>
    </div>
    <!-- END LEFT NAV COLUMN -->
    <!-- START RIGHT CONTENT COLUMN-->
    <div class="column">
        <h1 class="title">Polls</h1>
        <!-- Responses -->
        <?php if ($responses) : ?>
            <p class="notification is-danger is-light">
                <?php echo implode('<br>', $responses); ?>
            </p>
        <?php endif; ?>
        <a href="poll-create.php" class="button is-success">Create a New Poll</a>
        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Title</td>
                    <td>Answers</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($polls as $poll) : ?>
                    <tr>
                        <td><?= $poll['id'] ?></td>
                        <td><?= $poll['title'] ?></td>
                        <td><?= $poll['answers'] ?></td>
                        <td>
                            <a href="poll-vote.php?id=<?= $poll['id'] ?>" class="button is-success"><i class="fa-solid fa-check-to-slot"></i></a>
                            <a href="poll-result.php?id=<?= $poll['id'] ?>" class="button is-info"><i class="fa-solid fa-square-poll-horizontal"></i></a>
                            <a href="poll-delete.php?id=<?= $poll['id'] ?>" class="button is-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <!-- END RIGHT CONTENT COLUMN-->
</div>
<!-- END PAGE CONTENT -->
<?= template_footer() ?>