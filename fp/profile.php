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

// We don't have the password or email info stored in session
// so, we can get them from the database
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
//Let's use the account ID session variable to get the account information.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>

<?= template_header('Profile') ?>
<?= template_nav('Site Title') ?>
<div class="columns">


<!-- START LEFT NAV COLUMN-->
<div class="column is-one-quarter">
    <aside class="menu">
        <p class="menu-label"> Admin menu </p>
        <ul class="menu-list">
            <li><a href="admin.php"> Admin </a></li>
            <li><a href="profile.php" class="is-active"> Profile </a></li>
            <li><a href="polls.php"> Polls </a></li>
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
                <td colspan="2">
                <h2 class="subtitle">
                    Your account details are below.
                </h2>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Username:</td>
                <td><?=$_SESSION['name']?></td>
            </tr>
            <tr>
                <td>Password Hash:</td>
                <td><?=$password?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?=$email?></td>
            </tr>
        </tbody>
    </table>
    <!-- END PAGE CONTENT -->
</div>
<?= template_footer() ?>