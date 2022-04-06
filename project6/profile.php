<?php
require 'config.php';

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

<?= template_footer() ?>