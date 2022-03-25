<?php
// URL: https://icarus.cs.weber.edu/~ab13559/web3400/project5/
// Database: https://icarus.cs.weber.edu/phpmyadmin/index.php
?>

<?php
require 'config.php';

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
    <h1 class="title">Pols</h1>
    <p class="subtitle">Welcome, here is our list of polls.</p>
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
            <?php foreach($polls as $poll) : ?>
                <tr>
                    <td><?=$poll['id']?></td>
                    <td><?=$poll['title']?></td>
                    <td><?=$poll['answers']?></td>
                    <td>
                        <a href="poll-vote.php?id=<?=$poll['id']?>" class="button is-success"><i class="fas fa-poll"></i></a>
                        <a href="poll-delete.php?id=<?=$poll['id']?>" class="button is-danger"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>