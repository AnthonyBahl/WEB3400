<?php
// URL: https://icarus.cs.weber.edu/~ab13559/web3400/project5/
// Database: https://icarus.cs.weber.edu/phpmyadmin/index.php
?>

<?php
require 'config.php';

$responses = [];

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
<div class="columns">


<!-- START LEFT NAV COLUMN-->
<div class="column is-one-quarter">
    <aside class="menu">
        <p class="menu-label"> Admin menu </p>
        <ul class="menu-list">
            <li><a href="admin.php"> Admin </a></li>
            <li><a href="profile.php"> Profile </a></li>
            <li><a href="polls.php" class="is-active"> Polls </a></li>
            <li><a href="contacts.php"> Contacts </a></li>
        </ul>
    </aside>
</div>
<!-- END LEFT NAV COLUMN-->

<!-- Response -->
<?php if($responses) :?>
            <p class="notification is-danger is-light"><?php echo implode('<br>', $responses);
                echo "<br>";
                var_dump($_POST);?></p>
        <?php endif; ?>

    <!-- START PAGE CONTENT -->
    <table class="table">
        <thead>
            <tr>
                <td colspan="4">
                    <h1 class="title">Polls</h1>
                </td>
            </tr>
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
                        <a href="poll-vote.php?id=<?=$poll['id']?>" class="button"><i class="fas fa-poll"></i></a>
                        <a href="poll-delete.php?id=<?=$poll['id']?>" class="button"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    <a href="poll-create.php" class="button is-success">Create a New Poll</a>
                </td>
            </tr>
        </tfoot>
    </table>
    <!-- END PAGE CONTENT -->
            </div>
<?= template_footer() ?>