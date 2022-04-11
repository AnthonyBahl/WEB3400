<?php
require 'config.php';

// use PDO to connect to our database
$pdo = pdo_connect_mysql();

// If there is a query string value for 'id'
if (isset($_GET['id'])) {
    // get the contact from the DB
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('A contact did not exist with that ID.');
    }

    // Delete the record if the user clicked yes.
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Delete the record
            $stmt = $pdo->prepare('DELETE FROM `contacts` WHERE `id` = ?');
            $stmt->execute([$_GET['id']]);
            $responses[] = "You have deleted the contact! <a href='contacts.php'>Return to contact page</a>";
        } else {
            // Redirect backto contacts
            header('Location: contacts.php');
        }
    }
} else {
    $responses[] = "No id Found.";
}


?>

<?= template_header('Delete Contact') ?>
<?= template_nav('Site Title') ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Delete Contact</h1>
<!-- Responses -->
<?php if ($responses) : ?>
    <p class="notification is-danger is-light">
        <?php echo implode('<br>', $responses); ?>
    </p>
<?php endif; ?>

<!-- <?php if (isset($_GET['id'])) : ?> -->
<h2 class="subtitle">Are you sure you want to delete contact #
    <?= $contact['id'] ?> - <?= $contact['name'] ?>?
</h2>

<div class="buttons">
    <a href="?id=<?= $contact['id'] ?>&confirm=yes" class="button is-success">Yes</a>
    <a href="?id=<?= $contact['id'] ?>&confirm=no" class="button is-danger">No</a>
</div>
<!-- <?php endif; ?> -->
<!-- END PAGE CONTENT -->

<?= template_footer() ?>