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

// use PDO to connect to our database
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM contacts');
$stmt->execute();

?>

<?= template_header('Read Contacts') ?>
<?= template_nav('Site Title') ?>
<div class="columns">


    <!-- START LEFT NAV COLUMN-->
    <div class="column is-one-quarter">
        <aside class="menu">
            <p class="menu-label"> Admin menu </p>
            <ul class="menu-list">
                <li><a href="admin.php"> Admin </a></li>
                <li><a href="profile.php"> Profile </a></li>
                <li><a href="polls.php"> Polls </a></li>
                <li><a href="contacts.php" class="is-active"> Contacts </a></li>
            </ul>
        </aside>
    </div>
    <!-- END LEFT NAV COLUMN-->
    <div>

        <!-- START PAGE CONTENT -->
        <h1 class="title">Read Contacts</h1>

        <!-- Response -->
        <?php if ($responses) : ?>
            <p class="notification is-danger is-light"><?php echo implode('<br>', $responses);
                                                        echo "<br>";
                                                        var_dump($_POST); ?></p>
        <?php endif; ?>
        <hr />
        <a href='contact-create.php' class='button is-primary'>
            <span>Create Contact</span>
        </a>
        <br /><br />
        <!-- Contacts Table -->
        <table class="table is-fullwidth is-hoverable">
            <thead style="background-color: #D3D3D3">
                <th><abbr title="Number">#</abbr></th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Title</th>
                <th>Created</th>
                <th></th>
            </thead>
            <tbody>
                <?php
                while ($row = $stmt->fetch()) {
                    echo "<tr>
                    <th>" . $row['id'] . "</th>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['phone'] . "</td>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['created'] . "</td>
                    <td style='text-align: right'>
                        <a href='contact-update.php/?id=" . $row['id'] . "' class='button is-primary'>
                            <span class='icon'>
                                <i class='fas fa-edit'></i>
                            </span>
                        </a>
                        <a href='contact-delete.php/?id=" . $row['id'] . "' class='button is-danger'>
                            <span class='icon'>
                                <i class='fas fa-trash-alt'></i>
                            </span>
                        </a>
                    </td>
                </tr>";
                } ?>
            </tbody>
        </table>
        <!-- END PAGE CONTENT -->
    </div>
</div>
<?= template_footer() ?>